<?php

namespace avaa\Http\Controllers;

use Illuminate\Http\Request;
use avaa\Becario;
use avaa\Entrevistador;
use avaa\BecarioEntrevistador;
class EntrevistadorController extends Controller
{
    public function asignarentrevistadores()
    {
    	return view('sisbeca.entrevistador.asignar')->with(compact('becarios'));
    }

    public function obtenerpostulantes()
    {
        $becarios = Becario::where('status','=','postulante')->with("user")->with('entrevistadores')->get();
        return response()->json(['becarios'=>$becarios]);
    }

    public function obtenerentrevistadores()
    {
        $entrevistadores = Entrevistador::all();
        return response()->json(['entrevistadores'=>$entrevistadores]);
    }

    public function guardarasignarentrevistadores(Request $request,$id)
    {
    	$becario = Becario::find($id);
    	foreach ($becario->entrevistadores as $entrevistador)
    	{
    		$entrevistador_becario = BecarioEntrevistador::where('becario_id','=',$id)->where('entrevistador_id','=',$entrevistador->id)->delete();
    	}
      
      if($request->has('seleccionados') and $request->get('seleccionados')!=null)
      {
          $tmp = explode(',', $request->get('seleccionados'));
          foreach ($tmp as $index=>$seleccion)
          {
            $nuevo = new BecarioEntrevistador;
            $nuevo->becario_id = $id;
            $nuevo->entrevistador_id = $seleccion;
            $nuevo->save();
          }
      }
      return response()->json(['success'=>'Los entrevistadores fueron actualizados']);
    }
}
