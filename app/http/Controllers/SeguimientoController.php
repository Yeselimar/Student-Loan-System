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
   		$becarios = Becario::activos()->terminosaceptados()->probatorio1()->get();
   	}

   	public function resumen($id)
   	{
   		$anho = date('Y');
   		if(Auth::user()->id==$id or Auth::user()->esCoordinador() or Auth::user()->esDirectivo())
   		{
   			$becario = Becario::find($id);
	   		$periodos = Periodo::paraBecario($id)->porAnho($anho)->get();
	   		$voluntariados = Voluntariado::paraBecario($id)->porAnho($anho)->sumaHoras('horas_voluntariado')->contarVoluntariado('total_voluntariado')->agrupadoPorTipo()->get();
	   		$cursos = Curso::paraBecario($id)->porAnho($anho)->agrupadoPorNivel()->promedioPorNivel('promedio_nivel')->contarNivel('total_nivel')->get();

            //Estas consultas join no se como introducir scope

	   		$a_t_p = DB::table('actividades')
            ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','taller')->where('tipo','presencial')->join('actividades_becarios', function ($join) use($id,$anho)
            {
               $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                    ->where('actividades_becarios.becario_id', '=', $id)
                    ->whereYear('actividades_becarios.created_at', '=', $anho)
                    ->where('actividades_becarios.estatus','=','asistio');

            })
            ->get();
            $a_t_v = DB::table('actividades')
            ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','taller')->where('tipo','virtual')->join('actividades_becarios', function ($join) use($id,$anho)
            {
               $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                    ->where('actividades_becarios.becario_id', '=', $id)
                    ->whereYear('actividades_becarios.created_at', '=', $anho)
                    ->where('actividades_becarios.estatus','=','asistio');

            })
            ->get();

            $a_c_p = DB::table('actividades')
            ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','chat club')->where('tipo','presencial')->join('actividades_becarios', function ($join) use($id,$anho)
            {
               $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                    ->where('actividades_becarios.becario_id', '=', $id)
                    ->whereYear('actividades_becarios.created_at', '=', $anho)
                    ->where('actividades_becarios.estatus','=','asistio');

            })
            ->get();

            $a_c_v = DB::table('actividades')
            ->selectRaw('*,Count(*) as total_actividades')
                    ->where('tipo','chat club')->where('tipo','virtual')->join('actividades_becarios', function ($join) use($id,$anho)
            {
               $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                    ->where('actividades_becarios.becario_id', '=', $id)
                    ->whereYear('actividades_becarios.created_at', '=', $anho)
                    ->where('actividades_becarios.estatus','=','asistio');

            })
            ->get();

            $actividades_noasistio = DB::table('actividades')
            ->selectRaw('*,Count(*) as total_actividades')
                    ->groupby('tipo','modalidad')->join('actividades_becarios', function ($join) use($id,$anho)
            {
               $join->on('actividades.id', '=', 'actividades_becarios.actividad_id')
                    ->where('actividades_becarios.becario_id', '=', $id)
                    ->whereYear('actividades_becarios.created_at', '=', $anho)
                    ->where('actividades_becarios.estatus','=','no asistio');

            })
            ->get();

	   		return view('sisbeca.becarios.resumen')->with(compact('becario','anho','periodos','voluntariados','cursos','actividades_noasistio'));
   		}
   		else
   		{
   			return view('sisbeca.error.404');
   		}
   	}
}
