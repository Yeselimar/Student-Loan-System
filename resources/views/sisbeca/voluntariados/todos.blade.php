@extends('sisbeca.layouts.main')
@section('title','Todos los Voluntariados')
@section('content')
<div class="col-lg-12" id="app">
	<div class="text-right">
		<a href="#" class="btn btn-sm sisbeca-btn-primary">Cargar Voluntariado</a>
	</div>
	<br>
	<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th>Becario</th>
					<th>Fecha</th>
					<th>Horas</th>
					<th class="text-center">Estatus</th>
					<th>Creado el</th>
					<th>Actualizado el</th>
					<th class="text-right">Acciones</th>
				</tr>
			</thead>
			<tbody>
				
				<tr v-for="voluntariado in voluntariados">
					<td>@{{ voluntariado.usuario.name }} @{{ voluntariado.usuario.last_name }} @{{ voluntariado.aval.id}}</td>
					<td>@{{ voluntariado.fecha}}</td>
					<td>@{{ voluntariado.horas}}</td>
					<td class="text-center">
						<span v-if="voluntariado.aval.estatus=='pendiente'" class="label label-warning">pendiente</span>
						<span v-if="voluntariado.aval.estatus=='aceptada'" class="label label-success">aceptada</span>
						<span v-if="voluntariado.aval.estatus=='negada'" class="label label-danger">negada</span>
					</td>
					<td>@{{ voluntariado.created_at }}</td>
					<td>@{{ voluntariado.updated_at }}</td>
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
				<tr v-if="voluntariados.length==0">
					<td colspan="7" class="text-center">
						No hay <strong>voluntariados</strong>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<hr>
	<p class="h6 text-right"> @{{voluntariados.lenght}}voluntariado(s) </p>
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
		this.obtenervoluntariados();
		this.obtenerestatusaval();
	},
	data:
	{
		voluntariados:[],
		estatus:[],
		seleccionado:'',
		tmp:'',
	},
	methods:
	{
		obtenervoluntariados: function()
		{
			var url = '{{route('voluntariados.obtenertodos')}}';
			axios.get(url).then(response => 
			{
				this.voluntariados = response.data.voluntariados;
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