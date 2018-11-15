<?php

namespace avaa\Http\Controllers;
use Illuminate\Http\Request;
use avaa\Becario;
use avaa\Actividad;
use avaa\ActividadFacilitador;
use DateTime;

class ActividadController extends Controller
{
	public function listar()
	{
        $actividades = Actividad::all();
        return view('sisbeca.actividad.listar')->with(compact('actividades'));
	}

    public function crear()
    {
    	$model = "crear";
    	return view('sisbeca.actividad.model')->with(compact('model'));
    }

    public function guardar(Request $request)
    {
    	$request->validate([
            'nombre' 			 	=> 'required|min:5,max:255',
            'tipo'				 	=> 'required',
            'modalidad' 		 	=> 'required',
            'nivel' 			 	=> 'required',
            'anho_academico' 	 	=> 'min:0,max:255',
            'limite'  				=> 'required|integer|between:0,100',
            'horas'					=> 'required|integer|between:0,100',
            'fecha'					=> 'required|date_format:d/m/Y',
            'hora_inicio'			=> 'required|date_format:h:i A',
            'hora_fin'				=> 'required|date_format:h:i A',
            'descripcion'			=> 'min:0,max:10000',
        ]);
    	
    	$actividad = new Actividad;
    	$actividad->nombre = $request->nombre;
    	$actividad->tipo = $request->tipo;
    	$actividad->modalidad = $request->modalidad;
    	$actividad->nivel = $request->nivel;
    	$actividad->anho_academico = $request->anho_academico;
    	$actividad->limite_participantes = $request->limite;
    	$actividad->horas_voluntariado = $request->horas;
    	$actividad->fecha = DateTime::createFromFormat('d/m/Y', $request->fecha )->format('Y-m-d');
    	$actividad->hora_inicio = DateTime::createFromFormat('H:i a', $request->hora_inicio )->format('H:i:s');
    	$actividad->hora_fin = DateTime::createFromFormat('H:i a', $request->hora_fin )->format('H:i:s');
    	$actividad->descripcion = $request->descripcion;
    	$actividad->status = "disponible";
    	$actividad->save();
    	
    	//$index=0;
    	//$aux  = $request->get('facilitadores');
    	//$i=0;
    	//$tipo = gettype($request->facilitadores);
    	//$jsons = json_decode($request->facilitadores, true);
    	foreach($request->facilitadores as $facilitador)
    	{
    		//$i++;
    		//$primero = $facilitador["id"];
    		if($facilitador["becario"]=="no")
    		{
    			$af = new ActividadFacilitador;
    			$af->actividad_id = $actividad->id;
    			$af->nombreyapellido =  $facilitador["nombre"];
    			$af->save();
    		}
    		else
    		{
    			$af = new ActividadFacilitador;
    			$af->actividad_id = $actividad->id;
    			$af->becario_id = $facilitador["id"];
    			$af->save();
    		}
    	
    	}
    	//crear actividad_facilitador
    	//$count = count($request->facilitadores);
    	return response()->json(['success'=>'La actividad fue creada exitosamente.']);
    }

    //becarios activos son los que pueden ser facilitador
    public function obtenerbecarios()
    {
    	$becarios = Becario::activos()->with("user")->get();
    	return response()->json(['becarios'=>$becarios]);
    }
}
