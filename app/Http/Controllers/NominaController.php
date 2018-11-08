<?php

namespace avaa\Http\Controllers;

use avaa\Alerta;
use Illuminate\Http\Request;
use avaa\Http\Controllers\Controller;
use avaa\Becario;
use avaa\Nomina;
use avaa\Costo;
use avaa\User;
use avaa\BecarioNomina;
use avaa\FactLibro;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade as PDF;
use avaa\Http\Requests\NominaRequest;


class NominaController extends Controller
{
	public function __construct()
    {
        $this->middleware('directivo');
    }

    public function listar()
    {
        $ultimodia = date("Y-m-d",(mktime(0,0,0,date('m')+1,1,date('Y'))-1));
        $fechagenerar = strtotime ( '-1 day' , strtotime ( $ultimodia ) ) ;//--poner-5
        $fechagenerar = date ( 'Y-m-d' , $fechagenerar );
        $hoy = date('Y-m-d');
        $generar = false;
        $nominasaux = Nomina::where('mes',date('m'))->where('year',date('Y'))->get();
        if($hoy == $fechagenerar and count($nominasaux)==0)
        {
            $generar = true;
        }
        $anho = date ( 'Y' , strtotime($fechagenerar) );
        $mes = date ( 'm' , strtotime($fechagenerar) );
        $nominas = DB::table('nominas')
                     ->select(DB::raw('count(*) as total_becarios,sum(total) as total_pagado, mes, year,fecha_generada, fecha_pago,sueldo_base, status, id'))
                     ->where('status','=','generado')
                     ->groupBy('mes','year')
                     ->orderby('mes','desc')->orderby('year','desc')->get();

       
        return View('sisbeca.nomina.listar')->with('nominas',$nominas)->with('generar',$generar)->with('mes',$mes)->with('anho',$anho);
    }

    public function listarver($mes, $anho)
    {
        $nominasfiltro = Nomina::where('mes','=',$mes)->where('year',$anho)->where('status','=','generado')->get();
        $nominasfiltro->each(function ($nominasfiltro){
        $nominasfiltro->becarios;
            foreach ($nominasfiltro->becarios as $becario)
            {

                $becario->user;
            }
        });
        return View('sisbeca.nomina.listarver')->with('nominas',$nominasfiltro)->with('mes',$mes)->with('anho',$anho);
    }

    public function listarpagadas($mes, $anho)
    {
        $nominasfiltro = Nomina::where('mes','=',$mes)->where('year',$anho)->where('status','=','pagado')->get();

        $nominasfiltro->each(function ($nominasfiltro){
        
            $nominasfiltro->becarios;

            foreach ($nominasfiltro->becarios as $becario)
            {

                $becario->user;
            }
        });
        return View('sisbeca.nomina.listarpagados')->with('nominas',$nominasfiltro)->with('mes',$mes)->with('anho',$anho);
    }

    public function procesar()
    {
        //$ultimodia = date("Y-m-d",(mktime(0,0,0,date('m')+1,1,date('Y'))-1));
        $ultimodia= '2018-04-30';//prueba
        $fechagenerar = strtotime ( '-5 day' , strtotime ( $ultimodia ) ) ;//--poner-5
        $fechagenerar = date ( 'Y-m-d' , $fechagenerar );
        //$hoy = date('Y-m-d');
        $hoy='2018-04-25';//prueba
        $generar = false;
        $nominasaux = Nomina::where('mes','04')->where('year','2018')->get();

        if($hoy == $fechagenerar and count($nominasaux)==0)
        {
            $generar = true;
        }
        $anho = '2018';
        $mes = '04';
        $nominas = DB::table('nominas')
            ->select(DB::raw('count(*) as total_becarios,sum(total) as total_pagado, mes, year,created_at,fecha_generada, fecha_pago,sueldo_base, status, id'))
            ->where('status','=','pendiente')
            ->groupBy('mes','year')
            ->orderby('mes','desc')->orderby('year','desc')->get();
        return View('sisbeca.nomina.procesar')->with('nominas',$nominas)->with('generar',$generar)->with('mes',$mes)->with('anho',$anho);
        /*
        $ultimodia = date("Y-m-d",(mktime(0,0,0,date('m')+1,1,date('Y'))-1));
        $fechagenerar = strtotime ( '-5 day' , strtotime ( $ultimodia ) ) ;//--poner-5
        $fechagenerar = date ( 'Y-m-d' , $fechagenerar );

        $hoy = date('Y-m-d');
        $generar = false;
        $nominasaux = Nomina::where('mes',date('m'))->where('year',date('Y'))->get();

        if($hoy == $fechagenerar and count($nominasaux)==0)
        {
            $generar = true;
        }
        $anho = date ( 'Y' , strtotime($fechagenerar) );
        $mes = date ( 'm' , strtotime($fechagenerar) );
        $nominas = DB::table('nominas')
                     ->select(DB::raw('count(*) as total_becarios,sum(total) as total_pagado, mes, year,fecha_generada, fecha_pago,sueldo_base, status, id'))
                     ->where('status','=','pendiente')
                     ->groupBy('mes','year')
                     ->orderby('mes','desc')->orderby('year','desc')->get();
        return View('sisbeca.nomina.procesar')->with('nominas',$nominas)->with('generar',$generar)->with('mes',$mes)->with('anho',$anho);
    */
    }

    public function procesardetalle($mes, $anho)
    {
        //return $mes.'-'.$anho;
        $nominasfiltro = Nomina::where('mes','=',$mes)->where('year',$anho)->get();
        //return $nominasfiltro;
    	/*$ultimodia = date("Y-m-d",(mktime(0,0,0,date('m')+1,1,date('Y'))-1));
        $fechagenerar = strtotime ( '-3 day' , strtotime ( $ultimodia ) ) ;
        $fechagenerar = date ( 'Y-m-d' , $fechagenerar );
        $hoy = date('Y-m-d');
        $generar = false;
        if($hoy == $fechagenerar)
        {
            //verificar que ya fue generada esta nomina
            $generar = true;
        }
        $anho = date ( 'Y' , strtotime($fechagenerar) );
        $mes = date ( 'm' , strtotime($fechagenerar) );*/
        //return $nominasfiltro->becarios
        //$user= User::find(1);
        //return $user->a;
        //return $nominasfiltro[1]->becarios;

        $nominasfiltro->each(function ($nominasfiltro)
        {
            $nominasfiltro->becarios;

            foreach ($nominasfiltro->becarios as $becario) {

                $becario->user;
            }
        });
        if($nominasfiltro->count()==0)
        {
           // flash('Error en la nomina a Consultar no existen registros','danger');
        }
     
    	return View('sisbeca.nomina.procesardetalle')->with('nominas',$nominasfiltro)->with('mes',$mes)->with('anho',$anho);
    	
    }

    public function generartodo($mes,$anho)
    {
    	//validar que no se haya generado para una fecha
    	$becarios = Becario::where('acepto_terminos','=',1)->where('status','=','activo')->get();
    	$costo = Costo::first();
        /*$control = Control::first();
        if(is_null($control))
        {
            cantidad=0;
        }*/
        //$control = count(Nomina::groupby('mes','year')->get());
    	foreach($becarios as $becario)
    	{
    		$nomina = new Nomina();
    		$nomina->retroactivo = $becario->retroactivo;
    		$nomina->datos_nombres= $becario->user->name;
    		$nomina->datos_apellidos = $becario->user->last_name;
            $nomina->datos_cedula = $becario->user->cedula;
            $nomina->datos_email = $becario->user->email;
            $nomina->datos_cuenta = $becario->cuenta_bancaria;
            $nomina->datos_id= $becario->user_id;
            $becario->retroactivo=0;//se inicializa el retroactivo en 0 ya que fue cargado para el futuro pago
            $becario->save();
    		$nomina->sueldo_base = $costo->sueldo_becario;
    		$total = 0;
    		foreach($becario->factlibros as $factlibro)
    		{
                if($factlibro->status === 'cargada')
                {
                    //$total = $total + $factlibro->costo; //se comenta porque no se sumara aún
                    $factlibro->status='por procesar';
                    $factlibro->save();
                }
    		}
            $nomina->monto_libros = $total;
    		$nomina->total = $nomina->sueldo_base + $nomina->retroactivo + $total;
    		$nomina->mes = $mes;
    		$nomina->year = $anho;
    		$nomina->status = 'pendiente';
    		$nomina->fecha_pago = null;
    		$nomina->fecha_generada = null;
    		$nomina->save();

    		$bn = new BecarioNomina();
    		$bn->user_id = $becario->user_id;//--becario_id
    		$bn->nomina_id = $nomina->id;
    		$bn->save();

    	}
    	/*Enviar Alerta al directivo */
    	//primero veo si la alerta existe
        $alerta= Alerta::query()->where('titulo','=','Nomina(s) pendiente(s) por procesar')->where('tipo','=','nomina')->where('status','=','enviada')->first();
        if(!is_null($alerta))
        {
            $alerta->leido=false;
            $alerta->save();
        }
        else
        {
            $alerta = new Alerta();
            $alerta->titulo= 'Nomina(s) pendiente(s) por procesar';
            $alerta->descripcion= 'Tiene Nomina(s) pendiente(s) por procesar, se le aconseja procesar las nominas que tiene pendiente en el Menu de Nominas->Por Procesar';
            $alerta->user_id=null;
            $alerta->tipo = 'nomina';
            $alerta->nivel='alto';
            $alerta->save();
        }
        /* $control->cont = $control->cont+1
        $control->save();*/
        flash("La nómina del ".$mes."/".$anho." esta lista para ser procesada.",'success');
    	return  redirect()->route('nomina.procesar');
    }

    public function generadopdf($mes,$anho)
    {
        $nominas = Nomina::where('mes',$mes)->where('year',$anho)->where('status','=','generado')->get(); 
        $pdf = PDF::loadView('sisbeca.nomina.generadopdf', compact('nominas','mes','anho'));
        return $pdf->stream('listado.pdf','PDF xasa');
    }

    public function pagadopdf($mes,$anho)
    {
        $nominas = Nomina::where('mes',$mes)->where('year',$anho)->where('status','=','pagado')->get(); 
        $pdf = PDF::loadView('sisbeca.nomina.pagadopdf', compact('nominas','mes','anho'));
        return $pdf->stream('listado.pdf','PDF xasa');
    }

    public function cambiar()
    {
    	return -9;
    }

    public function generar(Request $request,$mes, $anho)
    {
        $nominas = Nomina::where('mes','=',$mes)->where('year','=',$anho)->get();
        foreach($nominas as $nomina)
        {
            $nomina->status = 'generado';
            $nomina->fecha_generada = date('Y-m-d H:m:s');
            $nomina->total = $nomina->sueldo_base+$nomina->retroactivo+$nomina->monto_libros;
            $nomina->save();
        }
        flash('La nómina fue generada exitosamente.','success');
        $nominas = Nomina::where('mes',$mes)->where('year',$anho)->get(); 
        $pdf = PDF::loadView('sisbeca.nomina.pdf', compact('nominas','mes','anho'));
        //return $pdf->download('nomina-pendiente.pdf',array('Attachment'=>0));
        return redirect()->route('nomina.listar');
    }

    public function pagar($mes,$anho)
    {
        $nominas = Nomina::where('mes','=',$mes)->where('year','=',$anho)->where('status','=','generado')->get();
        foreach($nominas as $nomina)
        { 
            $nomina->status = 'pagado';
            $nomina->fecha_pago = date('Y-m-d H:m:s');
            $nomina->save();
            // Alerta esto puede generar error
            //$becario = Becario::find($nomina->becarios[0]->user_id);
            $becario = Becario::find($nomina->datos_id);
            if(!is_null($becario)) {
                $becario->retroactivo = 0.0;
                $becario->save();
                $factlibros = FactLibro::where('becario_id', '=', $nomina->becarios[0]->user->id)->where('status', '=', 'revisada')->where('mes', '=', $mes)->where('year', '=', $anho)->get();
                foreach ($factlibros as $factura)
                {
                    $factura->status = 'pagada';
                    $factura->save();
                }
            }
            
        }
        return redirect()->route('nomina.pagadas');
    }

    public function pagadas()
    {
        $ultimodia = date("Y-m-d",(mktime(0,0,0,date('m')+1,1,date('Y'))-1));
        $fechagenerar = strtotime ( '-1 day' , strtotime ( $ultimodia ) ) ;//--poner-5
        $fechagenerar = date ( 'Y-m-d' , $fechagenerar );
        $hoy = date('Y-m-d');
        $generar = false;
        $nominasaux = Nomina::where('mes',date('m'))->where('year',date('Y'))->get();
        if($hoy == $fechagenerar and count($nominasaux)==0)
        {
            $generar = true;
        }
        $anho = date ( 'Y' , strtotime($fechagenerar) );
        $mes = date ( 'm' , strtotime($fechagenerar) );
        $nominas = DB::table('nominas')
                     ->select(DB::raw('count(*) as total_becarios,sum(total) as total_pagado, mes, year,fecha_generada, fecha_pago,sueldo_base, status, id'))
                     ->where('status','=','pagado')
                     ->groupBy('mes','year')
                     ->orderby('mes','desc')->orderby('year','desc')->get();
        return view('sisbeca.nomina.pagadas')->with('nominas',$nominas)->with('generar',$generar)->with('mes',$mes)->with('anho',$anho);
    }

    public function validarFacturas(Request $request,$mes,$anho,$id)
    {
	    $becario= Becario::find($id);
	    $nominasAProcesar=$becario->nominas;
        $nomina = $nominasAProcesar->where('mes','=',$mes)->where('year','=',$anho)->where('status','=','pendiente')->first(); //Nomina a Actualizar campo libros
        if(!is_null($nomina))
        {
            $factLibros = FactLibro::query()->where('becario_id', '=', $id)->where('status', '=', 'por procesar')->get();
            $total= $nomina->total;
            $libros= $nomina->monto_libros;
            foreach ($factLibros as $libro)
            {
                if ($request->get($libro->id) == 1)
                {
                    $libro->status= 'revisada';
                    $libro->mes=$mes;
                    $libro->year=$anho;
                    $libros +=$libro->costo;
                }
                else
                {
                    $libro->status= 'rechazada';
                }
                $libro->save();
            }
            $total += $libros;
            $nomina->total= $total;
            $nomina->monto_libros=$libros;
            $nomina->save();
            flash('Las Facturas de '.$becario->user->name.' '.$becario->user->apellido.' Han sido revisadas y procesadas exitosamente!','success')->important();
        }
        return redirect()->route('nomina.procesar.detalle',array('$mes'=>$mes, 'anho'=>$anho));
    }
}
