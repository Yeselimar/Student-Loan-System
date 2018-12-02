<?php

namespace avaa\Http\Controllers;

use Illuminate\Http\Request;
use avaa\Aval;

class AvalController extends Controller
{
	//este método es usado por varias vistas
   	public function getEstatus()
	{
		$estatus = (object)["0"=>"pendiente", "1"=>"aceptada", "2"=>"negada"];
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

}
