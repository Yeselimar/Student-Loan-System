@extends('sisbeca.layouts.main')
@section('title','Todos los Periodos')
@section('subtitle','Periodos')
@section('content')
<div class="col-lg-12" id="app">
	<div class="text-right">
		<a href="{{route('periodos.crear',Auth::user()->id)}}" class="btn btn-sm sisbeca-btn-primary">Crear Periodo</a>
	</div>
	<br>
	<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th>Becario</th>
					<th>Año Lectivo</th>
					<th class="text-center">Nro Materias</th>
					<th class="text-center">Estatus</th>
					<th class="text-right">Acciones</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="periodo in periodos">
					<td>@{{ periodo.usuario.name }} @{{ periodo.usuario.last_name }}</td>
					<td>@{{ periodo.anho_lectivo}} 
						<span v-if="periodo.becario.regimen=='anual'">(@{{ periodo.numero_periodo }} año)</span>
						<span v-if="periodo.becario.regimen=='semestral'">(@{{ periodo.numero_periodo }} semestre)</span>
						<span v-if="periodo.becario.regimen=='trimestral'">(@{{ periodo.numero_periodo }} trimestral)</span>
					</td>
					<td class="text-center">@{{ periodo.materias.length }}</td>
					<td class="text-center">
						<span v-if="periodo.aval.estatus=='pendiente'" class="label label-warning">pendiente</span>
						<span v-if="periodo.aval.estatus=='aceptada'" class="label label-success">aceptada</span>
						<span v-if="periodo.aval.estatus=='negada'" class="label label-danger">negada</span>
					</td>
					<td>
						<button type="button" class="btn btn-xs sisbeca-btn-primary">
							
						</button>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<hr>
	<p class="h6 text-right"> periodo(s) </p>
</div>
@endsection

@section('personaljs')
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>

<script>
	const app = new Vue({

	el: '#app',
	created: function()
	{
		this.obtenerperiodos();

	},
	data:
	{
		periodos:[],
	},
	methods:
	{
		obtenerperiodos: function()
		{
			var url = '{{route('periodos.obtenertodos')}}';
			axios.get(url).then(response => 
			{
				this.periodos = response.data.periodos;
			});
			
		},
	}
});
</script>

@endsection
