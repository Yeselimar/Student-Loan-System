@extends('sisbeca.layouts.main')
@section('title','Todos los Periodos')
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
					<th>Periodo</th>
					<th>Materias</th>
					<th class="text-center">Promedio</th>
					<th class="text-center">Estatus</th>
					<th>Actualizado el</th>
					<th class="text-right">Acciones</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="periodo in periodos">
					<td>
						<small>@{{ periodo.usuario.name }} @{{ periodo.usuario.last_name }}</small>
						</td>
					<td>
						<small>
						@{{ periodo.anho_lectivo}} 
						- 
						<span v-if="periodo.becario.regimen=='anual'">@{{ periodo.numero_periodo }} año</span>
						<span v-if="periodo.becario.regimen=='semestral'">@{{ periodo.numero_periodo }} semestre</span>
						<span v-if="periodo.becario.regimen=='trimestral'">@{{ periodo.numero_periodo }} trimestral</span>
						</small>
					</td>
					<td class="text-center">
						<small>@{{ periodo.materias.length }} materias</small>
					</td>
					<td class="text-center">
						<small>@{{ materiaspromedio(periodo.materias) }}</small>
					</td>
					<td class="text-center">
						<small>
						<span v-if="periodo.aval.estatus=='pendiente'" class="label label-warning">pendiente</span>
						<span v-if="periodo.aval.estatus=='aceptada'" class="label label-success">aceptada</span>
						<span v-if="periodo.aval.estatus=='negada'" class="label label-danger">negada</span>
						<span v-if="periodo.aval.estatus=='devuelto'" class="label label-danger">devuelto</span>
						</small>
					</td>
					<td>
						<small>@{{ fechaformatear(periodo.aval.updated_at) }}</small>
						</td>
					<td>
						<a :href="urlEditarPeriodo(periodo.id)" class="btn btn-xs sisbeca-btn-primary" title="Editar Periodo">
							<i class="fa fa-pencil"></i>
						</a>
						<!--
						<a :href="urlMostrarMaterias(periodo.id)" class="btn btn-xs sisbeca-btn-primary" title="Mostrar Materias">
							<i class="fa fa-eye"></i>
						</a>-->
						<a :href="urlVerConstancia(periodo.aval.url)" class="btn btn-xs sisbeca-btn-primary" title="Ver Constancia" target="_blank">
							<i class="fa fa-file-pdf-o"></i>
						</a>
						<template v-if="periodo.aval.estatus!='aceptada'">
							<button type="button" class="btn btn-xs sisbeca-btn-default" title="Eliminar Periodo" @click="modalEliminar(periodo,periodo.usuario)">
								<i class="fa fa-trash"></i>
							</button>
						</template>
						<template v-else>
							<button type="button" class="btn btn-xs sisbeca-btn-default" disabled="disabled">
								<i class="fa fa-trash"></i>
							</button>
						</template>
						<select v-model="periodo.aval.estatus" @change="actualizarestatus(periodo.aval.estatus,periodo.aval.id)" class="sisbeca-input input-sm">
							<option v-for="estatu in estatus" v-bind:value="estatu" >@{{ estatu}}</option>
						</select>
					</td>
				</tr>
				<tr v-if="periodos.length==0">
					<td colspan="7" class="text-center">
						No hay <strong>periodos</strong> cargados.
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<hr>
	<p class="h6 text-right">@{{periodos.length}} periodo(s) </p>

	<!-- Modal para eliminar periodo -->
	<div class="modal fade" id="eliminarperiodo">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
			    	<h5 class="modal-title"><strong>Eliminar Periodo</strong></h5>
			    </div>
				<div class="modal-body">
					<div class="col-lg-12">
						<br>
						<p class="h6 text-center">
							¿Está seguro que desea eliminar permanentemente el periodo del año lectivo <strong>@{{anho_lectivo}}</strong> del becario <strong>@{{becario_periodo}}</strong>?
						</p>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm sisbeca-btn-default pull-right" data-dismiss="modal">No</button>
					<button type="button" class="btn btn-sm sisbeca-btn-primary pull-right" @click="eliminarPeriodo(id)">Si</button>
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
		this.obtenerperiodos();
		this.obtenerestatusaval();
	},
	data:
	{
		id:0,
		anho_lectivo:'',
		becario_periodo:'',
		periodos:[],
		estatus:[],
	},
	methods:
	{
		modalEliminar(periodo,becario)
		{
			this.id=periodo.id;
			this.anho_lectivo=periodo.anho_lectivo;
			this.becario_periodo=becario.name+' '+becario.last_name;
			$('#eliminarperiodo').modal('show');
		},
		eliminarPeriodo(id)
		{
			var url = '{{route('periodos.eliminarservicio',':id')}}';
			url = url.replace(':id', id);
			axios.get(url).then(response => 
			{
				$('#eliminarperiodo').modal('hide');
				toastr.success(response.data.success);
				this.obtenerperiodos();			
			});
		},
		materiaspromedio(materias)
		{
			var suma = 0;
			materias.forEach(function(materia)
			{
			  	suma = suma + materia.nota;
			});
			return (suma/materias.length).toFixed(2);
		},
		urlVerConstancia(slug)
		{
			var url = "{{url(':slug')}}";
    		url = url.replace(':slug', slug);
            return url;
		},
		urlMostrarMaterias(id)
		{
			var url = '{{route('materias.mostrar',':id')}}';
			url = url.replace(':id', id);
			return url;
		},
		urlEditarPeriodo(id)
		{
			var url = '{{route('periodos.editar',':id')}}';
			url = url.replace(':id', id);
			return url;
		},
		obtenerperiodos: function()
		{
			var url = '{{route('periodos.obtenertodos')}}';
			axios.get(url).then(response => 
			{
				this.periodos = response.data.periodos;
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
			console.log("Actualiza el "+id+" con "+estatu);
			var dataform = new FormData();
            dataform.append('estatus', estatu);
            var url = '{{route('aval.actualizarestatus',':id')}}';
            url = url.replace(':id', id);
			axios.post(url,dataform).then(response => 
			{
				this.obtenerperiodos();
				toastr.success(response.data.success);
			});
		},
		fechaformatear(fecha)
		{
			return moment(new Date (fecha)).format('DD/MM/YYYY hh:mm A');
		},
		zfill: function(number, width)
		{
			var numberOutput = Math.abs(number); /* Valor absoluto del número */
    		var length = number.toString().length; /* Largo del número */ 
		    var zero = "0"; /* String de cero */  
		    
		    if (width <= length) {
		        if (number < 0) {
		             return ("-" + numberOutput.toString()); 
		        } else {
		             return numberOutput.toString(); 
		        }
		    } else {
		        if (number < 0) {
		            return ("-" + (zero.repeat(width - length)) + numberOutput.toString()); 
		        } else {
		            return ((zero.repeat(width - length)) + numberOutput.toString()); 
		        }
		    }
		}
	}
});
</script>

@endsection
