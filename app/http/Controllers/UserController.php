<?php

namespace avaa\Http\Controllers;

use Illuminate\Http\Request;
use avaa\Http\Controllers\Controller;
use Barryvdh\DomPDF\Facade as PDF;
use avaa\Becario;
use avaa\User;

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
    	$becario = Becario::find($id);
    	$usuario = User::find($id);
        $request->validate([
            'name' 				=> 'required|min:2,max:255',
            'last_name'			=> 'required|min:2,max:255',
            'cedula' 		 	=> 'required|integer|between:0,99000000',
            'email' 			=> 'required|email',
        ]);
        $usuario->name = $request->nombres;
        $usuario->save();
        return response()->json(['success'=>'Sus datos fueron actualizados']);
    }
}
