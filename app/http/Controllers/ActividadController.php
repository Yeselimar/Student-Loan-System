<?php

namespace avaa\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use avaa\Http\Requests\ActividadRequest;
use File;
use DateTime;
use Validator;
use DateTimeImmutable;
use avaa\Aval;
use avaa\Becario;
use avaa\Actividad;
use avaa\ActividadBecario;
use avaa\ActividadFacilitador;

class ActividadController extends Controller
{
	public function listar()
	{
        $actividades = Actividad::orderby('fecha','asc')->get();
        return view('sisbeca.actividad.listar')->with(compact('actividades'));
	}

    //todos los justificativos
    public function listarjustificativos()
    {
        return view('sisbeca.actividad.listarjustificativos');
    }

    //todos los justificativos
    public function obtenerjustificativos()
    {
        $justificativos = Aval::justificativos()->orderby('updated_at','desc')->with("user")->with("becario")->get();
        return response()->json(['justificativos'=>$justificativos]);
    }


    //justificativos por actividad
    public function listarjustificativosactividad($id)
    {
        $actividad = Actividad::find($id);
        return view('sisbeca.actividad.justificadosporactividad')->with(compact('actividad'));
    }

    //justificativos por actividad
    public function justificativosactividad($id)
    {
        $justificativos = ActividadBecario::where('actividad_id','=',$id)->where('aval_id','!=','null')->orderby('updated_at','desc')->with("user")->with("actividad")->with("aval")->get();
        return response()->json(['justificativos'=>$justificativos]);
    }

    public function actulizarestatus(Request $request,$actividad_id,$becario_id)
    {
        $becario = Becario::find($becario_id);
        $ab = ActividadBecario::where('actividad_id','=',$actividad_id)->where('becario_id','=',$becario_id)->first();
        $ab->estatus = $request->estatus;
        $ab->save();
        return response()->json(['success'=>'Al becario '.$becario->user->nombreyapellido().' fue actualizado con el estatus '.strtoupper($request->estatus).'.']);
    }

    public function subirjustificacion($actividad_id,$becario_id)
    {
        $actividad = Actividad::find($actividad_id);
        $becario = Becario::find($becario_id);
        $model = "crear";
        return view('sisbeca.actividad.subirjustificacion')->with(compact('actividad','becario','model'));
    }

    public function guardarjustificacion(Request $request,$actividad_id,$becario_id)
    {
        $actividad = Actividad::find($actividad_id);
        $becario = Becario::find($becario_id);

        $validation = Validator::make($request->all(), ActividadRequest::cargarJustificativo());
        if ( $validation->fails() )
        {
            flash("Por favor, verifique el formulario.",'danger');
            return back()->withErrors($validation)->withInput();
        }

        $archivo= $request->file('justificativo');
        $nombre = str_random(100).'.'.$archivo->getClientOriginalExtension();
        $ruta = public_path().'/'.Aval::carpetaJustificacion();
        $archivo->move($ruta, $nombre);
        
        $aval = new Aval;
        $aval->url = Aval::carpetaJustificacion().$nombre;
        $aval->estatus = "pendiente";
        $aval->extension = ($archivo->getClientOriginalExtension()=="jpg" or $archivo->getClientOriginalExtension()=="jpeg" or $archivo->getClientOriginalExtension()=="png") ? "imagen":"pdf";
        $aval->tipo = "justificacion";
        $aval->becario_id = $becario->user_id;
        $aval->save();

        $ab = ActividadBecario::where('actividad_id','=',$actividad_id)->where('becario_id','=',$becario_id)->first();
        $ab->estatus = "por justificar";//chequear que sea asi
        $ab->aval_id = $aval->id;
        $ab->save();

        flash("El justificativo del becario ".$becario->user->nombreyapellido()." al ".$actividad->tipo." ".$actividad->nombre." fue cargado.",'success');
        return redirect()->route('actividad.detalles',$actividad->id);
    }

    public function editarjustificacion($actividad_id,$becario_id)
    {
        $actividad = Actividad::find($actividad_id);
        $becario = Becario::find($becario_id);
        $justificativo = ActividadBecario::where('becario_id','=',$becario->user_id)->where('actividad_id','=',$actividad->id)->first();
        $model = "crear";
        return view('sisbeca.actividad.subirjustificacion')->with(compact('actividad','becario','model','justificativo'));
    }

    public function actualizarjustificacion(Request $request,$actividad_id,$becario_id)
    {
        $actividad = Actividad::find($actividad_id);
        $becario = Becario::find($becario_id);
        $ab = ActividadBecario::where('becario_id','=',$becario->user_id)->where('actividad_id','=',$actividad->id)->first();
        
        $model = "crear";
        $validation = Validator::make($request->all(), ActividadRequest::actualizarJustificativo());
        
        if($request->file('justificativo'))
        {
            File::delete($ab->aval->url);
            
            $archivo= $request->file('justificativo');
            $nombre = str_random(100).'.'.$archivo->getClientOriginalExtension();
            $ruta = public_path().'/'.Aval::carpetaJustificacion();
            $archivo->move($ruta, $nombre);
            
            $aval = $ab->aval;
            $aval->url = Aval::carpetaJustificacion().$nombre;
            $aval->extension = ($archivo->getClientOriginalExtension()=="jpg" or $archivo->getClientOriginalExtension()=="jpeg"or $archivo->getClientOriginalExtension()=="png") ? "imagen":"pdf";
            $aval->save();
        }

        flash("El justificativo del becario ".$becario->user->nombreyapellido()." al ".$actividad->tipo." ".$actividad->nombre." fue actualizado.",'success');
        return redirect()->route('actividad.editarjustificacion',array('actividad_id'=>$actividad->id,'becario_id'=>$becario->user_id));
    }

    public function detalles($id)
    {
        $actividad = Actividad::find($id);
        return view('sisbeca.actividad.detalles')->with(compact('actividad'));
    }

    public function detallesservicio($id)
    {
        $actividad = Actividad::find($id);
        $facilitadores = ActividadFacilitador::where('actividad_id','=',$id)->with("user")->get();
        $becarios = ActividadBecario::where('actividad_id','=',$id)->with("user")->with("aval")->get();
        $inscrito = ActividadBecario::where('actividad_id','=',$id)->where('becario_id','=',Auth::user()->id)->count();
        $inscrito = ($inscrito==0) ? false : true;
        $estatus = (object)["0"=>"asistira", "1"=>"en espera", "2"=>"por justificar", "3"=>"asistio","4"=>"no asistio"];
        return response()->json(['actividad'=>$actividad,'facilitadores'=>$facilitadores,'becarios'=>$becarios,'inscrito'=>$inscrito,'estatus'=>$estatus]);
    }

    public function actividadinscribirme($actividad_id,$becario_id)
    {
        $actividad = Actividad::find($actividad_id);
        //para inscribir: verificar estatus, limite y fecha
        if( $actividad->inscribionabierta() )
        {
            $becario = Becario::find($becario_id);
            $encontrado = ActividadBecario::where('becario_id','=',$becario->user_id)->where('actividad_id','=',$actividad_id)->count();
            if($encontrado==0)
            {
                $ab = new ActividadBecario;
                $ab->actividad_id = $actividad_id;
                $ab->becario_id = $becario->user_id;
                //verificar la cantidad con estatus asistira
                if($actividad->totalbecarios()>=$actividad->limite_participantes)
                {
                    $ab->estatus = "en espera";
                }
                $ab->save();
                return response()->json(['tipo'=>'success','mensaje'=>'Ud. '.$becario->user->nombreyapellido().' fue inscrito en la lista de espera del '.$actividad->tipo.' '.$actividad->nombre.'.']);
            }
            else
            {
                return response()->json(['tipo'=>'danger','mensaje'=>'Disculpe, ud '.$becario->user->nombreyapellido().' ya está inscrito en el '.$actividad->tipo.' '.$actividad->nombre.'.']);
            }
        }
        else
        {
            return response()->json(['tipo'=>'danger','mensaje'=>'Disculpe, el proceso para inscribir becario está cerrado.']);
        }
    }

    public function inscribirbecario($id)
    {
        $actividad = Actividad::find($id);
        $becarios = Becario::activos()->get();
        $model = "crear";
        //if( $actividad->inscribionabierta() )
        //{
            return view('sisbeca.actividad.inscribirbecario')->with(compact('actividad','becarios','model'));
        //}
        //else
        //{
        //    flash('Disculpe, el proceso para inscribir becario está cerrado.', 'danger')->important();
        //    return back();
        //}
    }

    public function inscribirbecarioguardar(Request $request,$id)
    {
        $actividad = Actividad::find($id);
        //if( $actividad->inscribionabierta() )
        //{
            $encontrado = ActividadBecario::where('becario_id','=',$request->becario_id)->where('actividad_id','=',$id)->count();
            $becario = Becario::find($request->becario_id);
            if($encontrado==0)
            {
                $ab = new ActividadBecario;
                $ab->actividad_id = $id;
                $ab->becario_id = $request->becario_id;
                if($actividad->totalbecarios()>=$actividad->limite_participantes)
                {
                    $ab->estatus = "en espera";
                }
                $ab->save();
                flash('El becario '.$becario->user->nombreyapellido().' fue inscrito la lista de espera del '.$actividad->tipo.' '.$actividad->nombre.'.', 'success')->important();
                return redirect()->route('actividad.detalles',$id);
            }
            else
            {
                flash('Disculpe, el becario '.$becario->user->nombreyapellido().' ya está inscrito en el '.$actividad->tipo.' '.$actividad->nombre.'.', 'danger')->important();
                return redirect()->route('actividad.detalles',$id);
            }
        //}
        //else
        //{
        //    flash('Disculpe, el proceso para inscribir becario está cerrado.', 'danger')->important();
        //    return redirect()->route('actividad.detalles',$id);
        //}
    }

    public function desinscribir($actividad_id,$becario_id)
    {
        //cada vez que se desinscriba alguien, actualizo mi lista de espera
        $becario = Becario::find($becario_id);
        $actividad = Actividad::find($actividad_id);
        //if( $actividad->inscribionabierta() )
        //{
            $ab = ActividadBecario::where('actividad_id','=',$actividad->id)->where('becario_id',$becario->user->id)->first();
            $ab->delete();
            return response()->json(['tipo'=>'success','mensaje'=>'El becario '.$becario->user->nombreyapellido().' fue eliminado del '.$actividad->tipo.'.']);
        //}
        //else
        //{
        //    return response()->json(['tipo'=>'danger','mensaje'=>'Disculpe, el proceso para eliminar inscripción está cerrado.']);
        //}
    }
    public function crear()
    {
    	$model = "crear";
    	return view('sisbeca.actividad.model')->with(compact('model'));
    }

    public function guardar(Request $request)
    {
    	$request->validate([
            'nombre' 			 	=> 'required|min:5,max:255',
            'tipo'				 	=> 'required',
            'modalidad' 		 	=> 'required',
            'nivel' 			 	=> 'required',
            'anho_academico' 	 	=> 'min:0,max:255',
            'limite'  				=> 'required|integer|between:0,100',
            'horas'					=> 'required|integer|between:0,100',
            'fecha'					=> 'required|date_format:d/m/Y',
            'hora_inicio'			=> 'required|date_format:h:i A',
            'hora_fin'				=> 'required|date_format:h:i A',
            'descripcion'			=> 'min:0,max:10000',
        ]);
    	
    	$actividad = new Actividad;
    	$actividad->nombre = $request->nombre;
    	$actividad->tipo = $request->tipo;
    	$actividad->modalidad = $request->modalidad;
    	$actividad->nivel = $request->nivel;
    	$actividad->anho_academico = $request->anho_academico;
    	$actividad->limite_participantes = $request->limite;
    	$actividad->horas_voluntariado = $request->horas;
    	$actividad->fecha = DateTime::createFromFormat('d/m/Y', $request->fecha )->format('Y-m-d');
    	$actividad->hora_inicio = DateTime::createFromFormat('H:i a', $request->hora_inicio )->format('H:i:s');
    	$actividad->hora_fin = DateTime::createFromFormat('H:i a', $request->hora_fin )->format('H:i:s');
    	$actividad->descripcion = $request->descripcion;
    	$actividad->status = "disponible";
    	$actividad->save();
    	
    	//$index=0;
    	//$aux  = $request->get('facilitadores');
    	//$i=0;
    	//$tipo = gettype($request->facilitadores);
    	//$jsons = json_decode($request->facilitadores, true);
    	foreach($request->facilitadores as $facilitador)
    	{
    		//$i++;
    		//$primero = $facilitador["id"];
    		if($facilitador["becario"]=="no")
    		{
    			$af = new ActividadFacilitador;
    			$af->actividad_id = $actividad->id;
    			$af->nombreyapellido =  $facilitador["nombre"];
    			$af->save();
    		}
    		else
    		{
    			$af = new ActividadFacilitador;
    			$af->actividad_id = $actividad->id;
    			$af->becario_id = $facilitador["id"];
    			$af->save();
    		}
    	}
    	//crear actividad_facilitador
    	//$count = count($request->facilitadores);
    	return response()->json(['success'=>'La actividad fue creada exitosamente.']);
    }

    //becarios activos son los que pueden ser facilitador
    public function obtenerbecarios()
    {
    	$becarios = Becario::activos()->with("user")->get();
    	return response()->json(['becarios'=>$becarios]);
    }
}
