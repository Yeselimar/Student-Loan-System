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
        $becario = Becario::where($id);
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
            'fecha_nacimiento' => 'required'
        ]);
        $becario = Becario::find($id);
        $usuario = User::find($id);
        $usuario->fecha_nacimiento = DateTime::createFromFormat('d/m/Y', $request->fecha_nacimiento )->format('Y-m-d');
        $usuario->sexo = $request->sexo;
        $usuario->save();

        return response()->json(['success'=>'Sus datos fueron actualizados']);
    }
}
