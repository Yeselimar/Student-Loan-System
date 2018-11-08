@extends('sisbeca.layouts.main')
@section('title','Postulantes')
@section('content')
<div class="col-lg-12" id="app">
	<div class="text-right">
		<a href="#" class="btn btn-sm sisbeca-btn-primary">Asignar Entrevistador</a>
	</div>
	<br>
	<div class="table-responsive">
		<table class="table table-bordered ">
			<thead>
				<tr>
					<th class="text-left">Postulante Becario</th>
					<th>Entrevistadores</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="postulante in postulantes">
					<td class="text-left">@{{ postulante.user.name}} @{{ postulante.user.last_name}}</td>
					<td>
						<template v-if="postulante.entrevistadores">
						  	<template v-for="entrevistador in postulante.entrevistadores">
						  			<span class="label label-default">@{{ entrevistador.nombre_apellido }}</span> 
							</template>
						</template>
						<template v-if="postulante.entrevistadores.length==0">
							<span class="label label-danger">sin entrevistadores</span>
						</template>
					</td>
					<td>
						<span data-toggle="tooltip" data-placement="bottom" title="Asignar Entrevistadores" >
							<button type="button" class="btn btn-xs sisbeca-btn-primary"  @click.prevent="mostrarModal(postulante,postulante.entrevistadores)"> 
								<i class="fa fa-pencil"></i>
							</button>
						</span>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<!-- Modal para añadir materia -->
	<form method="POST" @submit.prevent="asignarentrevistadores(id,seleccionados)" class="form-horizontal">
	{{ csrf_field() }}
		<div class="modal fade" id="asignarmodal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title pull-left"><strong>Asignar Entrevistadores</strong></h5>
						<button class="close" data-dimiss="modal" type="button" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
				    </div>
					<div class="modal-body">
						<label class="control-label " for="nombreyapellido">Postulante Becario</label>
						<input type="text" name="nombreyapellido" class="sisbeca-input input-sm sisbeca-disabled" :value="nombreyapellido" style="margin-bottom: 0px" disabled="disabled">
						<div class="row">
							<div class="col-lg-12">
								<label class="control-label" for="nota">Entrevistadores</label>
								<div class="row">
									<template v-if="entrevistadores.length!=0">
										<template v-for="entrevistador in todosentrevistadores">
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
													<div class="checkbox">
														<input type="checkbox" :id="entrevistador.id" :value="entrevistador.id" v-model="seleccionados" >
												  		<label :for="entrevistador.nombre_apellido" class="label label-default">@{{ entrevistador.nombre_apellido}}</label>
													</div>
											  	</div>
										</template>
									</template>
									<template v-else>
										<template v-for="entrevistador in todosentrevistadores">
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
													<div class="checkbox">
														<input type="checkbox" :id="entrevistador.id" :value="entrevistador.id" v-model="seleccionados" >
												  		<label :for="entrevistador.nombre_apellido" class="label label-default">@{{ entrevistador.nombre_apellido}}</label>
													</div>
											  	</div>
										</template>
									</template>
								  	<!--
								  	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
								  	<span>Entrevistadores Seleccionadoss:  @seleccionados</span>
								  	</div>-->
								</div>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm sisbeca-btn-default pull-right" data-dismiss="modal" >Cancelar</button>
						<button type="submit" class="btn btn-sm sisbeca-btn-primary pull-right">Guardar</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!-- Modal para añadir materia -->
</div>

@endsection

@section('personaljs')


<script>
const app = new Vue({

	el: '#app',
	created: function()
	{
		this.obtenerpostulantes();
		this.obtenerentrevistadores();
	},
	data:
	{
		postulantes:[],
		todosentrevistadores:[],
		entrevistadores:[],
		nombreyapellido:'',
		id:0,
		seleccionados:[],
	},
	methods:
	{
		mostrarModal: function(postulante,entrevistadores)
		{
			this.id = postulante.user_id;
			this.nombreyapellido = postulante.user.name+' '+postulante.user.last_name;
			this.entrevistadores = entrevistadores;
			this.seleccionados = [];
			for (var i = 0; i < this.entrevistadores.length; i++)
			{
				this.seleccionados[i] = entrevistadores[i].id;
			}
			$('#asignarmodal').modal('show');
		},
		
		obtenerpostulantes: function()
		{
			var url = '{{route('becario.obtenerpostulantes')}}';
			axios.get(url).then(response => 
			{
				this.postulantes = response.data.becarios;
			});
		},
		asignarentrevistadores: function(id,seleccionados)
		{
			this.seleccionados = seleccionados;
			var dataform = new FormData();
            dataform.append('seleccionados', this.seleccionados);
            var url = '{{route('entrevistador.asignar.guardar',':id')}}';
            url = url.replace(':id', id);
			axios.post(url,dataform).then(response => 
			{
				$('#asignarmodal').modal('hide');
				this.obtenerpostulantes();

				toastr.success(response.data.success);
			});
			
		},
		obtenerentrevistadores: function()
		{
			var url = '{{route('entrevistador.obtener')}}';
			axios.get(url).then(response => 
			{
				this.todosentrevistadores = response.data.entrevistadores;
			});
		},
		
	},
	
});
</script>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>

@endsection