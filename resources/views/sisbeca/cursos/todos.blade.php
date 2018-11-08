@extends('sisbeca.layouts.main')
@section('title','Todos los CVA')
@section('content')
<div class="col-lg-12" id="app">
	<div class="text-right">
		<a href="{{route('cursos.crear',Auth::user()->id)}}" class="btn btn-sm sisbeca-btn-primary">Crear CVA</a>
	</div>
	<br>
	<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th>Becario</th>
					<th>Nivel-Módulo (Modalidad)</th>
					<th>Nota</th>
					<th>Desde hasta</th>
					<th class="text-center">Estatus</th>
					<th>Creado el</th>
					<th>Actualizado el</th>
					<th class="text-right">Acciones</th>
				</tr>
			</thead>
			<tbody>
				
				<tr v-for="curso in cursos">
					<td>@{{ curso.usuario.name }} @{{ curso.usuario.last_name }} @{{ curso.aval.id}}</td>
					<td>@{{ curso.nivel}}-@{{ curso.modulo}} (@{{ curso.modo}})</td>
					<td>@{{ curso.nota}}</td>
					<td>@{{ curso.fecha_inicio}} a @{{ curso.fecha_fin}}</td>
					<td class="text-center">
						<span v-if="curso.aval.estatus=='pendiente'" class="label label-warning">pendiente</span>
						<span v-if="curso.aval.estatus=='aceptada'" class="label label-success">aceptada</span>
						<span v-if="curso.aval.estatus=='negada'" class="label label-danger">negada</span>
					</td>
					<td>@{{ curso.created_at }}</td>
					<td>@{{ curso.updated_at }}</td>
					<td>
						<!-- v-model en el select para que enlace lo que tiene  actualmente el estatus-->
						<!-- el v-model selecciona el estatus actual-->
						<!-- Este v-bind me rellena el atributo de value del option-->
						<!-- Si le quito v-bind no rellena el atributo value del option y cuando actualizo, actualizo a vació "" porque no hay nada en el value-->
						<!-- Cuando cambia lo seleccionado llamo al método con curso.aval.estatus porque tiene lo seleccionado y id para el identificar a cual aval voy actualizar-->
						<!-- v-bind:value="estatu"> o :bind 
							v-on:change o @change v-on escucha un evento-->
						<select v-model="curso.aval.estatus" @change="actualizarestatus(curso.aval.estatus,curso.aval.id)" class="sisbeca-input input-sm sisbeca-select">
							<option v-for="estatu in estatus" :value="estatu">@{{ estatu}}</option>
						</select>
					</td>
				</tr>
	
			</tbody>
		</table>
	</div>
	<hr>
	<p class="h6 text-right"> CVA </p>
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
		this.obtenercursos();
		this.obtenerestatusaval();
	},
	data:
	{
		cursos:[],
		estatus:[],
		seleccionado:'',
		tmp:'',
	},
	methods:
	{
		obtenercursos: function()
		{
			var url = '{{route('cursos.obtenertodos')}}';
			axios.get(url).then(response => 
			{
				this.cursos = response.data.cursos;
			});
		},
		obtenerestatusaval: function()
		{
			var url = '{{route('aval.getEstatus')}}';
			axios.get(url).then(response => 
			{
				this.estatus = response.data.estatus;
			});	
		},
		actualizarestatus(estatu,id)
		{	
			//console.log("Actualiza el "+id+" con "+estatu);
			var dataform = new FormData();
            dataform.append('estatus', estatu);
            var url = '{{route('aval.actualizarestatus',':id')}}';
            url = url.replace(':id', id);
			axios.post(url,dataform).then(response => 
			{
				this.obtenercursos();
				toastr.success(response.data.success);
			});
		}
	}
});
</script>

@endsection
