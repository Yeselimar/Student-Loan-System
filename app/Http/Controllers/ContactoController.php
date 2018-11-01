<?php

namespace avaa\Http\Controllers;

use Illuminate\Http\Request;
use avaa\Contacto;

class ContactoController extends Controller
{
    public function index()
    {
        $contactos = Contacto::all();
        return view('sisbeca.contactos.index')->with(compact('contactos'));
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre_completo' => 'required|min:2,max:255',
            'correo'          => 'required|email',
            'telefono'        => 'required|min:11,max:15',
            'asunto'          => 'required|min:2,max:255',
            'mensaje'         => 'required|min:2,max:10000',
        ]);
        $contacto = new Contacto;
        $contacto->nombre_completo = $request->nombre_completo;
        $contacto->correo = $request->correo;
        $contacto->telefono = $request->telefono;
        $contacto->asunto = $request->asunto;
        $contacto->mensaje = $request->mensaje;
        $contacto->save();
        return response()->json(['success'=>'¡Gracias por escribirnos, en breve te contactaremos!']);
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
