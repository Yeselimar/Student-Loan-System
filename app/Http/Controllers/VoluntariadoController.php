<?php

namespace avaa\Http\Controllers;
use Illuminate\Http\Request;
use avaa\Voluntariado;
use Illuminate\Support\Facades\Auth;
use DateTime;
use avaa\Http\Requests\VoluntariadoRequest;
use Validator;
use Illuminate\Support\Facades\Storage;
use File;
use avaa\Aval;
use avaa\Becario;
use Intervention\Image\ImageManagerStatic as Image;

class VoluntariadoController extends Controller
{
    public function index()
    {
    	$voluntariados = Voluntariado::where('becario_id','=',Auth::user()->id)->get();
    	return view('sisbeca.voluntariados.index')->with(compact('voluntariados'));
    }

    public function crear($id)
    {
    	$model =  'crear';
        $becario = Becario::find($id);
    	return view('sisbeca.voluntariados.model')->with(compact('model','becario'));
    }

    public function guardar(Request $request,$id)
    {
    	$validation = Validator::make($request->all(), VoluntariadoRequest::rulesCreate());
		if ( $validation->fails() )
		{
			flash("Por favor, verifique el formulario.",'danger');
			return back()->withErrors($validation)->withInput();
		}
        if($request->file('comprobante'))
        {
    		$archivo= $request->file('comprobante');
            $nombre = str_random(100).'.'.$archivo->getClientOriginalExtension();
            $ruta = public_path().'/'.Aval::carpetaComprobante();
            $archivo->move($ruta, $nombre);
        }
		$aval = new Aval;
		$aval->url = Aval::carpetaComprobante().$nombre;
		$aval->estatus = "pendiente";
		$aval->extension = ($archivo->getClientOriginalExtension()=="jpg" or $archivo->getClientOriginalExtension()=="jpeg" or $archivo->getClientOriginalExtension()=="png") ? "imagen":"pdf";
		$aval->tipo = "comprobante";
		$aval->becario_id = $id;
		$aval->save();

		$voluntariado = new Voluntariado;
		$voluntariado->nombre = $request->get('nombre');
		$voluntariado->descripcion = $request->get('descripcion');
		$voluntariado->fecha = DateTime::createFromFormat('d/m/Y', $request->get('fecha'))->format('Y-m-d');
		$voluntariado->tipo = $request->get('tipo');
		$voluntariado->lugar = $request->get('lugar');
		$voluntariado->horas = $request->get('horas');
		$voluntariado->becario_id = $id;
		$voluntariado->aval_id = $aval->id;
		$voluntariado->save();
		flash("El voluntariado fue creado exitosamente.",'success');
    	return redirect()->route('voluntariados.index');
    }

    public function editar($id)
    {
    	$voluntariado = Voluntariado::find($id);
    	$model = 'editar';
    	return view('sisbeca.voluntariados.model')->with(compact('voluntariado','model'));
    }

    public function actualizar(Request $request,$id)
    {
    	$validation = Validator::make($request->all(), VoluntariadoRequest::rulesUpdate());
        if ( $validation->fails() )
        {
            flash("Por favor, verifique el formulario.",'danger');
            return back()->withErrors($validation)->withInput();
        }
        $voluntariado = Voluntariado::find($id);
        if($request->file('comprobante'))
        {   
            File::delete($voluntariado->aval->url);
            
            $archivo= $request->file('comprobante');
            $nombre = str_random(100).'.'.$archivo->getClientOriginalExtension();
            $ruta = public_path().'/'.Aval::carpetaComprobante();
            $archivo->move($ruta, $nombre);
            
            $aval = $voluntariado->aval;
            $aval->url = Aval::carpetaComprobante().$nombre;
            $aval->extension = ($archivo->getClientOriginalExtension()=="jpg" or $archivo->getClientOriginalExtension()=="jpeg"or $archivo->getClientOriginalExtension()=="png") ? "imagen":"pdf";
            $aval->save();
        }
        $voluntariado->nombre = $request->get('nombre');
        $voluntariado->descripcion = $request->get('descripcion');
        $voluntariado->fecha = DateTime::createFromFormat('d/m/Y', $request->get('fecha'))->format('Y-m-d');
        $voluntariado->tipo = $request->get('tipo');
        $voluntariado->lugar = $request->get('lugar');
        $voluntariado->horas = $request->get('horas');
        $voluntariado->save();
        flash("El voluntariado fue actualizado exitosamente.",'success');
        return redirect()->route('voluntariados.index');
    }
}
