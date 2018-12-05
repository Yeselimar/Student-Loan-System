<?php

namespace avaa\Http\Controllers;

use Illuminate\Http\Request;
use avaa\Http\Controllers\Controller;
use avaa\Becario;

class SeguimientoController extends Controller
{
   	public function todosbecarios()
   	{
        $becarios = Becario::activos()->terminosaceptados()->probatorio1()->get();
        return view('sisbeca.becarios.todos')->with(compact('becarios'));
   	}

   	public function todosbecariosservicio()
   	{
   		$becarios = Becario::activos()->terminosaceptados()->probatorio1()->get();
   	}
}
