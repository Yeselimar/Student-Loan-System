<?php

namespace avaa\Http\Controllers;

use Illuminate\Http\Request;
use avaa\Http\Controllers\Controller;
use avaa\Http\Requests\TicketRequest;
use Illuminate\Support\Facades\Auth;
use Validator;
use avaa\Ticket;

class TicketsController extends Controller
{
	public function ticketsestatus()
	{
		$estatus = (object)["0"=>"enviado", "1"=>"en revision", "2"=>"cerrado"];
		return response()->json(['estatus'=>$estatus]);
	}

	public function todos()
    {
    	if(Auth::user()->esSoporte())
    	{
    		return view('sisbeca.tickets.todos');
    	}
    	return view('sisbeca.error.404');
    }

    public function todosservicio()
    {
    	if(Auth::user()->esSoporte())
    	{
	    	$todos = collect();
	    	$tickets = Ticket::all();
	    	foreach ($tickets as $t)
	        {
	        	$usuariorespuesta = '-';
	        	if($t->usuario_respuesta_id)
	        	{
	        		$usuariorespuesta = $t->usuariorespuesta->name.' '.$t->usuariorespuesta->last_name;
	        	}
	            $todos->push(array(
	                'id' => $t->id,
	                'nro' => $t->getNro(),
	                'estatus' => $t->estatus,
	                'prioridad' => $t->prioridad,
	                'tipo' => $t->tipo,
	                'asunto' => $t->asunto,
	                'descripcion' => $t->descripcion,
	                'imagen' => $t->imagen,
	                'url' => $t->url,
	                'respuesta' => $t->respuesta,
	                "usuariorespuesta" => $usuariorespuesta,
	                "usuariogenero" => $t->usuariogenero->name.' '.$t->usuariogenero->last_name,
	                "rolgenero" => ucwords($t->usuariogenero->rol),
	                "created_at" => $t->created_at,
	                "updated_at" => $t->updated_at,
	            ));
	        }
	    	return response()->json(['tickets'=>$todos]);
	    }
	    return view('sisbeca.error.404');
    }

    public function index($id)
    {
    	//Los de soporte pueden ver los ticket de todos los usuarios
    	$usuario = Auth::user();
    	if(Auth::user()->esSoporte() or ($id==Auth::user()->id))
    	{
    		return view('sisbeca.tickets.mistickets')->with(compact('usuario'));
    	}
    	return view('sisbeca.error.404');
    }

    public function mistickets($id)
    {
    	//agregar seguridad para  que un usuario no vean los  tickets de otro
    	if(Auth::user()->esSoporte() or ($id==Auth::user()->id))
    	{
	    	$todos = collect();
	    	$tickets = Ticket::where('usuario_genero_id','=',$id)->get();
	    	foreach ($tickets as $t)
	        {
	        	$usuariorespuesta = '-';
	        	if($t->usuario_respuesta_id)
	        	{
	        		$usuariorespuesta = $t->usuariorespuesta->name.' '.$t->usuariorespuesta->last_name;
	        	}
	            $todos->push(array(
	                'id' => $t->id,
	                'nro' => $t->getNro(),
	                'estatus' => $t->estatus,
	                'prioridad' => $t->prioridad,
	                'tipo' => $t->tipo,
	                'asunto' => $t->asunto,
	                'descripcion' => $t->descripcion,
	                'imagen' => $t->imagen,
	                'url' => $t->url,
	                'respuesta' => $t->respuesta,
	                "usuariorespuesta" => $usuariorespuesta,
	                "created_at" => $t->created_at,
	                "updated_at" => $t->updated_at,
	            ));
	        }
	    	return response()->json(['tickets'=>$todos]);
	    }
	    return view('sisbeca.error.404');
    }

    public function crear()
    {
    	if(!Auth::user()->esSoporte())
    	{
    		$model = "crear";
	    	$usuario = Auth::user();
	    	return view('sisbeca.tickets.model')->with(compact('model','usuario'));
    	}
    	return view('sisbeca.error.404');
    }

    public function guardar(Request $request)
    {
    	$validation = Validator::make($request->all(), TicketRequest::rulesCreate());
		if ( $validation->fails() )
		{
			flash("Por favor, verifique el formulario.",'danger');
			return back()->withErrors($validation)->withInput();
		}
		//return Ticket::carpeta();
		$ticket = new Ticket;
        if($request->file('imagen'))
        {
            $archivo= $request->file('imagen');
            $nombre = str_random(100).'.'.$archivo->getClientOriginalExtension();
            $ruta = public_path().'/'.Ticket::carpeta();
            $archivo->move($ruta, $nombre);
            //return $ruta;
            $ticket->imagen = Ticket::carpeta().$nombre;
        }
        $ticket->estatus = 'enviado';
        $ticket->prioridad = $request->prioridad;
        $ticket->tipo = $request->tipo;
        $ticket->asunto = $request->asunto;
        $ticket->descripcion = $request->descripcion;
        $ticket->url = $request->url;
        $ticket->usuario_genero_id = Auth::user()->id;
        $ticket->save();

        flash("El ticket fue cargado exitosamente.",'success');
        return redirect()->route('ticket.index',Auth::user()->id);
    }

    public function editar()
    {
    	
    }

    public function actualizar(Request $request, $id)
    {
    	$ticket = Ticket::find($id);
        $ticket->respuesta = $request->respuesta;
        $ticket->estatus = $request->estatus;
        $ticket->usuario_respuesta_id = Auth::user()->id;
        $ticket->save();
        return response()->json(['success'=>'El ticket '.$ticket->getNro().' fue respondido exitosamente.']);
    }

    public function detalles($id)
    {
    	//agregar seguridad para  que un usuario no vean los  tickets de otro. Soporte tambien pueden verlo
    	$ticket = Ticket::find($id);
    	if(Auth::user()->esSoporte() or (Auth::user()->id==$ticket->usuario_genero_id))
    	{
	    	return view('sisbeca.tickets.detalles')->with(compact('ticket'));
    	}
    	return view('sisbeca.error.404');
    }

    public function detallesservicio($id)
    {
    	$todo = collect();
    	$ticket = Ticket::where('id','=',$id)->with('usuariorespuesta')->with('usuariogenero')->first();
    	$t = $ticket;
    	if(Auth::user()->esSoporte() or (Auth::user()->id==$ticket->usuario_genero_id))
    	{
    		$usuariorespuesta = '-';
        	if($t->usuario_respuesta_id)
        	{
        		$usuariorespuesta = $t->usuariorespuesta->name.' '.$t->usuariorespuesta->last_name;
        	}
    		$todo->push(array(
                'id' => $t->id,
                'nro' => $t->getNro(),
                'estatus' => $t->estatus,
                'prioridad' => $t->prioridad,
                'tipo' => $t->tipo,
                'asunto' => $t->asunto,
                'descripcion' => $t->descripcion,
                'imagen' => $t->imagen,
                'url' => $t->url,
                'respuesta' => $t->respuesta,
                "usuariorespuesta" => $usuariorespuesta,
                "usuariogenero" => $t->usuariogenero->name.' '.$t->usuariogenero->last_name,
                "rolgenero" => ucwords($t->usuariogenero->rol),
                "created_at" => $t->created_at,
                "updated_at" => $t->updated_at,
            ));
    		return response()->json(['ticket'=>$todo[0]]);
    	}
    	return view('sisbeca.error.404');
    }

    public function eliminar()
    {
    	
    }

}
