@extends('sisbeca.layouts.main')
@section('title','Resumen Becario: '.$becario->user->nombreyapellido())
@section('personalcss')
<style>
	.ancho-sisbeca
	{
		width: 50px;
	}
	.cabecera-sisbeca
	{
		background-color: #eee;
	}
</style>
@endsection
@section('content')
<div class="col-lg-12">
    <div class="text-right">
        <a href="{{route('seguimiento.resumen.pdf',$becario->user->id)}}" class="btn btn-sm sisbeca-btn-primary">
        	<i class="fa fa-file-pdf-o"></i> PDF
    	</a>
    </div>
	<br>
	<div class="table-responsive">
		<table class="table table-bordered table-hover">
			<thead>
				<tr>
					<th colspan="4" class="cabecera-sisbeca">VOLUNTARIADO</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-left"><strong>Año</strong></td>
					<td class="text-left"><strong>Tipo Voluntariado</strong></td>
					<td class="text-left"><strong>Total</strong></td>
					<td class="text-right"><strong>Horas Voluntariado</strong></td>
				</tr>
				@php ($horas = 0)
				@if($cursos->count()!=0)
					@foreach($voluntariados as $voluntariado)
					@php ($horas = $horas + $voluntariado->horas_voluntariado)
					<tr>
						<td class="text-left">{{$anho}}</td>
						<td class="text-left">{{ucwords($voluntariado->tipo_voluntariado)}}</td>
						<td class="text-left">{{$voluntariado->total_voluntariado}}</td>
						<td class="text-right">{{$voluntariado->horas_voluntariado}}</td>
					</tr>
					@endforeach
				@else
				<tr>
					<td colspan="4" class="text-center">No hay <strong>voluntariado</strong></td>
				</tr>
				@endif

				@if($actividades_facilitadas[0]->total_actividades!=0)
				<tr>
					@foreach($actividades_facilitadas as $af)
					@php ($horas = $horas + $af->horas_voluntariado)
						<td class="text-left">{{$anho}}</td>
						<td class="text-left">Facilitador en {{ucwords($af->tipo)}}</td>
						<td class="text-left">{{$af->total_actividades }}</td>
						<td class="text-right">{{$af->horas_voluntariado}}</td>
					@endforeach
				</tr>
				@else
				<tr>
					<td colspan="4" class="text-center">No ha sido facilitador de <strong>ningún chat club</strong></td>
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
					<th colspan="4" class="cabecera-sisbeca">CVA</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-left"><strong>Año</strong></td>
					<td class="text-left"><strong>Módulo</strong></td>
					<td class="text-left"><strong>Total por Nivel</strong></td>
					<td class="text-right"><strong>Promedio</strong></td>
				</tr>
				@if($cursos->count()!=0)
					@php ($promedio = 0)
					@php ($total_curso = 0)
					@foreach($cursos as $index=>$curso)
					@php ($promedio = $promedio + $curso->promedio_modulo)
					@php ($total_curso = $total_curso + $curso->total_modulo)
					<tr>
						<td class="text-left">{{$anho}}</td>
						<td class="text-left">{{$curso->modulo}} nivel</td>
						<td class="text-left">{{$curso->total_modulo}}</td>
						<td class="text-right">{{number_format($curso->promedio_modulo, 2, '.', ',')}}</td>
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
					<th colspan="5" class="cabecera-sisbeca">NOTAS ACADÉMICAS</th>
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
				@php ($promedio_periodo = 0)
				@php ($j = 0)
				@if($periodos->count()!=0)

					@foreach($periodos as $periodo)
					@if($periodo->aval->estatus=='aceptada')
					@php ($j++)
					@php ($promedio_periodo = $promedio_periodo + $periodo->getPromedio())
					<tr>
						<td class="text-left">{{$anho}}</td>
						<td class="text-left">
							{{$periodo->getNumeroPeriodo()}} 
						</td>
						<td class="text-left">{{$periodo->anho_lectivo}}</td>
						<td class="text-left">{{$periodo->getTotalMaterias()}}</td>
						<td class="text-right">{{$periodo->getPromedio()}}</td>
					</tr>
					@endif
					@endforeach
				@else
				<tr>
					<td colspan="5" class="text-center">No hay <strong>periodos</strong></td>
				</tr>
				@endif
				<tr>	
					<td colspan="3"></td>
					<td class="text-right"><strong>Promedio General</strong></td>
					<td class="text-right">
						<strong>
						@if($promedio_periodo!=0)
						{{ number_format($promedio_periodo/($j), 2, '.', ',')}}
						@else
						{{ number_format(0, 2, '.', ',')}}
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
					<th colspan="4" class="cabecera-sisbeca">TALLER Y CHAT CLUB</th>
				</tr>
			</thead>
			<tbody>
				<!-- ASISTIO -->
				@php ($total_taller=$a_t_p->total_actividades+$a_t_v->total_actividades)
				@php ($total_chat=$a_c_p->total_actividades+$a_c_v->total_actividades)
				@php ($total_presencial=$a_t_p->total_actividades+$a_c_p->total_actividades)
				@php ($total_virtual=$a_t_v->total_actividades+$a_c_v->total_actividades)
				<tr>
					<td><strong>ASISTIO</strong></td>
					<td><strong>Presencial</strong></td>
					<td><strong>Virtual</strong></td>
					<td><strong>Total</strong></td>
				</tr>
				<tr>
					<td><strong>Taller</strong></td>
					<td>{{$a_t_p->total_actividades}}</td>
					<td>{{$a_t_v->total_actividades}}</td>
					<td>{{$total_taller}}</td>
				</tr>
				<tr>
					<td><strong>Chat Club</strong></td>
					<td>{{$a_c_p->total_actividades}} </td>
					<td>{{$a_c_v->total_actividades}} </td>
					<td>{{$total_chat}}</td>
				</tr>
				<tr>
					<td><strong>Total</strong></td>
					<td>{{$total_presencial}}</td>
					<td>{{$total_virtual}}</td>
					<td>
						<strong>
						{{$a_t_p->total_actividades+$a_t_v->total_actividades
						+$a_c_p->total_actividades+$a_c_v->total_actividades}}
						</strong>
					</td>
				</tr>
				<!-- ASISTIO -->

				<!-- NO ASISTIO -->
				@php ($total_n_taller=$na_t_p->total_actividades+$na_t_v->total_actividades)
				@php ($total_n_chat=$na_c_p->total_actividades+$na_c_v->total_actividades)
				@php ($total_n_presencial=$na_t_p->total_actividades+$na_c_p->total_actividades)
				@php ($total_n_virtual=$na_t_v->total_actividades+$na_c_v->total_actividades)
				<tr>
					<td><strong>NO ASISTIO</strong></td>
					<td><strong>Presencial</strong></td>
					<td><strong>Virtual</strong></td>
					<td><strong>Total</strong></td>
				</tr>
				<tr>
					<td><strong>Taller</strong></td>
					<td>{{$na_t_p->total_actividades}}</td>
					<td>{{$na_t_v->total_actividades}}</td>
					<td>{{$total_n_taller}}</td>
				</tr>
				<tr>
					<td><strong>Chat Club</strong></td>
					<td>{{$na_c_p->total_actividades}} </td>
					<td>{{$na_c_v->total_actividades}} </td>
					<td>{{$total_n_chat}}</td>
				</tr>
				<tr>
					<td><strong>Total</strong></td>
					<td>{{$total_n_presencial}}</td>
					<td>{{$total_n_virtual}}</td>
					<td>
						<strong>
						{{$na_t_p->total_actividades+$na_t_v->total_actividades
						+$na_c_p->total_actividades+$na_c_v->total_actividades}}
						</strong>
					</td>
				</tr>
				<!-- NO ASISTIO -->
			</tbody>
		</table>
	</div>
</div>
@endsection