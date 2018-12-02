<?php

namespace avaa\Http\Controllers;
use avaa\Curso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use avaa\Http\Requests\CursoRequest;
use avaa\Aval;
use avaa\Becario;
use DateTime;
use File;

class CursoController extends Controller
{
    public function obtenertodos()
    {
        $cursos = Curso::with("becario")->with("usuario")->with("aval")->orderby('created_at','desc')->get();
        return response()->json(['cursos'=>$cursos]);
    }

    public function todoscursos()
    {
        return view('sisbeca.cursos.todos');
    }

    public function index()
    {
    	$cursos = Curso::where('becario_id','=',Auth::user()->id)->get();
    	return view('sisbeca.cursos.index')->with(compact('cursos'));
    }

    public function crear($id)
    {
    	$model = 'crear';
        $becario = Becario::find($id);
    	return view('sisbeca.cursos.model')->with(compact('model','becario'));
    }

    public function guardar(Request $request,$id)
    {
    	$validation = Validator::make($request->all(), CursoRequest::rulesCreate());
		if ( $validation->fails() )
		{
			//dd($validation);
			flash("Por favor, verifique el formulario.",'danger');

			return back()->withErrors($validation)->withInput();
		}
        
        if($request->file('constancia_nota'))
        {
    		$archivo= $request->file('constancia_nota');
            $nombre = str_random(100).'.'.$archivo->getClientOriginalExtension();
            $ruta = public_path().'/'.Aval::carpetaNota();
            $archivo->move($ruta, $nombre);
        }
        
		$aval = new Aval;
		$aval->url = Aval::carpetaNota().$nombre;
		$aval->estatus = "pendiente";
		$aval->extension = ($archivo->getClientOriginalExtension()=="jpg" or $archivo->getClientOriginalExtension()=="jpeg" or $archivo->getClientOriginalExtension()=="png") ? "imagen":"pdf";
		$aval->tipo = "nota";
		$aval->becario_id = $id;
		$aval->save();

		$curso = new Curso;
		$curso->modo = $request->get('modo');
		$curso->nivel = $request->get('nivel');
		$curso->modulo = $request->get('modulo');
		$curso->nota = $request->get('nota');
		$curso->status = 'reprobado';
		$curso->tipocurso_id = $request->get('tipocurso_id');
		$curso->fecha_inicio = DateTime::createFromFormat('d/m/Y', $request->get('fecha_inicio'))->format('Y-m-d');
		$curso->fecha_fin = DateTime::createFromFormat('d/m/Y', $request->get('fecha_fin'))->format('Y-m-d');
		$curso->becario_id = $id;
		$curso->aval_id = $aval->id;
		$curso->save();
		
		flash("El curso fue creado exitosamente.",'success');
    	return redirect()->route('cursos.index');
    }

    public function editar($id)
    {
    	$curso = Curso::find($id);
    	$model = "editar";
        $becario = $curso->becario;
    	return view('sisbeca.cursos.model')->with(compact('curso','model','becario'));
    }

    public function actualizar(Request $request,$id)
    {
    	$validation = Validator::make($request->all(), CursoRequest::rulesUpdate());
		if ( $validation->fails() )
		{
			flash("Por favor, verifique el formulario.",'danger');
			return back()->withErrors($validation)->withInput();
		}
        $curso = Curso::find($id);
        if($request->file('constancia_nota'))
        {	
        	File::delete($curso->aval->url);
        	
     		$archivo= $request->file('constancia_nota');
            $nombre = str_random(100).'.'.$archivo->getClientOriginalExtension();
            $ruta = public_path().'/'.Aval::carpetaNota();
            $archivo->move($ruta, $nombre);
            
        	$aval = $curso->aval;
            $aval->url = Aval::carpetaNota().$nombre;
			$aval->tipo = "nota";
			$aval->extension = ($archivo->getClientOriginalExtension()=="jpg" or $archivo->getClientOriginalExtension()=="jpeg" or $archivo->getClientOriginalExtension()=="png") ? "imagen":"pdf";
			$aval->save();
        }
        $curso->modo = $request->get('modo');
		$curso->nivel = $request->get('nivel');
		$curso->modulo = $request->get('modulo');
		$curso->nota = $request->get('nota');
		$curso->tipocurso_id = $request->get('tipocurso_id');
		$curso->fecha_inicio = DateTime::createFromFormat('d/m/Y', $request->get('fecha_inicio'))->format('Y-m-d');
		$curso->fecha_fin = DateTime::createFromFormat('d/m/Y', $request->get('fecha_fin'))->format('Y-m-d');
		$curso->save();
		
		flash("El curso fue actualizado exitosamente.",'success');
    	return redirect()->route('cursos.index');
    }
}
