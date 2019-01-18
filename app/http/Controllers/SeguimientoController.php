<?php

namespace avaa\Http\Controllers;

use Illuminate\Http\Request;
use avaa\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use DB;
use avaa\Becario;
use avaa\Actividad;
use avaa\ActividadBecario;
use avaa\Curso;
use avaa\Voluntariado;
use avaa\Periodo;
use DateTime;

class SeguimientoController extends Controller
{
    public function becariosreportegeneral()
    {
        $becarios = Becario::activos()->inactivos()->terminosaceptados()->probatorio1()->probatorio2()->get();
        return view('sisbeca.becarios.reportegeneral')->with(compact('becarios'));
    }

   	public function todosbecarios()
   	{
        $becarios = Becario::activos()->inactivos()->terminosaceptados()->probatorio1()->probatorio2()->get();
        return view('sisbeca.becarios.todos')->with(compact('becarios'));
   	}

    public function todosbecariosapi()
    {
        $todos = collect();
        $becarios = Becario::with("user")->activos()->inactivos()->terminosaceptados()->probatorio1()->probatorio2()->get();
        foreach ($becarios as $becario)
        {
            $todos->push(array(
                'id' => $becario->user->id,
                'estatus' => $becario->status,
                'rol' => $becario->user->rol,
                'cedula' => $becario->user->cedula,
                "becario" => $becario->user->name.' '.$becario->user->last_name,
                'final_carga_academica' => $becario->final_carga_academica
            ));
        }
        return response()->json(['becarios'=>$todos]);
    }

    public function obtenerestatusbecarios()
    {
        $estatus = (object)["0"=>"egresado", "1"=>"activo", "2"=>"inactivo","3"=>"probatorio1","4"=>"probatorio2"];
        return response()->json(['estatus'=>$estatus]);
    }

    public function actualizarestatusbecario(Request $request,$id)
    {
        $becario = Becario::find($id);
        $becario->status = $request->estatus;
        $becario->save();
        return response()->json(['success'=>'El becario '.$becario->user->nombreyapellido().' fue actualizado exitosamente.']);
    }

    public function guardarfechaacademica(Request $request,$id)
    {
        $becario = Becario::find($id);
        if($request->fecha_nula==0)
        {
            $becario->final_carga_academica = DateTime::createFromFormat('d/m/Y', $request->fecha)->format('Y-m-d');
        }
        else
        {
            $becario->final_carga_academica = null;
        }
       
        $becario->save();
        return response()->json(['success'=>'Al becario '.$becario->user->nombreyapellido().' se le actualizó la fecha final de carga académica.']);
    }

   	public function todosbecariosservicio()
   	{
   		$becarios = Becario::activos()->terminosaceptados()->probatorio1()->probatorio2()->get();
   	}

    public function resumenanhomes($id,$anho,$mes)
    {
        $becario = Becario::find($id);
        if(Auth::user()->id==$id or Auth::user()->esCoordinador() or Auth::user()->esDirectivo())
        {
            if($mes!='00')
            {
                $periodos = Periodo::paraBecario($id)->porAnho($anho)->porMes($mes)->ordenadoPorPeriodo('asc')->with('aval')->with('materias')->get();
                $voluntariados = DB::table('voluntariados')
                    ->where('aval.tipo','=','comprobante')
                    ->where('aval.estatus','=','aceptada')
                    ->groupby('voluntariados.tipo')
                    ->selectRaw('*,SUM(horas) as horas_voluntariado,Count(*) as total_voluntariado,voluntariados.tipo as tipo_voluntariado')
                    ->join('aval', function ($join) use($id,$anho,$mes)
                {
                    $join->on('voluntariados.aval_id','=','aval.id')
                    ->where('voluntariados.becario_id','=',$id)
                    ->whereYear('voluntariados.fecha', '=', $anho)
                    ->whereMonth('voluntariados.fecha', '=', $mes)
                    ->orderby('voluntariados.fecha','asc');
                    
                })->get();
                $cursos = DB::table('cursos')
                    ->where('aval.tipo','=','nota')
                    ->where('aval.estatus','=','aceptada')
                    ->groupby('cursos.modulo')
                    ->orderby('cursos.modulo','asc')
                    ->selectRaw('*,AVG(nota) as promedio_modulo,Count(*) as total_modulo')
                    ->join('aval', function ($join) use($id,$anho,$mes)
                {
                    $join->on('cursos.aval_id','=','aval.id')
                    ->where('cursos.becario_id','=',$id)
                    ->whereYear('cursos.created_at', '=', $anho)
                    ->whereMonth('cursos.created_at', '=', $mes)
                    ;
                    
                })->get();
                $actividades_facilitadas = DB::table('actividades')
                ->selectRaw("*,SUM(horas) as horas_voluntariado,Count(*) as total_actividades")
                ->join('actividades_facilitadores', function ($join) use($id,$anho,$mes)
                {
                    $join->on('actividades_facilitadores.actividad_id', '=','actividades.id')
                        ->where('actividades_facilitadores.becario_id', '=', $id)
                        ->whereYear('actividades_facilitadores.created_at', '=', $anho)
                        ->whereMonth('actividades_facilitadores.created_at', '=', $mes)
                        ;
                })->get();
                // asistio talleres presenciales
                $a_t_p = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','taller')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho,$mes)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->whereMonth('actividades_becarios.created_at', '=', $mes)
                        ->where('actividades_becarios.estatus','=','asistio');
                })->first();

                //asistio talleres virtuales
                $a_t_v = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','taller')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho,$mes)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->whereMonth('actividades_becarios.created_at', '=', $mes)
                        ->where('actividades_becarios.estatus','=','asistio');

                })->first();

                //asistio chat club presenciales
                $a_c_p = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','chat club')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho,$mes)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->whereMonth('actividades_becarios.created_at', '=', $mes)
                        ->where('actividades_becarios.estatus','=','asistio');

                })->first();

                //asistio chat club virtuales
                $a_c_v = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','chat club')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho,$mes)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->whereMonth('actividades_becarios.created_at', '=', $mes)
                        ->where('actividades_becarios.estatus','=','asistio');

                })->first();
                
                
                //no asistio taller presencial
                $na_t_p = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','taller')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho,$mes)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->whereMonth('actividades_becarios.created_at', '=', $mes)
                        ->where('actividades_becarios.estatus','=','no asistio');

                })->first();

                //no asistio taller virtual
                $na_t_v = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','taller')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho,$mes)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->whereMonth('actividades_becarios.created_at', '=', $mes)
                        ->where('actividades_becarios.estatus','=','no asistio');

                })->first();

                //no asistio chat club presencial
                $na_c_p = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','chat club')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho,$mes)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->whereMonth('actividades_becarios.created_at', '=', $mes)
                        ->where('actividades_becarios.estatus','=','no asistio');

                })->first();

                //no asistio chat club virtual
                $na_c_v = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','chat club')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho,$mes)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->whereMonth('actividades_becarios.created_at', '=', $mes)
                        ->where('actividades_becarios.estatus','=','no asistio');

                })->first();
            }
            else
            {
                $periodos = Periodo::paraBecario($id)->porAnho($anho)->ordenadoPorPeriodo('asc')->with('aval')->with('materias')->get();
                $voluntariados = DB::table('voluntariados')
                    ->where('aval.tipo','=','comprobante')
                    ->where('aval.estatus','=','aceptada')
                    ->groupby('voluntariados.tipo')
                    ->selectRaw('*,SUM(horas) as horas_voluntariado,Count(*) as total_voluntariado,voluntariados.tipo as tipo_voluntariado')
                    ->join('aval', function ($join) use($id,$anho,$mes)
                {
                    $join->on('voluntariados.aval_id','=','aval.id')
                    ->where('voluntariados.becario_id','=',$id)
                    ->whereYear('voluntariados.fecha', '=', $anho)
                    ->orderby('voluntariados.fecha','asc');
                    
                })->get();
                $cursos = DB::table('cursos')
                    ->where('aval.tipo','=','nota')
                    ->where('aval.estatus','=','aceptada')
                    ->groupby('cursos.modulo')
                    ->orderby('cursos.modulo','asc')
                    ->selectRaw('*,AVG(nota) as promedio_modulo,Count(*) as total_modulo')
                    ->join('aval', function ($join) use($id,$anho,$mes)
                {
                    $join->on('cursos.aval_id','=','aval.id')
                    ->where('cursos.becario_id','=',$id)
                    ->whereYear('cursos.created_at', '=', $anho)
                    ;
                    
                })->get();
                $actividades_facilitadas = DB::table('actividades')
                ->selectRaw("*,SUM(horas) as horas_voluntariado,Count(*) as total_actividades")
                ->join('actividades_facilitadores', function ($join) use($id,$anho)
                {
                    $join->on('actividades_facilitadores.actividad_id', '=','actividades.id')
                        ->where('actividades_facilitadores.becario_id', '=', $id)
                        ->whereYear('actividades_facilitadores.created_at', '=', $anho);
                })->get();
                // asistio talleres presenciales
                $a_t_p = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','taller')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->where('actividades_becarios.estatus','=','asistio');
                })->first();

                //asistio talleres virtuales
                $a_t_v = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','taller')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->where('actividades_becarios.estatus','=','asistio');

                })->first();

                //asistio chat club presenciales
                $a_c_p = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','chat club')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->where('actividades_becarios.estatus','=','asistio');

                })->first();

                //asistio chat club virtuales
                $a_c_v = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','chat club')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->where('actividades_becarios.estatus','=','asistio');

                })->first();
                
                
                //no asistio taller presencial
                $na_t_p = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','taller')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->where('actividades_becarios.estatus','=','no asistio');

                })->first();

                //no asistio taller virtual
                $na_t_v = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','taller')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->where('actividades_becarios.estatus','=','no asistio');

                })->first();

                //no asistio chat club presencial
                $na_c_p = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','chat club')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->where('actividades_becarios.estatus','=','no asistio');

                })->first();

                //no asistio chat club virtual
                $na_c_v = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','chat club')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->where('actividades_becarios.estatus','=','no asistio');

                })->first();
                
            }
            $asistio = array(
                "a_t_v" => $a_t_v->total_actividades,
                "a_t_p" => $a_t_p->total_actividades,
                "a_c_v" => $a_c_v->total_actividades,
                "a_c_p" => $a_c_p->total_actividades,
            );
            $noasistio = array(
                "na_t_v" => $na_t_v->total_actividades,
                "na_t_p" => $na_t_p->total_actividades,
                "na_c_v" => $na_c_v->total_actividades,
                "na_c_p" => $na_c_p->total_actividades,
            );
            return response()->json(['regimen'=>$becario->regimen,'anho'=>$anho,'mes'=>$mes,'periodos'=>$periodos,'voluntariados'=>$voluntariados,'cursos'=>$cursos,'actividades_facilitadas'=>$actividades_facilitadas[0],"asistio"=>$asistio,"noasistio"=>$noasistio]);
        }
        return response()->json(['error'=>"Error de permisos"]);
    }   

   	public function resumen($id)
   	{
   		$anho = date('Y');
   		if(Auth::user()->id==$id or Auth::user()->esCoordinador() or Auth::user()->esDirectivo())
   		{
   			$becario = Becario::find($id);
	   		$periodos = Periodo::paraBecario($id)->porAnho($anho)->ordenadoPorPeriodo('asc')->get();
            // ------------------ Esto esta funcional
    	   		//$voluntariados = Voluntariado::paraBecario($id)->porAnho($anho)->sumaHoras('horas_voluntariado')->contarVoluntariado('total_voluntariado')->agrupadoPorTipo()->get();
    	   		//$cursos = Curso::paraBecario($id)->porAnho($anho)->agrupadoPorModulo()->promedioPorModulo('promedio_modulo')->contarModulo('total_modulo')->get();
            //------------------ Ejemplos de consultas
            //En estas consultas join no se como introducir scope
            //->selectRaw('*,Count(*) as total_actividades')
            //Count(*) as total_cursos
            //AVG(nota) as nota_modulo
            /*$users = DB::table('aval')
                ->leftJoin('cursos', 'aval.becario_id', '=', 'cursos.becario_id')
                ->where('cursos.becario_id',"")
                ->get();*/
            //----------------- Ejemplos de consultas

            $voluntariados = DB::table('voluntariados')
                ->where('aval.tipo','=','comprobante')
                ->where('aval.estatus','=','aceptada')
                ->groupby('voluntariados.tipo')
                ->selectRaw('*,SUM(horas) as horas_voluntariado,Count(*) as total_voluntariado,voluntariados.tipo as tipo_voluntariado')
                ->join('aval', function ($join) use($id,$anho)
            {
              $join->on('voluntariados.aval_id','=','aval.id')
                ->where('voluntariados.becario_id','=',$id)
                ->whereYear('voluntariados.fecha', '=', $anho)
                ->orderby('voluntariados.fecha','asc');
                
            })->get();
            //return $voluntariados;

            $cursos = DB::table('cursos')
                ->where('aval.tipo','=','nota')
                ->where('aval.estatus','=','aceptada')
                ->groupby('cursos.modulo')
                ->orderby('cursos.modulo','asc')
                ->selectRaw('*,AVG(nota) as promedio_modulo,Count(*) as total_modulo')
                ->join('aval', function ($join) use($id,$anho)
            {
              $join->on('cursos.aval_id','=','aval.id')
                ->where('cursos.becario_id','=',$id)
                ->whereYear('cursos.created_at', '=', $anho)
                ;
                
            })->get();
            //return $cursos;

            /* Sirve pero no del todo
            $periodos = Periodo::with('materias')->
                where('aval.tipo','=','constancia')
                ->where('aval.estatus','=','aceptada')
                ->groupby('periodos.numero_periodo')
                ->selectRaw('*,Count(*) as total_modulo')
                ->join('aval', function ($join) use($id,$anho)
            {
              $join->on('periodos.aval_id','=','aval.id')
                ->where('periodos.becario_id','=',$id)
                ->whereYear('periodos.created_at', '=', $anho)
                ->orderby('periodos.numero_periodo','desc');

                
            })->get();*/
            //return $periodos;

            $actividades_facilitadas = DB::table('actividades')
                    ->selectRaw("*,SUM(horas) as horas_voluntariado,Count(*) as total_actividades")
                    ->join('actividades_facilitadores', function ($join) use($id,$anho)
            {
                $join->on('actividades_facilitadores.actividad_id', '=','actividades.id')
                    ->where('actividades_facilitadores.becario_id', '=', $id)
                    ->whereYear('actividades_facilitadores.created_at', '=', $anho);

            })->get();
            //return $actividades_facilitadas;

            // asistio talleres presenciales
    	   	$a_t_p = DB::table('actividades')
            ->selectRaw('*,Count(*) as total_actividades')
            ->where('tipo','taller')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho)
            {
               $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                    ->where('actividades_becarios.becario_id', '=', $id)
                    ->whereYear('actividades_becarios.created_at', '=', $anho)
                    ->where('actividades_becarios.estatus','=','asistio');
            })->first();

            //asistio talleres virtuales
            $a_t_v = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','taller')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho)
            {
               $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                    ->where('actividades_becarios.becario_id', '=', $id)
                    ->whereYear('actividades_becarios.created_at', '=', $anho)
                    ->where('actividades_becarios.estatus','=','asistio');

            })->first();

            //asistio chat club presenciales
            $a_c_p = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','chat club')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho)
            {
               $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                    ->where('actividades_becarios.becario_id', '=', $id)
                    ->whereYear('actividades_becarios.created_at', '=', $anho)
                    ->where('actividades_becarios.estatus','=','asistio');

            })->first();

            //asistio chat club virtuales
            $a_c_v = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','chat club')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho)
            {
               $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                    ->where('actividades_becarios.becario_id', '=', $id)
                    ->whereYear('actividades_becarios.created_at', '=', $anho)
                    ->where('actividades_becarios.estatus','=','asistio');

            })->first();
            
            
            //no asistio taller presencial
            $na_t_p = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','taller')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho)
            {
               $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                    ->where('actividades_becarios.becario_id', '=', $id)
                    ->whereYear('actividades_becarios.created_at', '=', $anho)
                    ->where('actividades_becarios.estatus','=','no asistio');

            })->first();

            //no asistio taller virtual
            $na_t_v = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','taller')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho)
            {
               $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                    ->where('actividades_becarios.becario_id', '=', $id)
                    ->whereYear('actividades_becarios.created_at', '=', $anho)
                    ->where('actividades_becarios.estatus','=','no asistio');

            })->first();

            //no asistio chat club presencial
            $na_c_p = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','chat club')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho)
            {
               $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                    ->where('actividades_becarios.becario_id', '=', $id)
                    ->whereYear('actividades_becarios.created_at', '=', $anho)
                    ->where('actividades_becarios.estatus','=','no asistio');

            })->first();

            //no asistio chat club virtual
            $na_c_v = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','chat club')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho)
            {
               $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                    ->where('actividades_becarios.becario_id', '=', $id)
                    ->whereYear('actividades_becarios.created_at', '=', $anho)
                    ->where('actividades_becarios.estatus','=','no asistio');

            })->first();
            
            //---------------- Como estaban antes las consultas para Actividades 
            /*
            $actividades_noasistio = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->groupby('tipo','modalidad')->join('actividades_becarios', function ($join) use($id,$anho)
            {
               $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                    ->where('actividades_becarios.becario_id', '=', $id)
                    ->whereYear('actividades_becarios.created_at', '=', $anho)
                    ->where('actividades_becarios.estatus','=','no asistio');

            })->first();*/

	   		return view('sisbeca.becarios.resumen')->with(compact('becario','anho','periodos','voluntariados','cursos','actividades_facilitadas','a_t_p','a_t_v','a_c_p','a_c_v','na_t_p','na_t_v','na_c_p','na_c_v'));
   		}
   		else
   		{
   			return view('sisbeca.error.404');
   		}
   	}

    public function resumenpdf($id)
    {
        $anho = date('Y');
        $becario = Becario::find($id);
        $periodos = Periodo::paraBecario($id)->porAnho($anho)->ordenadoPorPeriodo('asc')->get();
        $voluntariados = DB::table('voluntariados')
            ->where('aval.tipo','=','comprobante')
            ->where('aval.estatus','=','aceptada')
            ->groupby('voluntariados.tipo')
            ->selectRaw('*,SUM(horas) as horas_voluntariado,Count(*) as total_voluntariado,voluntariados.tipo as tipo_voluntariado')
            ->join('aval', function ($join) use($id,$anho)
        {
          $join->on('voluntariados.aval_id','=','aval.id')
            ->where('voluntariados.becario_id','=',$id)
            ->whereYear('voluntariados.created_at', '=', $anho)
            ->orderby('voluntariados.created_at','asc');
            
        })->get();
        $cursos = DB::table('cursos')
            ->where('aval.tipo','=','nota')
            ->where('aval.estatus','=','aceptada')
            ->groupby('cursos.modulo')
            ->orderby('cursos.modulo','asc')
            ->selectRaw('*,AVG(nota) as promedio_modulo,Count(*) as total_modulo')
            ->join('aval', function ($join) use($id,$anho)
        {
          $join->on('cursos.aval_id','=','aval.id')
            ->where('cursos.becario_id','=',$id)
            ->whereYear('cursos.created_at', '=', $anho)
            ;
            
        })->get();
         $actividades_facilitadas = DB::table('actividades')
                ->selectRaw("*,SUM(horas) as horas_voluntariado,Count(*) as total_actividades")
                ->join('actividades_facilitadores', function ($join) use($id,$anho)
        {
            $join->on('actividades_facilitadores.actividad_id', '=','actividades.id')
                ->where('actividades_facilitadores.becario_id', '=', $id)
                ->whereYear('actividades_facilitadores.created_at', '=', $anho);

        })->get();
        //return $actividades_facilitadas;

        // asistio talleres presenciales
        $a_t_p = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','taller')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho)
        {
           $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                ->where('actividades_becarios.becario_id', '=', $id)
                ->whereYear('actividades_becarios.created_at', '=', $anho)
                ->where('actividades_becarios.estatus','=','asistio');

        })->first();

        //asistio talleres virtuales
        $a_t_v = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','taller')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho)
        {
           $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                ->where('actividades_becarios.becario_id', '=', $id)
                ->whereYear('actividades_becarios.created_at', '=', $anho)
                ->where('actividades_becarios.estatus','=','asistio');

        })->first();

        //asistio chat club presenciales
        $a_c_p = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','chat club')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho)
        {
           $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                ->where('actividades_becarios.becario_id', '=', $id)
                ->whereYear('actividades_becarios.created_at', '=', $anho)
                ->where('actividades_becarios.estatus','=','asistio');

        })->first();

        //asistio chat club virtuales
        $a_c_v = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','chat club')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho)
        {
           $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                ->where('actividades_becarios.becario_id', '=', $id)
                ->whereYear('actividades_becarios.created_at', '=', $anho)
                ->where('actividades_becarios.estatus','=','asistio');

        })->first();
        
        
        //no asistio taller presencial
        $na_t_p = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','taller')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho)
        {
           $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                ->where('actividades_becarios.becario_id', '=', $id)
                ->whereYear('actividades_becarios.created_at', '=', $anho)
                ->where('actividades_becarios.estatus','=','no asistio');

        })->first();

        //no asistio taller virtual
        $na_t_v = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','taller')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho)
        {
           $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                ->where('actividades_becarios.becario_id', '=', $id)
                ->whereYear('actividades_becarios.created_at', '=', $anho)
                ->where('actividades_becarios.estatus','=','no asistio');

        })->first();

        //no asistio chat club presencial
        $na_c_p = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','chat club')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho)
        {
           $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                ->where('actividades_becarios.becario_id', '=', $id)
                ->whereYear('actividades_becarios.created_at', '=', $anho)
                ->where('actividades_becarios.estatus','=','no asistio');

        })->first();

        //no asistio chat club virtual
        $na_c_v = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','chat club')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho)
        {
           $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                ->where('actividades_becarios.becario_id', '=', $id)
                ->whereYear('actividades_becarios.created_at', '=', $anho)
                ->where('actividades_becarios.estatus','=','no asistio');

        })->first();

        $pdf = PDF::loadView('pdf.seguimiento.resumen', compact('becario','anho','periodos','voluntariados','cursos','actividades_facilitadas','a_t_p','a_t_v','a_c_p','a_c_v','na_t_p','na_t_v','na_c_p','na_c_v'));
        return $pdf->stream('resumen-becario.pdf');
    }

    public function resumenanhomespdf($id,$anho,$mes)
    {
        $becario = Becario::find($id);
        if(Auth::user()->id==$id or Auth::user()->esCoordinador() or Auth::user()->esDirectivo())
        {
            if($mes!='00')
            {
                $periodos = Periodo::paraBecario($id)->porAnho($anho)->porMes($mes)->ordenadoPorPeriodo('asc')->with('aval')->with('materias')->get();
                $voluntariados = DB::table('voluntariados')
                    ->where('aval.tipo','=','comprobante')
                    ->where('aval.estatus','=','aceptada')
                    ->groupby('voluntariados.tipo')
                    ->selectRaw('*,SUM(horas) as horas_voluntariado,Count(*) as total_voluntariado,voluntariados.tipo as tipo_voluntariado')
                    ->join('aval', function ($join) use($id,$anho,$mes)
                {
                    $join->on('voluntariados.aval_id','=','aval.id')
                    ->where('voluntariados.becario_id','=',$id)
                    ->whereYear('voluntariados.fecha', '=', $anho)
                    ->whereMonth('voluntariados.fecha', '=', $mes)
                    ->orderby('voluntariados.fecha','asc');
                    
                })->get();
                $cursos = DB::table('cursos')
                    ->where('aval.tipo','=','nota')
                    ->where('aval.estatus','=','aceptada')
                    ->groupby('cursos.modulo')
                    ->orderby('cursos.modulo','asc')
                    ->selectRaw('*,AVG(nota) as promedio_modulo,Count(*) as total_modulo')
                    ->join('aval', function ($join) use($id,$anho,$mes)
                {
                    $join->on('cursos.aval_id','=','aval.id')
                    ->where('cursos.becario_id','=',$id)
                    ->whereYear('cursos.created_at', '=', $anho)
                    ->whereMonth('cursos.created_at', '=', $mes)
                    ;
                    
                })->get();
                $actividades_facilitadas = DB::table('actividades')
                ->selectRaw("*,SUM(horas) as horas_voluntariado,Count(*) as total_actividades")
                ->join('actividades_facilitadores', function ($join) use($id,$anho,$mes)
                {
                    $join->on('actividades_facilitadores.actividad_id', '=','actividades.id')
                        ->where('actividades_facilitadores.becario_id', '=', $id)
                        ->whereYear('actividades_facilitadores.created_at', '=', $anho)
                        ->whereMonth('actividades_facilitadores.created_at', '=', $mes)
                        ;
                })->get();
                // asistio talleres presenciales
                $a_t_p = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','taller')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho,$mes)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->whereMonth('actividades_becarios.created_at', '=', $mes)
                        ->where('actividades_becarios.estatus','=','asistio');
                })->first();

                //asistio talleres virtuales
                $a_t_v = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','taller')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho,$mes)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->whereMonth('actividades_becarios.created_at', '=', $mes)
                        ->where('actividades_becarios.estatus','=','asistio');

                })->first();

                //asistio chat club presenciales
                $a_c_p = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','chat club')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho,$mes)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->whereMonth('actividades_becarios.created_at', '=', $mes)
                        ->where('actividades_becarios.estatus','=','asistio');

                })->first();

                //asistio chat club virtuales
                $a_c_v = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','chat club')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho,$mes)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->whereMonth('actividades_becarios.created_at', '=', $mes)
                        ->where('actividades_becarios.estatus','=','asistio');

                })->first();
                
                
                //no asistio taller presencial
                $na_t_p = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','taller')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho,$mes)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->whereMonth('actividades_becarios.created_at', '=', $mes)
                        ->where('actividades_becarios.estatus','=','no asistio');

                })->first();

                //no asistio taller virtual
                $na_t_v = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','taller')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho,$mes)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->whereMonth('actividades_becarios.created_at', '=', $mes)
                        ->where('actividades_becarios.estatus','=','no asistio');

                })->first();

                //no asistio chat club presencial
                $na_c_p = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','chat club')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho,$mes)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->whereMonth('actividades_becarios.created_at', '=', $mes)
                        ->where('actividades_becarios.estatus','=','no asistio');

                })->first();

                //no asistio chat club virtual
                $na_c_v = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','chat club')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho,$mes)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->whereMonth('actividades_becarios.created_at', '=', $mes)
                        ->where('actividades_becarios.estatus','=','no asistio');

                })->first();
            }
            else
            {
                $periodos = Periodo::paraBecario($id)->porAnho($anho)->ordenadoPorPeriodo('asc')->with('aval')->with('materias')->get();
                $voluntariados = DB::table('voluntariados')
                    ->where('aval.tipo','=','comprobante')
                    ->where('aval.estatus','=','aceptada')
                    ->groupby('voluntariados.tipo')
                    ->selectRaw('*,SUM(horas) as horas_voluntariado,Count(*) as total_voluntariado,voluntariados.tipo as tipo_voluntariado')
                    ->join('aval', function ($join) use($id,$anho,$mes)
                {
                    $join->on('voluntariados.aval_id','=','aval.id')
                    ->where('voluntariados.becario_id','=',$id)
                    ->whereYear('voluntariados.fecha', '=', $anho)
                    ->orderby('voluntariados.fecha','asc');
                    
                })->get();
                $cursos = DB::table('cursos')
                    ->where('aval.tipo','=','nota')
                    ->where('aval.estatus','=','aceptada')
                    ->groupby('cursos.modulo')
                    ->orderby('cursos.modulo','asc')
                    ->selectRaw('*,AVG(nota) as promedio_modulo,Count(*) as total_modulo')
                    ->join('aval', function ($join) use($id,$anho,$mes)
                {
                    $join->on('cursos.aval_id','=','aval.id')
                    ->where('cursos.becario_id','=',$id)
                    ->whereYear('cursos.created_at', '=', $anho)
                    ;
                    
                })->get();
                $actividades_facilitadas = DB::table('actividades')
                ->selectRaw("*,SUM(horas) as horas_voluntariado,Count(*) as total_actividades")
                ->join('actividades_facilitadores', function ($join) use($id,$anho)
                {
                    $join->on('actividades_facilitadores.actividad_id', '=','actividades.id')
                        ->where('actividades_facilitadores.becario_id', '=', $id)
                        ->whereYear('actividades_facilitadores.created_at', '=', $anho);
                })->get();
                // asistio talleres presenciales
                $a_t_p = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','taller')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->where('actividades_becarios.estatus','=','asistio');
                })->first();

                //asistio talleres virtuales
                $a_t_v = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','taller')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->where('actividades_becarios.estatus','=','asistio');

                })->first();

                //asistio chat club presenciales
                $a_c_p = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','chat club')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->where('actividades_becarios.estatus','=','asistio');

                })->first();

                //asistio chat club virtuales
                $a_c_v = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','chat club')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->where('actividades_becarios.estatus','=','asistio');

                })->first();
                
                
                //no asistio taller presencial
                $na_t_p = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','taller')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->where('actividades_becarios.estatus','=','no asistio');

                })->first();

                //no asistio taller virtual
                $na_t_v = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','taller')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->where('actividades_becarios.estatus','=','no asistio');

                })->first();

                //no asistio chat club presencial
                $na_c_p = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','chat club')->where('modalidad','presencial')->join('actividades_becarios', function ($join) use($id,$anho)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->where('actividades_becarios.estatus','=','no asistio');

                })->first();

                //no asistio chat club virtual
                $na_c_v = DB::table('actividades')
                    ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','chat club')->where('modalidad','virtual')->join('actividades_becarios', function ($join) use($id,$anho)
                {
                   $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                        ->where('actividades_becarios.becario_id', '=', $id)
                        ->whereYear('actividades_becarios.created_at', '=', $anho)
                        ->where('actividades_becarios.estatus','=','no asistio');

                })->first();
                
            }
            $asistio = array(
                "a_t_v" => $a_t_v->total_actividades,
                "a_t_p" => $a_t_p->total_actividades,
                "a_c_v" => $a_c_v->total_actividades,
                "a_c_p" => $a_c_p->total_actividades,
            );
            $noasistio = array(
                "na_t_v" => $na_t_v->total_actividades,
                "na_t_p" => $na_t_p->total_actividades,
                "na_c_v" => $na_c_v->total_actividades,
                "na_c_p" => $na_c_p->total_actividades,
            );
            $actividades_facilitadas=$actividades_facilitadas[0];
            switch ($mes)
            {
                case '00':
                    $mes_completo = "Todos";
                break;
                case '01':
                    $mes_completo = "Enero";
                break;
                case '02':
                    $mes_completo = "Febrero";
                break;
                case '03':
                    $mes_completo = "Marzo";
                break;
                case '04':
                    $mes_completo = "Abril";
                break;
                case '05':
                    $mes_completo = "Mayo";
                break;
                case '06':
                    $mes_completo = "Junio";
                break;
                case '07':
                    $mes_completo = "Julio";
                break;
                case '08':
                    $mes_completo = "Agosto";
                break;
                case '09':
                    $mes_completo = "Septiembre";
                break;
                case '10':
                    $mes_completo = "Octubre";
                break;
                case '11':
                    $mes_completo = "Noviembre";
                break;
                case '12':
                    $mes_completo = "Diciembre";
                break;
            }
            $pdf = PDF::loadView('pdf.seguimiento.resumen-mes-anho', compact('becario','regimen','anho','mes','periodos','voluntariados','cursos','actividades_facilitadas','asistio','noasistio','mes_completo'));

            return $pdf->stream('Resumen-Becario-'.$mes_completo.'-'.$anho.'-'.$becario->user->nombreyapellido().'.pdf');
        }
    }
}
