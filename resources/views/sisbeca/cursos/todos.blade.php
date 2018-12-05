@extends('sisbeca.layouts.main')
@section('title','Todos los CVA')
@section('content')
<div class="col-lg-12" id="app">
	<div class="text-right">
		<a href="{{route('becarios.todos')}}" class="btn btn-sm sisbeca-btn-primary">Listar Becarios</a>
	</div>
	<br>
	<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th>Becario</th>
					<th>Nivel-Modalidad-Módulo</th>
					<th class="text-center">Nota</th>
					<th class="text-center">Estatus</th>
					<th>Actualizado el</th>
					<th class="text-right">Acciones</th>
				</tr>
			</thead>
			<tbody>
				
				<tr v-for="curso in cursos">
					<td>
						<small>@{{ curso.usuario.name }} @{{ curso.usuario.last_name }}</small>
					</td>
					<td>
						<small>@{{ curso.nivel}}-@{{ curso.modo}}-@{{ curso.modulo}}</small>
					</td>
					<td class="text-center">
						<small>@{{ curso.nota.toFixed(2) }}</small>
					</td>
					<td class="text-center">
						<small>
						<span v-if="curso.aval.estatus=='pendiente'" class="label label-warning">pendiente</span>
						<span v-if="curso.aval.estatus=='aceptada'" class="label label-success">aceptada</span>
						<span v-if="curso.aval.estatus=='negada'" class="label label-danger">negada</span>
						</small>
						<span v-if="curso.aval.estatus=='devuelto'" class="label label-danger">devuelto</span>
						</small>
					</td>
					<td>
						<small>@{{ fechaformatear(curso.aval.updated_at) }}</small>
					</td>
					<td>
						<a :href="urlEditarCurso(curso.id)" class="btn btn-xs sisbeca-btn-primary" title="Editar Periodo">
							<i class="fa fa-pencil"></i>
						</a>
						<a :href="urlVerNota(curso.aval.url)" class="btn btn-xs sisbeca-btn-primary" title="Ver Constancia" target="_blank">
							<template v-if="curso.aval.extension=='imagen'">
								<i class="fa fa-photo"></i>
							</template>
							<template v-else>
								<i class="fa fa-file-pdf-o"></i>
							</template>
							
						</a>
						<template v-if="curso.aval.estatus!='aceptada'">
							<button type="button" class="btn btn-xs sisbeca-btn-default" title="Eliminar CVA" @click="modalEliminar(curso,curso.usuario)">
								<i class="fa fa-trash"></i>
							</button>
						</template>
						<template v-else>
							<button type="button" class="btn btn-xs sisbeca-btn-default" disabled="disabled">
								<i class="fa fa-trash"></i>
							</button>
						</template>
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
				<tr v-if="cursos.length==0">
					<td colspan="8" class="text-center">
						No hay <strong>CVA</strong> cargados.
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<hr>
	<p class="h6 text-right">@{{cursos.length}} CVA cargados </p>

	<!-- Modal para eliminar periodo -->
	<div class="modal fade" id="eliminarcurso">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
			    	<h5 class="modal-title"><strong>Eliminar CVA</strong></h5>
			    </div>
				<div class="modal-body">
					<div class="col-lg-12">
						<br>
						<p class="h6 text-center">
							¿Está seguro que desea eliminar permanentemente el CVA <strong>@{{id_curso}}</strong> del becario <strong>@{{becario_curso}}</strong>?
						</p>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm sisbeca-btn-default pull-right" data-dismiss="modal">No</button>
					<button type="button" class="btn btn-sm sisbeca-btn-primary pull-right" @click="eliminarCurso(id)">Si</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal para eliminar periodo -->
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
		id:0,
		id_curso:'',
		becario_curso:'',
		cursos:[],
		estatus:[],
		seleccionado:'',
		tmp:'',
	},
	methods:
	{
		modalEliminar(curso,becario)
		{
			this.id=curso.id;
			this.id_curso=curso.nivel+'-'+curso.modo+'-'+curso.modulo;
			this.becario_curso=becario.name+' '+becario.last_name;
			$('#eliminarcurso').modal('show');
		},
		eliminarCurso(id)
		{
			var url = '{{route('cursos.eliminarservicio',':id')}}';
			url = url.replace(':id', id);
			axios.get(url).then(response => 
			{
				$('#eliminarcurso').modal('hide');
				toastr.success(response.data.success);
				this.obtenercursos();			
			});
		},
		urlVerNota(slug)
		{
			var url = "{{url(':slug')}}";
    		url = url.replace(':slug', slug);
            return url;
		},
		urlEditarCurso(id)
		{
			var url = '{{route('cursos.editar',':id')}}';
			url = url.replace(':id', id);
			return url;
		},
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
			var dataform = new FormData();
            dataform.append('estatus', estatu);
            var url = '{{route('aval.actualizarestatus',':id')}}';
            url = url.replace(':id', id);
			axios.post(url,dataform).then(response => 
			{
				this.obtenercursos();
				toastr.success(response.data.success);
			});
		},
		fechaformatear(fecha)
		{
			return moment(new Date (fecha)).format('DD/MM/YYYY hh:mm A');
		}
	}
});
</script>

@endsection
