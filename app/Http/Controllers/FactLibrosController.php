<?php

namespace avaa\Http\Controllers;

use avaa\User;
use Illuminate\Http\Request;
use avaa\Http\Controllers\Controller;
use avaa\FactLibro;
use Illuminate\Support\Facades\Auth;

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
            $user = User::find($id);
            flash('El becario '.$user->nombreyapellido().' no ha cargado factura de libros en este mes')->warning()->important();
            return back();
        }
    }

    public function listar()
    {
        $id_user=Auth::user()->id;
        $facturas = FactLibro::query()->where('becario_id','=',$id_user)->get();
        return view('sisbeca.factlibros.cargarVerFacturas')->with('facturas',$facturas);
    }
    public function crear()
    {
        $model = "crear";
        return view('sisbeca.factlibros.model')->with(compact('model'));
    }

    public function guardar(Request $request)
    {
        $file= $request->file('url_factura');
        $name = 'fact_'.Auth::user()->cedula . time() . '.' . $file->getClientOriginalExtension();
        $path = public_path() . '/documentos/facturas/';
        $file->move($path, $name);
        $factura = new FactLibro();
        $costoAux = str_replace(".","",$request->get('costo'));
        $costoAux= str_replace(",",".",$costoAux);
        $factura->costo=$costoAux;
        $factura->name= $request->get('name');
        $factura->curso= $request->get('curso');
        $factura->becario_id = Auth::user()->id;
        $factura->url= '/documentos/facturas/'.$name;
        if($factura->save())
        {
            flash('La factura fue cargada exitosamente.','success')->important();
        }
        else
        {
            flash('Disculpe, se produjo error al cargar su factura.')->error()->important();
        }
        return redirect()->route('facturas.listar');
    }

    public function contarfacturaslibros($mes,$anho,$id)
    {
        $total = FactLibro::where('mes','=',$mes)->where('year','=',$anho)->where('becario_id','=',$id)->get();
        return $total;
        return response()->json(['total'=>$total]);
    }
}
