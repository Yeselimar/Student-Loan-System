<?php

namespace avaa\Http\Controllers;
use Illuminate\Http\Request;
use avaa\Becario;
use avaa\Actividad;
use avaa\ActividadBecario;
use avaa\ActividadFacilitador;
use DateTime;
use Illuminate\Support\Facades\Auth;

class ActividadController extends Controller
{
	public function listar()
	{
        $actividades = Actividad::orderby('fecha','asc')->get();
        return view('sisbeca.actividad.listar')->with(compact('actividades'));
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
        return response()->json(['actividad'=>$actividad,'facilitadores'=>$facilitadores,'becarios'=>$becarios,'inscrito'=>$inscrito]);
    }

    public function actividadinscribirme($actividad_id,$becario_id)
    {
        $actividad = Actividad::find($actividad_id);
        //para inscribir verificar estatus, limite y fecha
        if( $actividad->inscribionabierta() )
        {
            $becario = Becario::find($becario_id);
            $encontrado = ActividadBecario::where('becario_id','=',$becario->user_id)->where('actividad_id','=',$actividad_id)->count();
            if($encontrado==0)
            {
                $ab = new ActividadBecario;
                $ab->actividad_id = $actividad_id;
                $ab->becario_id = $becario->user_id;
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
