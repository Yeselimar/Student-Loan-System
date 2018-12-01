<?php

namespace avaa\Http\Controllers;

use Illuminate\Http\Request;
use avaa\Aval;
use avaa\ActividadBecario;

class AvalController extends Controller
{
	//este método es usado por varias vistas
   	public function getEstatus()
	{
		$estatus = (object)["0"=>"pendiente", "1"=>"aceptada", "2"=>"negada","devuelto"];
		return response()->json(['estatus'=>$estatus]);
	}

	//este método es usado por varias vistas no cambiar el nombre del success
 	public function actualizarestatus(Request $request, $id)
	{
		$aval = Aval::find($id);
		$aval->estatus = $request->estatus;
		$aval->save();
		return response()->json(['success'=>'El estatus fue actualizado exitosamente.']);
	}

	public function aceptar($id)
	{
		$aval = Aval::find($id);
		$aval->estatus = "aceptada";
		$aval->save();

		$ab = ActividadBecario::paraAval($id)->first();
		$ab->estatus = "asistio";
		$ab->save();
		
		return response()->json(['success'=>'La justificación fue aceptada exitosamente.']);
	}

	public function devolver($id)
	{
		//generar un alerta para que el becario de se entere de que su justificativo fue devuelto
		$aval = Aval::find($id);
		$aval->estatus = "devuelto";
		$aval->save();

		$ab = ActividadBecario::paraAval($id)->first();
		$ab->estatus = "justificacion cargada";
		$ab->save();
		
		return response()->json(['success'=>'La justificación fue devuelta exitosamente.']);
	}

	public function negar($id)
	{
		$aval = Aval::find($id);
		$aval->estatus = "negada";
		$aval->save();

		$ab = ActividadBecario::paraAval($id)->first();
		$ab->estatus = "no asistio";
		$ab->save();
		
		return response()->json(['success'=>'La justificación fue negada exitosamente.']);
	}
}
