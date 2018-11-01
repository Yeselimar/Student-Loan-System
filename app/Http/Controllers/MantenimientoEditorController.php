<?php

namespace avaa\Http\Controllers;

use avaa\Costo;
use DateTime;
use Timestamp;
use Illuminate\Http\Request;

class MantenimientoEditorController extends Controller
{
    public function __construct()
    {
        $this->middleware('editor');
    }

    public function createOrUpdateCostos(Request $request, $id)
    {
        if(is_null($request->get('sueldo_becario')))
        {
            if($id==0)
            {  
                $costo = new Costo($request->all());
                $costo->fecha_valido=  DateTime::createFromFormat('d/m/Y H:i:s', $request->get('fecha_valido').' 00:00:00');
                $costo->save();
                flash('Costos Definidos Exitosamente','success')->important();
            }
            else
            {
                $costo = Costo::first();
                $costo->fill($request->all());
                $costo->fecha_valido=  DateTime::createFromFormat('d/m/Y H:i:s', $request->get('fecha_valido').' 00:00:00');
                $costoAux = str_replace(".","",$request->get('costo_ases_basica'));
                $costoAux= str_replace(",",".",$costoAux);
                $costo->costo_ases_basica=$costoAux;
                $costoAux = str_replace(".","",$request->get('costo_ases_intermedia'));
                $costoAux= str_replace(",",".",$costoAux);
                $costo->costo_ases_intermedia=$costoAux;
                $costoAux = str_replace(".","",$request->get('costo_ases_completa'));
                $costoAux= str_replace(",",".",$costoAux);
                $costo->costo_ases_completa=$costoAux;
                $costoAux = str_replace(".","",$request->get('costo_membresia'));
                $costoAux= str_replace(",",".",$costoAux);
                $costo->costo_membresia=$costoAux;
                $costo->save();
                flash('Costos Actualizados Exitosamente','success')->important();

            }
        }
        else {
            flash('Ocurrio un error inesperado','danger')->important();
        }
        return  redirect()->route('costos.show');
    }

    public function viewCostos()
    {
        $costos= Costo::first();
        if(is_null($costos))
        {
            $costos = new Costo();
            $id=0;
            flash('No se han definido los Costos Actualmente, Por favor definelos')->error()->important();
        }
        else
        {
            $id=$costos->id;
        }
        return view('sisbeca.costos.costo')->with('costo',$costos)->with('id',$id);
    }
}
