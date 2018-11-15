<?php

namespace avaa\Http\Controllers;

use avaa\Desincorporacion;
use avaa\Imagen;
use avaa\Nomina;
use Illuminate\Http\Request;
use avaa\Http\Controllers\Controller;
use avaa\Mentor;
use avaa\User;
use avaa\Becario;
use avaa\Documento;
use DateTime;

use avaa\Concurso;
use Timestamp;
class DirectivoController extends Controller
{

    public function __construct()
    {
        $this->middleware('directivo');
    }

    public function agregarObservacion(Request $request, $id)
    {
      
        $becario = Becario::find($id);
        $becario->observacion = $request->get("observaciones");
        $becario->save();
        return redirect()->route('perfilPostulanteBecario',$id);
       
    }

    public function cambioStatusEntrevistado($id)
    {
        $becario=Becario::query()->where('user_id','=',$id)->where('status','=','entrevista')
            ->where('acepto_terminos','=',1)->where('fecha_entrevista','<>',null)
            ->first();

        if(!is_null($becario))
        {
            $becario->status= 'entrevistado';
            $becario->save();
            flash($becario->user->name.' '.$becario->user->last_name.' ha sido marcado como entrevistado.','success')->important();
        }
        else
        {
            flash('Disculpe, ha forzado la información incorrecta','danger')->important();
        }

        return  redirect()->route('listarPostulantesBecarios',"1");

    }
    public function aprobarParaEntrevista(Request $request, $id)
    {
       
        $postulante = Becario::find($id);
        if($postulante->status==='postulante')
        {
            if ($request->valor === '1') {
                $postulante->status = 'entrevista';
                $postulante->acepto_terminos ='0';
                $postulante->save();
            flash( $postulante->user->name . ' ha sido aprobado para ir a entrevista. ', 'success')->important();
            }
            else
            {
                $postulante->status='rechazado';
                $postulante->save();
                flash( $postulante->user->name . ' ha sido rechazado como para ir a entrevista. ', 'danger')->important();
            }
        }
        return  redirect()->route('listarPostulantesBecarios',"2");

    }
 
    public function cambioStatus(Request $request)
    {
        $postulantes = Becario::query()->where('status', '=','entrevistado')->where('acepto_terminos', '=',true)->get();
        $i=0;
        foreach($postulantes as $postulante)
        {
            if($request->get('all') == 1 )
            {
                //para que guarde todos
                $i++;
                $postulante->status='activo';
                $postulante->acepto_terminos=false;
                $postulante->save();
                $usuario=User::find($postulante->user_id);
                $usuario->rol = 'becario';
                $usuario->save();  
             }
            else if($request->get($postulante->user_id) == 1 )//cuando está check
            {
                $i++;
                $postulante->status='activo';
                $postulante->acepto_terminos=false;
                $postulante->save();
                $usuario=User::find($postulante->user_id);           
                $usuario->rol = 'becario';
                $usuario->save(); 
               //falta: enviar correo al becario con su fecha de entrevista
            }     
        }

        if($i>0)
        {
            flash('Se ha agregado becario(s) exitosamente.','success');
        }
        else
        {
            flash('Disculpe, debe seleccionar al menos un postulante', 'danger');
        }
        return  redirect()->route('listarPostulantesBecarios',"3");
    }

    public function finalizarConcursoMentor()
    {
        $concursos = Concurso::query()->where('status','=','abierto')->where('tipo','=','mentores')->orWhere('status','=','cerrado')->first();
        $postulante = User::query()->where('rol', '=','rechazado')->delete();
        //falta: Estos mentores no deben ser eliminados durante 15 dias

        if(!is_null($concursos))
        {
            $concursos->status='finalizado';
            $concursos->save();
            flash('El proceso de postulaciones a mentor ha finalizado satisfactoriamente', 'success')->important();
                 return redirect()->route('sisbeca');
        }
        else
        {
            flash('El proceso de postulaciones a mentor se encuentra finalizado')->important();
             return redirect()->route('sisbeca');
        }
    }

/*
    public function finalizarConcurso()
    {
    	   //Averiguo que id tiene el Directivo
   $usuario=User::query()->where('rol','=','directivo')->first();
   $concursos = Concurso::query()->where('status','=','abierto')->where('tipo','=','becarios')->orWhere('status','=','cerrado')->first();

   Becario::where('status','=','activo')->orwhere('status','=','entrevista')->orwhere('status','=','rechazado')->orwhere('status','=','postulante')->orwhere('status','=','prepostulante')->update(array('coordinador_id' => $usuario->id));
   
   User::where('rol','=','postulante_becario')->orwhere('rol','=','coordinador')->delete(); 


     $postulantes= Becario::query()->where('status','=','postulante')->get();
     $becarios = Becario::query()->where('status','<>','desincorporado')->where('status','<>','egresado')->get();
    // $directivo=User::query()->where('rol','=','directivo')->first();
   //  $coordinadores= Coordinador::query()->where('user_id','<>', $directivo->id)->get();

     $cant_becarios=count($becarios);

     $cant_coord=$cant_becarios/50;

      if($cant_coord<3){
        $cant_coord=3;
     }
     else{
        $cant_coord=ceil($cant_coord);
        $cant_coord=intval($cant_coord);
     }
     
     $numerobecarios=$cant_becarios/$cant_coord; //cantidad de becarios por coordinador
     
    // $numerobecarios=round($cant_coord, 0, PHP_ROUND_HALF_DOWN);// se sustituye por la linea de abajo
     $numerobecarios= floor($numerobecarios);

	$numerobecarios = intval($numerobecarios); // convertirlo a entero
     
     $becariosrestantes= $cant_becarios%$cant_coord;

   //Asigno ese directivo como coordinador temporal
    //Creo los nuevos coordinadores
       
   
   for ($k=1; $k<=$cant_coord; $k++) {
        
        $usuario = new User;
        $usuario->name='coord'.$k;
        $usuario->rol = 'coordinador';
        $usuario->email= 'coord'.$k.'@avaa.com';
        $usuario->password=bcrypt('123456');
        $usuario->save();
        $coordinador = new Coordinador;
        $coordinador->user_id = $usuario->id;
        $coordinador->save();
    }
   $i=0;
   $j=0;

    $directivo=User::query()->where('rol','=','directivo')->first();
     $coordinadores= Coordinador::query()->where('user_id','<>', $directivo->id)->get();

   $k=1;
   foreach ($coordinadores as $coordinador) {

     for ($j=$i; $j<$numerobecarios*$k; $j++,$i++) {
       $becarios->get($j)->coordinador_id = $coordinador->user_id;
        $becarios->get($j)->save();
      }
      
      $k++;
   }

 
//Asigno los becarios restantes
   for ($k=0; $k<$becariosrestantes; $k++) {
           
        $becarios->get($j)->coordinador_id = $coordinadores->get($k)->user_id;
        $becarios->get($j)->save();
  
        $j++;
    }
        flash('El Concurso al programa de ProExcelecia ha finalizado satisfactoriamente', 'success')->important();


   //finalizar Concurso
        $concursos->status='finalizado';
        $concursos->save();

 //return view('sisbeca.postulaciones.asignarNuevoIngreso')->with('becarios',$postulantes)->with('coordinadores',$coordinadores)->with('concursos',$concursos);

        return redirect()->route('sisbeca');

}*/

    public function perfilPostulanteBecario($id)
    {
        $postulante = Becario::find($id);
        $usuario = User::find($postulante->user_id);
        $documentos = Documento::query()->where('user_id','=',$id)->get();
        $img_perfil=Imagen::query()->where('user_id','=',$id)->where('titulo','=','img_perfil')->get();
       
        if(is_null($documentos))
        {
           flash('Disculpe, el postulante seleccionado no tiene documentos.', 'danger')->important();
        }
        else
        {
            $fotografia = Imagen::where('user_id','=',$id)->where('titulo','=','fotografia')->first();
            $cedula = Imagen::where('user_id','=',$id)->where('titulo','=','cedula')->first();
            $constancia_cnu = Documento::where('user_id','=',$id)->where('titulo','=','constancia_cnu')->first();
            $calificaciones_bachillerato = Documento::where('user_id','=',$id)->where('titulo','=','calificaciones_bachillerato')->first();
            $constancia_aceptacion = Documento::where('user_id','=',$id)->where('titulo','=','constancia_aceptacion')->first();
            $constancia_estudios = Documento::where('user_id','=',$id)->where('titulo','=','constancia_estudios')->first();
            $calificaciones_universidad = Documento::where('user_id','=',$id)->where('titulo','=','calificaciones_universidad')->first();
            $constancia_trabajo = Documento::where('user_id','=',$id)->where('titulo','=','constancia_trabajo')->first();
            $declaracion_impuestos = Documento::where('user_id','=',$id)->where('titulo','=','declaracion_impuestos')->first();
            $recibo_pago = Documento::where('user_id','=',$id)->where('titulo','=','recibo_pago')->first();
            $referencia_profesor1 = Documento::where('user_id','=',$id)->where('titulo','=','referencia_profesor1')->first();
            $referencia_profesor2 = Documento::where('user_id','=',$id)->where('titulo','=','referencia_profesor2')->first();
            $ensayo = Documento::where('user_id','=',$id)->where('titulo','=','ensayo')->first();
            return view('sisbeca.postulaciones.perfilPostulanteBecario')->with('postulante',$postulante)->with('documentos', $documentos)->with('usuario',$usuario)->with('fotografia',$fotografia)->with('cedula',$cedula)->with('constancia_cnu',$constancia_cnu)->with('calificaciones_bachillerato',$calificaciones_bachillerato)->with('constancia_aceptacion',$constancia_aceptacion)->with('constancia_estudios',$constancia_estudios)->with('calificaciones_universidad',$calificaciones_universidad)->with('constancia_trabajo',$constancia_trabajo)->with('declaracion_impuestos',$declaracion_impuestos)->with('recibo_pago',$recibo_pago)->with('referencia_profesor1',$referencia_profesor1)->with('referencia_profesor2',$referencia_profesor2)->with('ensayo',$ensayo)->with('img_perfil',$img_perfil);
        }
    }

    public function listarPostulantesBecarios($data)
    {
        $concursos = Concurso::query()->get();
        if($data==0)
        { 
            //Lista los q no tienen entrevista
            $becarios = Becario::query()->where('status','=','entrevista')->where('acepto_terminos','=',$data)->get();
        }

        if($data==2)
        { 
            //Lista a todos los postulantes
		    $becarios = Becario::query()->where('status','=','postulante')->orwhere('status','=','entrevista')->orwhere('status','=','rechazado')->get(); //Falta cuando en user esta rechazado
        }
        else if(($data==1))
        { 
        //lista los que ya tienen entrevista
            $becarios = Becario::query()->where('status','=','entrevista')->where('acepto_terminos','=',true)->get();	    

        }
        else if($data==3)
        {
            $becarios = Becario::query()->where('status','=','entrevistado')->where('acepto_terminos','=',true)->get();
        }

        if($data==0)
        { 
            return view('sisbeca.postulaciones.entrevistas')->with('becarios',$becarios)->with('becarios',$becarios)->with('concursos',$concursos);
        }
        else if($data==1)
        { 
            //Ver y Editar Entrevistas
            return view('sisbeca.postulaciones.verModificarEntrevistas')->with('becarios',$becarios)->with('becarios',$becarios)->with('concursos',$concursos);
        }
        else if($data==2)
        { 
            //ver todos los postulantes
            return view('sisbeca.postulaciones.verPostulantesBecario')->with('becarios',$becarios)->with('becarios',$becarios)->with('concursos',$concursos);
        }

        else if($data==3)
        { 
            //Asignar a los nuevos becarios
            return view('sisbeca.postulaciones.asignarNuevoIngreso')->with('becarios',$becarios)->with('concursos',$concursos);
        }
    }

    public function asignacionEntrevistas(Request $request)
    {
        $becarios = Becario::query()->where('status','=','entrevista')->where('acepto_terminos','=',false)->get();
        $i=0;
        foreach($becarios as $becario)
        {
        	if($request->get('all') == 1 )
            {
                //para que guarde todos
                $i++;
                $becario->fecha_entrevista = DateTime::createFromFormat('d/m/Y', $request->get('fechaentrevista'));
                $becario->acepto_terminos=true;
                $becario->save();
            }
            else if($request->get($becario->user_id) == 1 )//cuando está check
            {
                $i++;
                $becario->fecha_entrevista = DateTime::createFromFormat('d/m/Y', $request->get('fechaentrevista'));
                $becario->acepto_terminos=true;
                $becario->save();
               //falta: enviar correo al becario con su fecha de entrevista 
            }
        }
        if($i>0)
        {
            flash('Se han asignado las citas para el día '. $request->get('fechaentrevista'). ' exitosamente!');
        }
        else
        {
            flash('Disculpe, debe seleccionar al menos un postulante a becario.', 'danger');

        }
        return  redirect()->route('listarPostulantesBecarios',"0");
    }

    public function modificarEntrevistas(Request $request)
    {
        $becarios = Becario::query()->where('status','=','entrevista')->where('acepto_terminos','=',true)->get();
        $i=0;
        foreach($becarios as $becario)
        {
            if($request->get('all') == 1 )
            {//para que guarde todos
                $i++;
                $becario->fecha_entrevista = DateTime::createFromFormat('d/m/Y', $request->get('fechaentrevista'));
                $becario->acepto_terminos=true;
                $becario->save();
            }
            else if($request->get($becario->user_id) == 1 )//cuando está check
            {
                $i++;
                $becario->fecha_entrevista = DateTime::createFromFormat('d/m/Y', $request->get('fechaentrevista'));
                $becario->acepto_terminos=true;
                $becario->save();
               //falta: enviar correo al becario con su fecha de entrevista
            }     
        }
        if($i>0)
        {
            flash('Se han re-asignado las citas para el día '. $request->get('fechaentrevista'). ' exitosamente!');
        }
        else
        {
            flash('Disculpe, debe seleccionar al menos un postulante a becario', 'danger');
        }

        return  redirect()->route('listarPostulantesBecarios',"1");
    }

    public function listarMentores()
    {
        //busco solo los mentores que sean validos en la tabla mentor ya que l primer registro siempre es el mentor borrador
        $mentores = Mentor::all();
        if($mentores->count()>0)
        {
            $mentores->each(function ($mentores)
            {
                $mentores->becarios;
                foreach ($mentores->becarios as $becario) {
                    $becario->user;
                }
            });
        }
        else
        {
            flash('Disculpe, no existen mentores registrados','danger');
        }
        return view('sisbeca.mentores.listar')->with('mentores',$mentores);
    }

    public function actualizarPostulanteMentor(Request $request, $id)
    {
        $postulante = User::find($id);
        if($postulante->rol==='postulante_mentor')
        {
            if ($request->valor === '1')
            {
                $postulante->rol = 'mentor';
                $postulante->save();
                $mentor = new Mentor();
                $mentor->user_id = $id;
                $mentor->save();
                flash($postulante->name . ' ha sido registrado como mentor exitosamente', 'success')->important();
                //FALTA: AQUI SE ENVIA UN CORREO AL NUEVO MENTOR
            }
            else
            {
                // $postulante->delete();
                //falta borrar su hoja de vida si es rechazado
                $postulante->rol='rechazado';
                flash('!' . $postulante->name . ' ha sido rechazado como mentor.', 'danger')->important();
                $postulante->save();
            }
        }
        return  redirect()->route('listarPostulantesMentores');
    }

    public function listarPostulantesMentores()
    {
        $postulantes = User::query()->where('rol','=','postulante_mentor')->orWhere('rol','=','rechazado')->get();
      
             if(($postulantes->count()==0))
            {
                flash('Disculpe, no existen mentores postulados','danger');
                
            }
       
        return view('sisbeca.postulaciones.postulantesMentores')->with('users',$postulantes);   
    }

    public function perfilPostulantesMentores($id)
    {
        $postulante = User::find($id);

        if(!is_null($postulante) &&$postulante->rol==='postulante_mentor'||$postulante->rol==='rechazado')
        {
            if (is_null($postulante)) {
                flash('Disculpe, el archivo solicitado no fue encontrado', 'danger')->important();
                return back();
            }
            $img_perfil_postulante=Imagen::query()->where('user_id','=',$postulante->id)->where('titulo','=','img_perfil')->get();
            $documento = Documento::query()->where('user_id', '=', $id)->where('titulo', '=', 'hoja_vida')->first();

        }
        else
        {
            flash('Disculpe, el archivo solicitado no fue encontrado', 'danger')->important();
            return  redirect()->route('listarPostulantesMentores');
        }

        return view('sisbeca.postulaciones.perfilPostulanteMentor')->with('postulanteMentor',$postulante)->with('documento', $documento)
            ->with('img_perfil_postulante',$img_perfil_postulante);
    }

    public function listarBecariosInactivos()
    {
        $becarios = Becario::query()->where('acepto_terminos', '=', true)->where('status', ['inactivo'])->get();
        if($becarios->count()==0)
        {

            flash('Disculpe, no existen becarios inactivos en el sistema','danger');
        }
        return view('sisbeca.becarios.egresados.listarInactivos')->with('becarios',$becarios);
    }

    public function listarBecariosGraduados()
    {
        $becarios = Becario::query()->where('acepto_terminos', '=', true)->where('status', ['egresado'])->get();
        if($becarios->count()==0) {

            flash('Disculpe, no existen becarios graduados en el sistema.','danger');
        }
        return view('sisbeca.becarios.egresados.listarGraduados')->with('becarios',$becarios);
    }

    public function procesarDesincorporacion($user_id,$id)
    {
        $user= User::find($user_id);
        $desincorporacion= Desincorporacion::find($id);
        if($user->rol==='becario')
        {
            if($user->becario->status==='desincorporado')
            {
                $nomina=Nomina::query()->where('status','=','pendiente')->get();
                if($nomina->count()>0)
                {
                    flash('Disculpe, actualmente tiene nomina(s) pendiente(s) por ser procesada(s) le invitamos procesar dicha(s) nominas y luego proceder con la desincorporacion del becario','danger')->important();
                }
                else
                {
                    $user->rol='becario desincorporado';
                    $user->save();
                    $desincorporacion->status='ejecutada';
                    $desincorporacion->save();
                    flash('El Becario '.$user->name.' '.$user->last_name.' ha sido desincorporado exitosamente.','danger')->important();

                }
            }
        }
        else
        {
            if($user->rol==='mentor')
            {
                if($user->mentor->status==='desincorporado')
                {
                    $user->rol='mentor desincorporado';
                    $user->save();
                    $desincorporacion->status='ejecutada';
                    $desincorporacion->save();
                    flash('El Mentor '.$user->name.' '.$user->last_name.' ha sido desincorporado exitosamente.','info')->important();
                }
            }
            else
            {
                flash('Disculpe, el archivo no fue encontrado','danger')->important();
                return back();
            }
        }
        return redirect()->route('desincorporaciones.listar');
    }

    public function listarDesincorporaciones()
    {
        $desincorporacionesSolicitud = Desincorporacion::query()->where('tipo','solicitud')->get();
        $desincorporacionesSistema = Desincorporacion::query()->where('tipo','sistema')->get();
        return view('sisbeca.desincorporaciones.procesarDesincorporaciones')->with('desincorporacionesSolicitud',$desincorporacionesSolicitud)->with('desincorporacionesSistema',$desincorporacionesSistema);
    }
}
