<?php

namespace avaa\Http\Controllers;

use avaa\User;
use Illuminate\Http\Request;
use avaa\Http\Controllers\Controller;
use avaa\FactLibro;


class FactLibrosController extends Controller
{
    public function verfacturas($mes,$anho,$id)
    {
        $factlibros = FactLibro::where('becario_id','=',$id)->where('status','=','por procesar')->get();
        if($factlibros->count()>0)
        {
            $facturas = $factlibros;
            $total = 0;
            foreach ($facturas as $factura)
            {
                $total = $total + $factura->costo;
            }
            return view('sisbeca.factlibros.verfacturas')->with('factlibros', $factlibros)->with('mes', $mes)->with('anho', $anho)->with('total', $total);
        }
        else
        {
            $becario= User::find($id);
            flash('El becario '.$becario->name.' No ha cargado factura de libros en este mes')->warning()->important();
            return back();
        }
    }

    public function contarfacturaslibros($mes,$anho,$id)
    {
        $total = FactLibro::where('mes','=',$mes)->where('year','=',$anho)->where('becario_id','=',$id)->count();
        return response()->json(['total'=>$total]);
    }
}
