<?php

namespace avaa\Http\Controllers;

use Illuminate\Http\Request;
use avaa\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use avaa\Becario;
use avaa\Actividad;
use avaa\ActividadBecario;
use avaa\Curso;
use avaa\Voluntariado;
use avaa\Periodo;

class SeguimientoController extends Controller
{
   	public function todosbecarios()
   	{
        $becarios = Becario::activos()->inactivos()->terminosaceptados()->probatorio1()->probatorio2()->get();
        return view('sisbeca.becarios.todos')->with(compact('becarios'));
   	}

   	public function todosbecariosservicio()
   	{
   		$becarios = Becario::activos()->terminosaceptados()->probatorio1()->probatorio2()->get();
   	}

   	public function resumen($id)
   	{
   		$anho = date('Y');
   		if(Auth::user()->id==$id or Auth::user()->esCoordinador() or Auth::user()->esDirectivo())
   		{
   			$becario = Becario::find($id);
	   		$periodos = Periodo::paraBecario($id)->porAnho($anho)->ordenadoPorPeriodo('asc')->get();
	   		//$voluntariados = Voluntariado::paraBecario($id)->porAnho($anho)->sumaHoras('horas_voluntariado')->contarVoluntariado('total_voluntariado')->agrupadoPorTipo()->get();
	   		//$cursos = Curso::paraBecario($id)->porAnho($anho)->agrupadoPorModulo()->promedioPorModulo('promedio_modulo')->contarModulo('total_modulo')->get();
        
        //En estas consultas join no se como introducir scope
        //->selectRaw('*,Count(*) as total_actividades')
        //Count(*) as total_cursos
        //AVG(nota) as nota_modulo
        /*$users = DB::table('aval')
            ->leftJoin('cursos', 'aval.becario_id', '=', 'cursos.becario_id')
            ->where('cursos.becario_id',"")
            ->get();*/
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

        //return $voluntariados;

        $cursos = DB::table('cursos')
            ->where('aval.tipo','=','nota')
            ->where('aval.estatus','=','aceptada')
            
            ->selectRaw('*,AVG(nota) as promedio_modulo,Count(*) as total_modulo')
            ->join('aval', function ($join) use($id,$anho)
        {
          $join->on('cursos.aval_id','=','aval.id')
            ->where('cursos.becario_id','=',$id)
            ->whereYear('cursos.created_at', '=', $anho)
            ->orderby('cursos.modulo','asc')
            ->groupby('cursos.modulo');
        })->get();

        //return $cursos;

        /*$periodos = Periodo::
            where('aval.tipo','=','constancia')
            ->where('aval.estatus','=','aceptada')
              ->groupby('periodos.numero_periodo')
            ->selectRaw('*,Count(*) as total_modulo')


            ->join('aval', function ($join) use($id,$anho)
        {
          $join->on('periodos.aval_id','=','aval.id')
            ->where('periodos.becario_id','=',$id)
            ->whereYear('periodos.created_at', '=', $anho)
            ->orderby('periodos.numero_periodo','asc');

            
        })->get();*/


        $actividades_facilitadas = DB::table('actividades')
                ->selectRaw("*,SUM(horas) as horas_voluntariado,Count(*) as total_actividades")
                ->join('actividades_facilitadores', function ($join) use($id,$anho)
        {
            $join->on('actividades_facilitadores.actividad_id', '=','actividades.id')
                ->where('actividades_facilitadores.becario_id', '=', $id)
                ->whereYear('actividades_facilitadores.created_at', '=', $anho);

        })->get();
        //return $actividades_facilitadas;

	   		$a_t_p = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','taller')->where('tipo','presencial')->join('actividades_becarios', function ($join) use($id,$anho)
        {
           $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                ->where('actividades_becarios.becario_id', '=', $id)
                ->whereYear('actividades_becarios.created_at', '=', $anho)
                ->where('actividades_becarios.estatus','=','asistio');

        })->get();

        $a_t_v = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','taller')->where('tipo','virtual')->join('actividades_becarios', function ($join) use($id,$anho)
        {
           $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                ->where('actividades_becarios.becario_id', '=', $id)
                ->whereYear('actividades_becarios.created_at', '=', $anho)
                ->where('actividades_becarios.estatus','=','asistio');

        })->get();

        $a_c_p = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','chat club')->where('tipo','presencial')->join('actividades_becarios', function ($join) use($id,$anho)
        {
           $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                ->where('actividades_becarios.becario_id', '=', $id)
                ->whereYear('actividades_becarios.created_at', '=', $anho)
                ->where('actividades_becarios.estatus','=','asistio');

        })->get();

        $a_c_v = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->where('tipo','chat club')->where('tipo','virtual')->join('actividades_becarios', function ($join) use($id,$anho)
        {
           $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                ->where('actividades_becarios.becario_id', '=', $id)
                ->whereYear('actividades_becarios.created_at', '=', $anho)
                ->where('actividades_becarios.estatus','=','asistio');

        })->get();

        $actividades_noasistio = DB::table('actividades')
                ->selectRaw('*,Count(*) as total_actividades')
                ->groupby('tipo','modalidad')->join('actividades_becarios', function ($join) use($id,$anho)
        {
           $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                ->where('actividades_becarios.becario_id', '=', $id)
                ->whereYear('actividades_becarios.created_at', '=', $anho)
                ->where('actividades_becarios.estatus','=','no asistio');

        })->get();

	   		return view('sisbeca.becarios.resumen')->with(compact('becario','anho','periodos','voluntariados','cursos','actividades_facilitadas'));
   		}
   		else
   		{
   			return view('sisbeca.error.404');
   		}
   	}
}
