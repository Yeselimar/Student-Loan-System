@extends('sisbeca.layouts.main')
@section('title','Resumen Becario: '.$becario->user->nombreyapellido())
@section('content')
<div class="col-lg-12">
    <div class="text-right">
        <a href="#" class="btn btn-sm sisbeca-btn-primary">
        	<i class="fa fa-file-pdf-o"></i> PDF
    	</a>
    </div>
	<br>
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th colspan="4" style="background-color: #eee">VOLUNTARIADO</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-left"><strong>Año</strong></td>
					<td class="text-left"><strong>Tipo Voluntariado</strong></td>
					<td class="text-left"><strong>Total Voluntariado</strong></td>
					<td class="text-right"><strong>Horas Voluntariado</strong></td>
				</tr>
				@php ($horas = 0)
				@if($cursos->count()!=0)
					@foreach($voluntariados as $voluntariado)
					@php ($horas = $horas + $voluntariado->horas_voluntariado)
					<tr>
						<td class="text-left">{{$anho}}</td>
						<td class="text-left">{{$voluntariado->tipo}}</td>
						<td class="text-left">{{$voluntariado->total_voluntariado}}</td>
						<td class="text-right">{{$voluntariado->horas_voluntariado}}</td>
					</tr>
					@endforeach
				@else
				<tr>
					<td colspan="4" class="text-center">No hay <strong>voluntariado</strong></td>
				</tr>
				@endif
				<tr>
					<td colspan="2"></td>
					<td class="text-right"><strong>Total Horas</strong></td>
					<td class="text-right"><strong>{{ $horas }}</strong></td>
				</tr>
			</tbody>
		</table>
	</div>
	<br>
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th colspan="4" style="background-color: #eee">CVA</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-left"><strong>Año</strong></td>
					<td class="text-left"><strong>Nivel</strong></td>
					<td class="text-left"><strong>Total por Nivel</strong></td>
					<td class="text-right"><strong>Promedio</strong></td>
				</tr>
				@if($cursos->count()!=0)
					@php ($promedio = 0)
					@php ($total_curso = 0)
					@foreach($cursos as $index=>$curso)
					@php ($promedio = $promedio + $curso->promedio_nivel)
					@php ($total_curso = $total_curso + $curso->total_nivel)
					<tr>
						<td class="text-left">{{$anho}}</td>
						<td class="text-left">{{$curso->nivel}}</td>
						<td class="text-left">{{$curso->total_nivel}}</td>
						<td class="text-right">{{number_format($curso->promedio_nivel, 2, '.', ',')}}</td>
					</tr>
					@endforeach
				@else
				<tr>
					<td colspan="4" class="text-center">No hay <strong>CVA</strong></td>
				</tr>
				@endif
				<tr>	
					<td colspan="2"></td>
					<td class="text-right"><strong>Promedio General</strong></td>
					<td class="text-right">
						<strong>
						@if($cursos->count()==0)
							{{number_format(0, 2, '.', ',')}}
						@else
							{{number_format($promedio/($index+1), 2, '.', ',')}}
						@endif
						</strong>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<br>
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th colspan="5" style="background-color: #eee">Notas Acádemicas</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-left"><strong>Año</strong></td>
					<td class="text-left"><strong>Número Periodo</strong></td>
					<td class="text-left"><strong>Año Lectivo</strong></td>
					<td class="text-left"><strong>Total Materias</strong></td>
					<td class="text-right"><strong>Promedio</strong></td>
				</tr>
				@if($periodos->count()!=0)
					@foreach($periodos as $periodo)
					<tr>
						<td class="text-left">{{$anho}}</td>
						<td class="text-left">{{$periodo->getNumeroPeriodo()}}</td>
						<td class="text-left">{{$periodo->anho_lectivo}}</td>
						<td class="text-left">{{$periodo->getTotalMaterias()}}</td>
						<td class="text-right">{{$periodo->getPromedio()}}</td>
					</tr>
					@endforeach
				@else
				<tr>
					<td colspan="5" class="text-center">No hay <strong>periodos</strong></td>
				</tr>
				@endif
				<tr>	
					<td colspan="3"></td>
					<td class="text-right"><strong>Promedio General</strong></td>
					<td class="text-right"><strong>{{$becario->promediotodosperiodos()}}</strong></td>
				</tr>
			</tbody>
		</table>
	</div>
	<br>
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th colspan="3" style="background-color: #eee">Talleres y Chat Club</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td colspan="3" class="text-left">Asistio</td>
				</tr>
				@php ($ta = 0)
				@foreach($actividades_asistio as $actividad)
				@php ($ta = $ta + $actividad->total_actividades)
				<tr>
					<td>{{$actividad->tipo}}</td>
					<td>{{$actividad->modalidad}}</td>
					<td>{{$actividad->total_actividades}}</td>
				</tr>
				@endforeach
				<tr>
					<td colspan="2"></td>
					<td>{{$ta}}</td>
				</tr>
				<tr>
					<td colspan="3" class="text-left">No Asistio</td>
				</tr>
				@php ($tna = 0)
				@foreach($actividades_noasistio as $actividad)
				@php ($tna = $tna + $actividad->total_actividades)
				<tr>
					<td>{{$actividad->tipo}}</td>
					<td>{{$actividad->modalidad}}</td>
					<td>{{$actividad->total_actividades}}</td>
				</tr>
				@endforeach
				<tr>
					<td colspan="2"></td>
					<td>{{$tna}}</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
@endsection