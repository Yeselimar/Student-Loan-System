<?php

namespace avaa\Http\Controllers;

use avaa\Alerta;
use avaa\FactLibro;
use avaa\Imagen;
use avaa\Mentor;
use avaa\User;
use Illuminate\Http\Request;
use avaa\Http\Controllers\Controller;
use avaa\Becario;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Support\Facades\Auth;

class BecarioController extends Controller
{

    public function __construct()
    {
        $this->middleware('becario');
    }

    public function bancariapdf()
    {
        switch (date('m')) {
            case 1:
                $mes= 'Enero';
                break;
            case 2:
                $mes=  'Febrero';
                break;
            case 3:
                $mes= 'Marzo';
                break;
            case 4:
                $mes=  'Abril';
                break;
            case 5:
                $mes=  'Mayo';
                break;
            case 6:
                $mes=  'Junio';
                break;
            case 7:
                $mes=  'Julio';
                break;
            case 8:
                $mes=  'Agosto';
                break;
            case 9:
                $mes=  'Septiembre';
                break;
            case 10:
                $mes=  'Octubre';
                break;
            case 11:
                $mes=  'Noviembre';
                break;
            case 12:
                $mes=  'Diciembre';
                break;
        }

        $becario= Becario::find(Auth::user()->id);
        $pdf = PDF::loadView('sisbeca.cartas.bancaria', compact('mes','becario'));

        return $pdf->stream('bancaria.pdf', 'PDF xasa');
    }

    public function aceptoTerminosCondiciones()
    {

        if (Auth::user()->becario->acepto_termino == 1) {
            return back();
        }
        return view('sisbeca.becarios.terminosCondiciones');
    }

    public function terminosCondicionesAprobar(Request $request)
    {
        if (Auth::user()->becario->acepto_termino == 1) {
            return back();
        }

        $becario = User::find(Auth::user()->id)->becario;

        $becario->acepto_terminos = 1;


        if ($becario->save()) {

            flash('Ha Aceptado Terminos y Condiciones Exitosamente', 'success')->important();
        } else {
            flash('Ha Ocurrido un Error Inesperado', 'success')->important();
        }


        return redirect()->route('sisbeca');
    }

    public function verCuentaBancaria()
    {

        $becario = User::find(Auth::user()->id)->becario;
        if (is_null($becario->cuenta_bancaria)) {
            flash('No se ha Cargado su Cuenta Bancaria, Por favor Cargue su Cuenta Bancaria')->error()->important();
        }

        return view('sisbeca.becarios.cuentaBancaria')->with('becario', $becario);

    }

    public function cuentaBancariaUpdated(Request $request, $id)
    {

        if(Auth::user()->id==$id)
        {
            $becario= Becario::find($id);

            $becario->cuenta_bancaria= $request->get('cuenta_bancaria');

            if($becario->save()){

                flash('Su numero de Cuenta ha sido cargada exitosamente!!','success')->important();
            }

        }
        else{
            flash('Error al acceder a la pagina solicitada', 'danger')->important();
            return back();
        }


        return redirect()->route('verCuentaBancaria');

    }

    public function crearVerFacturas()
    {
        $id_user=Auth::user()->id;
        $facturas = FactLibro::query()->where('becario_id','=',$id_user)->get();
        return view('sisbeca.factlibros.cargarVerFacturas')->with('facturas',$facturas);
    }

    public function facturasStore(Request $request)
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
            flash('La Factura fue cargada exitosamente.','success')->important();
        }
        else
        {
            flash('Ha ocurrido un error al cargar factura')->error()->important();
        }
        return redirect()->route('crearVerFacturas');
    }

    public function verMentorAsignado()
    {
        $mentor= Mentor::query()->where('user_id','=',Auth::user()->becario->mentor_id)->first();

        $img_perfil=Imagen::query()->where('user_id','=',Auth::user()->becario->mentor_id)->where('titulo','=','img_perfil')->get();
        $documento = null;

        Alerta::where('status', '=', 'generada')->where('solicitud','=',null)->where('user_id', '=', Auth::user()->id)->update(array('leido' => true));

        return view('sisbeca.mentores.perfilMentor')->with('mentor',$mentor)->with('img_perfil',$img_perfil)->with('documento',$documento);
    }

    
}