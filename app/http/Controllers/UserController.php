<?php

namespace avaa\Http\Controllers;

use Illuminate\Http\Request;
use avaa\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use avaa\Becario;
use avaa\User;
use DateTime;

class UserController extends Controller
{
    public function obtenerdatos($id)
    {
        $becario = Becario::find($id);
        $usuario = User::find($id);
        return response()->json(['becario'=>$becario,'usuario'=>$usuario]);
    }

    public function editardatos($id)
    {
    	$becario = Becario::find($id);
    	$usuario = User::find($id);
        return view('sisbeca.becarios.editar-datos')->with(compact("becario","usuario"));
    }

    public function actualizardatos(Request $request,$id)
    {
        $request->validate([
            'sexo' 			   => 'required',
            'fecha_nacimiento' => 'required',
            'direccion_permanente' => 'required|min:10,max:1000',
            'direccion_temporal' => 'min:0,max:1000',
            'celular' => 'required|min:11,max:11',
            'telefono_habitacion' => 'min:11,max:11',
            'telefono_pariente' => 'min:11,max:11',
            'lugar_trabajo' => 'min:0,max:255',
            'cargo_trabajo' => 'min:0,max:255',
            'lugar_trabajo' => 'min:0,max:255',
            'horas_trabajo' => 'integer|between:0,250'
        ]);
        $becario = Becario::find($id);
        $usuario = User::find($id);

        $usuario->fecha_nacimiento = DateTime::createFromFormat('d/m/Y', $request->fecha_nacimiento )->format('Y-m-d');
        $usuario->sexo = $request->sexo;
        $usuario->save();
        $becario->direccion_permanente = $request->direccion_permanente;
        $becario->direccion_temporal = $request->direccion_temporal;
        $becario->celular = $request->celular;
        $becario->telefono_habitacion = $request->telefono_habitacion;
        $becario->telefono_pariente = $request->telefono_pariente;
        $becario->trabaja = $request->trabaja;
        if($becario->trabaja=='0')
        {
            $becario->lugar_trabajo = null;
            $becario->cargo_trabajo = null;
            $becario->horas_trabajo = null;
        }
        else
        {
            $becario->lugar_trabajo = $request->lugar_trabajo;
            $becario->cargo_trabajo = $request->cargo_trabajo;
            $becario->horas_trabajo = $request->horas_trabajo;
        }
        $becario->save();

        return response()->json(['success'=>'Los datos personales del cecario fueron actualizados.']);
    }

    public function actualizaruniversidad(Request $request, $id)
    {
        $request->validate([
            'inicio_universidad'   => 'required',
            'nombre_universidad'   => 'required|min:2,max:1000',
            'carrera_universidad'  => 'required|min:2,max:255',
            'promedio_universidad' => 'required',
        ]);
        $becario = Becario::find($id);
        $usuario = User::find($id);
        $becario->inicio_universidad = DateTime::createFromFormat('d/m/Y', $request->inicio_universidad )->format('Y-m-d');
        $becario->nombre_universidad = $request->nombre_universidad;
        $becario->carrera_universidad = $request->carrera_universidad;
        $becario->promedio_universidad = $request->promedio_universidad;
        $becario->save();

        return response()->json(['success'=>'Los estudios universitarios del decario fueron actualizados.']);
    }
}
