@extends('sisbeca.layouts.main')
@section('title','Todos los Voluntariados')
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
					<th>Nombre Voluntariado</th>
					<th>Fecha</th>
					<th class="text-center">Horas</th>
					<th class="text-center">Estatus</th>
					<th>Actualizado el</th>
					<th class="text-right">Acciones</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="voluntariado in voluntariados">
					<td>
						<small>
							@{{ voluntariado.usuario.name }} @{{ voluntariado.usuario.last_name }}
						</small>
					</td>
					<td>
						<small>
							@{{ voluntariado.nombre }}
							(@{{ voluntariado.tipo}})
						</small>
					</td>
					<td>
						<small>@{{fechaformatear(voluntariado.fecha)}}</small>
					</td>
					<td class="text-center">
						<small>@{{ voluntariado.horas}}</small>
					</td>
					<td class="text-center">
						<small>
						<span v-if="voluntariado.aval.estatus=='pendiente'" class="label label-warning">pendiente</span>
						<span v-if="voluntariado.aval.estatus=='aceptada'" class="label label-success">aceptada</span>
						<span v-if="voluntariado.aval.estatus=='negada'" class="label label-danger">negada</span>
						<span v-if="voluntariado.aval.estatus=='devuelto'" class="label label-danger">devuelto</span>
						</small>
					</td>
					<td>
						<small>@{{ fechacompletaformatear(voluntariado.aval.updated_at) }}</small>
					</td>
					<td>
						<a :href="urlEditarVoluntariado(voluntariado.id)" class="btn btn-xs sisbeca-btn-primary" title="Editar Periodo">
							<i class="fa fa-pencil"></i>
						</a>
						<a :href="urlVerComprobante(voluntariado.aval.url)" class="btn btn-xs sisbeca-btn-primary" title="Ver Constancia" target="_blank">
							<template v-if="voluntariado.aval.extension=='imagen'">
								<i class="fa fa-photo"></i>
							</template>
							<template v-else>
								<i class="fa fa-file-pdf-o"></i>
							</template>
							
						</a>
						<template v-if="voluntariado.aval.estatus!='aceptada'">
							<button type="button" class="btn btn-xs sisbeca-btn-default" title="Eliminar CVA" @click="modalEliminar(voluntariado,voluntariado.usuario)">
								<i class="fa fa-trash"></i>
							</button>
						</template>
						<template v-else>
							<button type="button" class="btn btn-xs sisbeca-btn-default" disabled="disabled">
								<i class="fa fa-trash"></i>
							</button>
						</template>
						<select v-model="voluntariado.aval.estatus" @change="actualizarestatus(voluntariado.aval.estatus,voluntariado.aval.id)" class="sisbeca-input input-sm sisbeca-select">
							<option v-for="estatu in estatus" :value="estatu">@{{ estatu}}</option>
						</select>
					</td>
				</tr>
				<tr v-if="voluntariados.length==0">
					<td colspan="7" class="text-center">
						No hay <strong>voluntariados</strong> cargados.
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<hr>
	<p class="h6 text-right">@{{voluntariados.length}} voluntariado(s) </p>

	<!-- Modal para eliminar voluntariado -->
	<div class="modal fade" id="eliminarvoluntariado">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
			    	<h5 class="modal-title"><strong>Eliminar Voluntariado</strong></h5>
			    </div>
				<div class="modal-body">
					<div class="col-lg-12">
						<br>
						<p class="h6 text-center">
							¿Está seguro que desea eliminar permanentemente el voluntariado de <strong>@{{becario_voluntariado}}</strong> con nombre <strong>@{{nombre_voluntariado}}</strong>?
						</p>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm sisbeca-btn-default pull-right" data-dismiss="modal">No</button>
					<button type="button" class="btn btn-sm sisbeca-btn-primary pull-right" @click="eliminarVoluntariado(id)">Si</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal para eliminar voluntariado -->
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
		id: 0,
		nombre_voluntariado:'',
		becario_voluntariado:'',
		voluntariados:[],
		estatus:[],
		seleccionado:'',
		tmp:'',
	},
	methods:
	{
		modalEliminar(voluntariado,becario)
		{
			this.id=voluntariado.id;
			this.nombre_voluntariado=voluntariado.nombre;
			this.becario_voluntariado=becario.name+' '+becario.last_name;
			$('#eliminarvoluntariado').modal('show');
		},
		eliminarVoluntariado(id)
		{
			var url = '{{route('voluntariados.eliminarservicio',':id')}}';
			url = url.replace(':id', id);
			axios.get(url).then(response => 
			{
				$('#eliminarvoluntariado').modal('hide');
				toastr.success(response.data.success);
				this.obtenervoluntariados();			
			});
		},
		urlVerComprobante(slug)
		{
			var url = "{{url(':slug')}}";
    		url = url.replace(':slug', slug);
            return url;
		},
		urlEditarVoluntariado(id)
		{
			var url = '{{route('voluntariados.editar',':id')}}';
			url = url.replace(':id', id);
			return url;
		},
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
			var dataform = new FormData();
            dataform.append('estatus', estatu);
            var url = '{{route('aval.actualizarestatus',':id')}}';
            url = url.replace(':id', id);
			axios.post(url,dataform).then(response => 
			{
				this.obtenervoluntariados();
				toastr.success(response.data.success);
			});
		},
		fechaformatear(fecha)
		{
			return moment(new Date (fecha)).format('DD/MM/YYYY');
		},
		fechacompletaformatear(fecha)
		{
			return moment(new Date (fecha)).format('DD/MM/YYYY hh:mm A');
		}
	}
});
</script>

@endsection