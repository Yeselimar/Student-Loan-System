<?php

namespace avaa\Http\Controllers;

use avaa\Coordinador;
use avaa\Desincorporacion;
use avaa\User;
use Barryvdh\DomPDF\Facade as PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;
use avaa\Becario;
use avaa\Mentor;
use avaa\Alerta;
use avaa\Solicitud;
use avaa\Documento;
use avaa\Imagen;
use avaa\Events\SolicitudesAlerts;
use Illuminate\Support\Facades\Auth;

use avaa\Concurso;

class CompartidoDirecCoordController extends Controller
{
    public function __construct()
    {
        $this->middleware('compartido_direc_coord');
    }
    public function agregarObservacion(Request $request, $id)
    {
      
        $becario = Becario::find($id);
        $becario->observacion = $request->get("observaciones");
        $becario->save();
        return redirect()->route('perfilPostulanteBecario',$id);
       
    }
    public function obtener_entrevistados()
    {
        $postulantes = Becario::where('status','=','entrevistado')->orwhere('status','=','rechazado')->orwhere('status','=','activo')->where('acepto_terminos','=',false)->with("user")->with('entrevistadores')->with('imagenes')->get();
        return response()->json(['postulantes'=>$postulantes]);
    }
    //viejo-aun en uso
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
    public function cambiostatusentrevistado(Request $request)
    {
        $postulanteBecario = Becario::find($request->id);
       /* $becario=Becario::query()->where('user_id','=',$request->id)->where('status','=','entrevista')
            ->where('acepto_terminos','=',0)->where('fecha_entrevista','<>',null)
            ->first();*/

        if(!is_null($postulanteBecario))
        {
            $postulanteBecario->status= 'entrevistado';
            $postulanteBecario->save();
            flash($postulanteBecario->user->name.' '.$postulanteBecario->user->last_name.' ha sido marcado como entrevistado.','success')->important();
            
        }
        else
        {
            flash('Disculpe, ha forzado la información incorrecta','danger')->important();
        }
        return response()->json(['success'=>'El Estatus de la Entrevista ha sido Cambiado Exitosamente']);

    }
    public function veredictoPostulantesBecarios(Request $request)
    {
        $postulanteBecario = Becario::find($request->id);
        if($request->funcion=='Aprobar'){
            $postulanteBecario->status='activo';
            $postulanteBecario->acepto_terminos=false;
            $postulanteBecario->save();
            /* $usuario=User::find($id);
            $usuario->rol = 'becario';
            $usuario->save();*/
        return response()->json(['success'=>'El Postulante ha sido Aceptado Exitosamente']);
       }else{
            $postulanteBecario->status='rechazado';
            $postulanteBecario->acepto_terminos=false;
            $postulanteBecario->save();
        return response()->json(['success'=>'El Postulante ha sido Rechazado Exitosamente']);
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
            //$becarios = Becario::query()->where('status','=','postulante')->orwhere('status','=','entrevista')->orwhere('status','=','rechazado')->get(); //Falta cuando en user esta rechazado
            $becarios= Becario::where('status','=','postulante')->orwhere('status','=','rechazado')->orwhere('status','=','activo')->where('acepto_terminos','=',false)->get();
            //dd($becarios);
        }
        else if(($data==1))
        { 
        //lista los que ya tienen entrevista
            $becarios = Becario::query()->where('status','=','entrevista')->where('acepto_terminos','=',true)->get();	    

        }
        else if($data==3)
        {
            $becarios = Becario::where('status','=','entrevistado')->orwhere('status','=','rechazado')->orwhere('status','=','activo')->where('acepto_terminos','=',false)->get();
           // $becarios = Becario::query()->where('status','=','entrevistado')->where('acepto_terminos','=',false)->get();
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

    public function listarBecarios()
    {
        if( Auth::user()->rol==='directivo' or Auth::user()->rol==='coordinador')
        {
            $becarios = Becario::query()->where('acepto_terminos', '=', true)->whereIn('status', ['probatorio1', 'probatorio2', 'activo','inactivo'])->get();        
        }
        if($becarios->count()>0)
        {
            $becarios->each(function ($becarios)
            {
                if($becarios->mentor_id!=null)
                {
                    $becarios->mentor->user;
                }

            });
        }
        else
        {
            flash('Disculpe, no existen becarios registrados.','danger');
        }
        return view('sisbeca.becarios.listar')->with('becarios',$becarios);
    }

    public function listarMentores()
    {
        $mentores = Mentor::all();
        if($mentores->count()>0)
        {
            $mentores->each(function ($mentores)
            {
                $mentores->becarios;
                foreach ($mentores->becarios as $becario)
                {

                    $becario->user;
                }
            });

        }
        else
        {
            flash('Disculpe, no existen mentores registrados.','danger');
        }
        return view('sisbeca.mentores.listar')->with('mentores',$mentores);
    }


    public function listarSolicitudes()
    {
        $becariosAsignados = Becario::query()->where('acepto_terminos', '=', true)->whereIn('status', ['probatorio1', 'probatorio2', 'activo','inactivo'])->get();   
        $listaBecariosA=$becariosAsignados->pluck('user_id')->toArray();
        if(Auth::user()->rol==='directivo' or Auth::user()->rol==='coordinador')
        {
            $mentoresNuevos= Mentor::all();
            $collection = collect();
            foreach ($mentoresNuevos as $mentor)
            {
                if($mentor->becarios()->count()==0)
                {
                    $collection->push($mentor);
                }
            }
        }
        else
        {
            $collection = collect();
            foreach ($becariosAsignados as $beca)
            {
                $collection->push($beca->mentor);
            }
        }
        $listMentoresA = $collection->pluck('user_id')->toArray();
        $mentoresAsignados = Mentor::query()->whereIn('user_id', $listMentoresA)->get();
        $listaMentoresA = $mentoresAsignados->pluck('user_id')->toArray();
        $solicitudes = Solicitud::query()->whereIn('user_id',$listaBecariosA)->orWhereIn('user_id',$listaMentoresA)->get();
        return view('sisbeca.gestionSolicitudes.listarSolicitudes')->with('solicitudes',$solicitudes);
    }

    public function revisarSolicitud($id)
    {
        $solicitudes = Solicitud::find($id);

        /*$alerta= Alerta::query()->select()->where('solicitud','=',$id)->first();
        $alerta->leido=true;
        $alerta->save();*/

        $img_perfil_postulante=Imagen::query()->where('user_id','=',$solicitudes->user_id)->where('titulo','=','img_perfil')->get();

        return view('sisbeca.gestionSolicitudes.procesarSolicitud')->with('solicitud',$solicitudes)->with('img_perfil_postulante',$img_perfil_postulante);
    }

    public function gestionSolicitudUpdate(Request $request, $id)
    {
        $solicitud = Solicitud::find($id);
        if(Auth::user()->rol==='directivo' or Auth::user()->rol==='coordinador')
        {
            $becariosAsignados = Becario::query()->where('acepto_terminos', '=', true)->whereIn('status', ['probatorio1', 'probatorio2', 'activo','inactvo'])->get();
            $listaBecariosA = $becariosAsignados->pluck('user_id')->toArray();
            $clave = array_search($solicitud->user_id, $listaBecariosA); // me devuelve falso si  no encontro elemento
            $mentoresNuevos= Mentor::all();
            $collection = collect();
            foreach ($mentoresNuevos as $mentor)
            {
                if($mentor->becarios()->count()==0)
                {
                    $collection->push($mentor);
                }
            }
        }
        
        $listMentoresA = $collection->pluck('user_id')->toArray();
        $mentoresAsignados = Mentor::query()->whereIn('user_id', $listMentoresA)->get();
        $listaMentoresA = $mentoresAsignados->pluck('user_id')->toArray();
        $clave1 = array_search($solicitud->user_id, $listaMentoresA); // me devuelve falso si  no encontro elemento
        if (is_bool($clave) && is_bool($clave1))
        {
            flash('Error el archivo solicitado no existe**', 'danger')->important();
            return back();
        }

        if($request->get('valor')==='1')
        {
            flash('La solicitud de '.$solicitud->user->name.' ha sido aprobada exitosamente','success')->important();

            if($solicitud->user->rol==='becario')
                $instancia= Becario::query()->select()->where('user_id','=',$solicitud->user_id)->first();
            else
            {
                $instancia= Mentor::query()->select()->where('user_id','=',$solicitud->user_id)->first();
            }

            if($solicitud->titulo==='desincorporacion temporal')
            {
                $instancia->status='inactivo';
                if($solicitud->user->rol==='becario')
                {
                    $instancia->fecha_inactivo= date('Y-m-d');
                    $instancia->observacion_inactivo= $solicitud->descripcion;
                }
                else
                {
                    $becariosT= Becario::query()->where('mentor_id','=',$instancia->user_id)->get();
                    foreach ($becariosT as $becario)
                    {
                        //$becario->mentor_id= Mentor::first()->user_id;
                        $becario->save();
                    }
                }
                flash($instancia->user->name.' Ha sido desincorporado temporalmente en el sistema','info')->important();
            }
            else
            {
                if($solicitud->titulo==='desincorporacion definitiva')
                {
                    $instancia->status='desincorporado';
                    if($solicitud->user->rol==='becario')
                    {
                        $instancia->mentor_id = null;
                    }
                    else
                    {
                        $becariosT= Becario::query()->where('mentor_id','=',$instancia->user_id)->get();

                        foreach ($becariosT as $becario)
                        {
                            $becario->mentor_id= null;
                            $becario->save();
                        }
                    }
                    $desincorporacion= new Desincorporacion();

                    $desincorporacion->tipo='solicitud';
                    $desincorporacion->observacion= 'El motivo de la gestion de desincorporacion radica en que el usuario: '.$instancia->user->name.' '.$instancia->user->last_name.' solicito dicha desincorporación la cual fue evaluada y aceptada por el consejo.';
                    $desincorporacion->user_id= $instancia->user->id;
                    $desincorporacion->datos_nombres= $instancia->user->name;
                    $desincorporacion->datos_apellidos= $instancia->user->last_name;
                    $desincorporacion->datos_email= $instancia->user->email;
                    $desincorporacion->datos_cedula= $instancia->user->cedula;
                    $desincorporacion->datos_rol= $instancia->user->rol;
                    $desincorporacion->gestionada_por= Auth::user()->id;
                    $desincorporacion->fecha_gestionada= date('Y-m-d');
                    $desincorporacion->save();

                    /*Enviar Alerta al directivo */

                    //primero veo si la alerta existe
                    /*
                    $alerta= Alerta::query()->where('user_id','=', Coordinador::first()->user_id)->where('titulo','=','Desincorporacion(es) pendiente(s) por procesar')->where('status','=','enviada')->first();

                    if(!is_null($alerta))
                    {
                        $alerta->leido=false;
                        $alerta->save();
                    }
                    else
                    {
                        $alerta = new  Alerta();

                        $alerta->titulo= 'Desincorporacion(es) pendiente(s) por procesar';
                        $alerta->Descripcion= 'Tiene Desincorporacion(es) pendiente(s) por procesar, se le aconseja procesar las desincorporaciones que tiene pendiente en el Menu de Desincorporaciones->Desincorporacion';
                        $alerta->user_id= Coordinador::first()->user_id;
                        $alerta->nivel='alto';
                        $alerta->save();
                    }
                    flash($instancia->user->name.' Ha sido enviado para desincorporacion definitiva en el sistema','info')->important();
                    */

                }
                else
                {
                    if($solicitud->titulo==='reincorporacion')
                    {
                        $instancia->status='activo';
                        flash($instancia->user->name.' Ha sido Reincorporado nuevamente al Programa AVAA','info')->important();

                    }
                }

            }
            $solicitud->status='aceptada';
            $instancia->save();

        }
        else
        {
            $solicitud->status='rechazada';
            flash('La solicitud de '.$solicitud->user->name.' ha sido rechazada','info')->important();
        }


        $solicitud->usuario_respuesta= Auth::user()->id;
        $solicitud->save();
        event(new SolicitudesAlerts($solicitud));

        return  redirect()->route('gestionSolicitudes.listar');

    }

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
    public function verPerfilMentor($id){
        $mentor= Mentor::find($id);

        $img_perfil=Imagen::query()->where('user_id','=',$mentor->user_id)->where('titulo','=','img_perfil')->get();
        $documento = Documento::query()->where('user_id', '=', $mentor->user_id)->where('titulo', '=', 'hoja_vida')->first();

        return view('sisbeca.mentores.perfilMentor')->with('mentor',$mentor)->with('img_perfil',$img_perfil)->with('documento',$documento);
    }

    public function formularioReporteSolicitudes()
    {
        $users= User::query()->whereIn('rol',['mentor','becario'])->get();
        return view('sisbeca.solicitudes.formularioReporteSolicitudes')->with('users',$users);
    }
    public function solicitudespdf(Request $request)
    {
        $data= explode ('/',$request->get('fechaDesde'));
        $fechaDesde= Carbon::createFromDate($data[2],$data[1],$data[0])->format('Y-m-d');
        $data= explode ('/',$request->get('fechaHasta'));
        $fechaHasta= Carbon::createFromDate($data[2],$data[1],$data[0])->format('Y-m-d');

        $user= $request->get('user_id');

        if($user==0)
        {
            $solicitudes = Solicitud::query()->whereDate('updated_at','>=',$fechaDesde)->whereDate('updated_at','<=',$fechaHasta)->get();

        }else {
            $solicitudes = Solicitud::query()->where('user_id', '=', $user)->whereDate('updated_at','>=',$fechaDesde)->whereDate('updated_at','<=',$fechaHasta)->get();
        }

        if($solicitudes->count()==0){
            flash('No existe data con los parametros establecidos para generar el reporte','danger')->important();
            return redirect()->route('formularioReporte.solicitudes');
        }
        else
        {
            flash('Reporte ejecutado Exitosamente haga click en el boton generar pdf para visualizarlo','success')->important();

        }

        $users= User::query()->whereIn('rol',['mentor','becario'])->get();
        return view('sisbeca.solicitudes.formularioReporteSolicitudes')->with('users',$users)->with('user_id',$user)->with('fechaDesde',$fechaDesde)->with('fechaHasta',$fechaHasta);

    }

    public function pdfSolicitud($fechaDesde,$fechaHasta,$user_id){
        if($user_id==0)
        {
            $solicitudes = Solicitud::query()->whereDate('updated_at','>=',$fechaDesde)->whereDate('updated_at','<=',$fechaHasta)->get();

        }else {
            $solicitudes = Solicitud::query()->where('user_id', '=', $user_id)->whereDate('updated_at','>=',$fechaDesde)->whereDate('updated_at','<=',$fechaHasta)->get();
        }

        if($solicitudes->count()==0){
            flash('No existe data con los parametros establecidos para generar el reporte','danger')->important();
            return redirect()->route('formularioReporte.solicitudes');
        }

        switch (date('m')) {
            case 1:
                $mes= 'Enero';
                break;
            case 2:
                $mes=  'Febrero';
                break;
            case 3:
                $mes= 'Marzo';
                break;
            case 4:
                $mes=  'Abril';
                break;
            case 5:
                $mes=  'Mayo';
                break;
            case 6:
                $mes=  'Junio';
                break;
            case 7:
                $mes=  'Julio';
                break;
            case 8:
                $mes=  'Agosto';
                break;
            case 9:
                $mes=  'Septiembre';
                break;
            case 10:
                $mes=  'Octubre';
                break;
            case 11:
                $mes=  'Noviembre';
                break;
            case 12:
                $mes=  'Diciembre';
                break;
        }

        $pdf = PDF::loadView('sisbeca.solicitudes.reporteDeSolicitudes', compact('solicitudes','mes','fechaDesde','fechaHasta'));

        return $pdf->stream('reporteDeSolicitudes.pdf', 'PDF xasa');
    }
}
