<?php

namespace avaa\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;
use avaa\Periodo;
use avaa\Aval;
use avaa\Becario;
use avaa\Http\Requests\PeriodosRequest;
use Validator;
use Illuminate\Support\Facades\Storage;
use File;
use Intervention\Image\ImageManagerStatic as Image;


class PeriodosController extends Controller
{
	public function getEstatusAval()
	{
		$estatusaval = ['0'=>'pendiente','1'=>'aceptada','2'=>'negada'];
		return response()->json(['estatusaval'=>$estatusaval]);
	}

	public function todosperiodos()
	{
		$periodos = Periodo::orderby('created_at','desc')->get();
		return view('sisbeca.periodos.todos')->with(compact('periodos'));
	}

	public function verconstancia($id)
	{
		//return response()->file(Periodo::find(7)->aval->url);
		//return  response(asset(Periodo::find($id)->aval->url), 200)->header('Content-Type', 'image/jpg');
	}

    public function listar()
    {
    	$periodos = Periodo::where('becario_id','=',Auth::user()->id)->get();
    	return view('sisbeca.periodos.index')->with(compact('periodos'));
    }

    public function crear($id)
    {
    	$model = 'crear';
	    $becario = Becario::find($id);
	    return view('sisbeca.periodos.model')->with(compact('model','becario'));
    }

    public function guardar(Request $request,$id)
    {
    	if( (Auth::user()->esBecario() and Auth::user()->id==$id) )
    	{
	    	$validation = Validator::make($request->all(), PeriodosRequest::rulesCreate());
			if ( $validation->fails() )
			{
				flash("Por favor, verifique el formulario.",'danger');
				return back()->withErrors($validation)->withInput();
			}
	        
            if($request->file('constancia'))
            {
        		$archivo= $request->file('constancia');
	            $nombre = str_random(100).'.'.$archivo->getClientOriginalExtension();
	            $ruta = public_path().'/'.Aval::carpetaConstancia();
	            $archivo->move($ruta, $nombre);
            }
            
			$aval = new Aval;
			$aval->url = Aval::carpetaConstancia().$nombre;
			$aval->estatus = "pendiente";
			$aval->extension = ($archivo->getClientOriginalExtension()=="jpg" or $archivo->getClientOriginalExtension()=="jpeg"or $archivo->getClientOriginalExtension()=="png") ? "imagen":"pdf";
			$aval->tipo = "constancia";
			$aval->becario_id = $id;
			$aval->save();

			$periodo = new Periodo;
			$periodo->numero_periodo = $request->get('numero_periodo');
    		$periodo->anho_lectivo = $request->get('anho_lectivo');
    		$periodo->fecha_inicio = DateTime::createFromFormat('d/m/Y', $request->get('fecha_inicio'))->format('Y-m-d');
    		$periodo->fecha_fin = DateTime::createFromFormat('d/m/Y', $request->get('fecha_fin'))->format('Y-m-d');
    		$periodo->becario_id = $id;
    		$periodo->aval_id = $aval->id;
    		$periodo->save();
			
			flash("El periodo fue creado exitosamente.",'success');
	    	return redirect()->route('periodos.listar');
	    	
	    }
		else
		{
			return  "error 404";
		}
	}

	public function editar($id)
	{
		//if( (Auth::user()->esBecario() and Auth::user()->id==$id) or Auth::user()->admin() )
    	//{
			$periodo = Periodo::find($id);
			$model = 'editar';
			$becario = $periodo->becario;
			return view("sisbeca.periodos.model")->with(compact('model','periodo','becario'));
		//}
		//else
		//{
			return "error 404";
		//}
	}

	public function actualizar(Request $request,$id)
	{
		//if( (Auth::user()->esBecario() and Auth::user()->id==$id) or Auth::user()->admin() )
    	//{
			$validation = Validator::make($request->all(), PeriodosRequest::rulesUpdate());
			if ( $validation->fails() )
			{
				flash("Por favor, verifique el formulario.",'danger');
				return back()->withErrors($validation)->withInput();
			}
	                
	        $periodo = Periodo::find($id);

	        if($request->file('constancia'))
	        {	
	        	File::delete($periodo->aval->url);
	        	
	     		$archivo= $request->file('constancia');
	            $nombre = str_random(100).'.'.$archivo->getClientOriginalExtension();
	            $ruta = public_path().'/'.Aval::carpetaConstancia();
	            $archivo->move($ruta, $nombre);
	            
	        	$aval = $periodo->aval;
	            $aval->url = Aval::carpetaConstancia().$nombre;
				$aval->estatus = "pendiente";
				$aval->tipo = "constancia";
				$aval->extension = ($archivo->getClientOriginalExtension()=="jpg" or $archivo->getClientOriginalExtension()=="jpeg"or $archivo->getClientOriginalExtension()=="png") ? "imagen":"pdf";
				$aval->save();
	        }
			
			$periodo->numero_periodo = $request->get('numero_periodo');
			$periodo->anho_lectivo = $request->get('anho_lectivo');
			$periodo->fecha_inicio = DateTime::createFromFormat('d/m/Y', $request->get('fecha_inicio'))->format('Y-m-d');
			$periodo->fecha_fin = DateTime::createFromFormat('d/m/Y', $request->get('fecha_fin'))->format('Y-m-d');
			$periodo->save();
			
			flash("El periodo fue actualizado exitosamente.",'success');
	    	return redirect()->route('periodos.listar');
	    //}
		//else
		//{
			return "error 404";
		//}
	}

	public function mostrarmaterias($id)
	{
		//misma validacion periodo controller para seguridad
		$periodo = Periodo::find($id);
		return view('sisbeca.materias.mostrar')->with(compact('periodo')); 
	}
	
	public function obtenermaterias($id)
	{
		$materias = Periodo::find($id)->materias;
		return response()->json(['materias'=>$materias]);
	}
	

		
}
