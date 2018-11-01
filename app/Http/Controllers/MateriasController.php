<?php

namespace avaa\Http\Controllers;

use Illuminate\Http\Request;
use avaa\Materia;

class MateriasController extends Controller
{
    public function __construct()
    {
        $this->middleware('becario');
    }


	public function index($id)
	{
		
	}

	public function pruebaapi (Request $request) {
		$dat= 'hola';
		return $dat;
	}

	public function anadirmateria(Request $request,$id)
	{
		$request->validate([
            'nombre' => 'required|min:2,max:255',
            'nota' => 'required'
        ]);
		$materia = new Materia;
		$materia->nombre = $request->nombre;
		$materia->nota = $request->nota;
		$materia->periodo_id = $id;
		$materia->save();
        return response()->json(['success'=>'La materia fue añadida exitosamente.']);
	}

	public function editarmateria(Request $request,$id)
	{
		$request->validate([
            'nombre' => 'required|min:2,max:255',
            'nota' => 'required'
        ]);
		$materia = Materia::find($id);
		$materia->nombre = $request->nombre;
		$materia->nota = $request->nota;
		$materia->save();
        return response()->json(['success'=>'La materia fue actualizada exitosamente.']);
	}

	public function eliminarmateria($id)
	{
		//confirmar que no sea otro usuario que elimine 
		$materia = Materia::find($id);
		$materia->delete();
		return response()->json(['success'=>'La materia fue eliminada exitosamente.']);
	}
}
