<?php

namespace avaa\Http\Controllers;

use Illuminate\Http\Request;
use avaa\Becario;
use avaa\BecarioEntrevistador;
use avaa\User;
use DateTime;

class EntrevistadorController extends Controller
{
		public function asignarentrevistadores()
		{
			
			return view('sisbeca.entrevistador.asignar')->with(compact('becarios'));
		}

		public function obtenerpostulantes()
		{
			$becarios = Becario::where('status','=','entrevista')->with("user")->with('entrevistadores')->get();
			return response()->json(['becarios'=>$becarios]);
		}

		public function obtenerentrevistadores()
		{
			$entrevistadores = User::entrevistadores()->get();
			return response()->json(['entrevistadores'=>$entrevistadores]);
		}

		public function guardarasignarentrevistadores(Request $request,$id)
		{
			//validar hora y fecha
			$becario = Becario::find($id);
			$becario->lugar_entrevista = $request->lugar;
			$becario->hora_entrevista = DateTime::createFromFormat('H:i a', $request->hora )->format('H:i:s');
			$becario->fecha_entrevista = DateTime::createFromFormat('d/m/Y', $request->fecha )->format('Y-m-d');
			$becario->save();
		 
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
			return response()->json(['success'=>'Los datos de la entrevista fueron actualizados']);
		}

		public function obtenerbecario($id)
		{
			$becario = Becario::find($id);
			return response()->json(['becario'=>$becario]);	
		}
}
