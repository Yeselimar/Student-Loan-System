@extends('sisbeca.layouts.main')
@section('title','Gestión de Entrevista')
@section('content')

<div class="col-lg-12" id="app">
	<br>
	<div class="table-responsive">
		<table class="table table-bordered ">
			<thead>
				<tr>
					<th class="text-left">Postulante Becario</th>
					<th>Entrevistadores</th>
					<th>Fecha Hora Lugar</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="postulante in postulantes">
					<td class="text-left">@{{ postulante.user.name}} @{{ postulante.user.last_name}}</td>
					<td>
						<template v-if="postulante.entrevistadores">
							<template v-for="entrevistador in postulante.entrevistadores">
									<span class="label label-default">@{{ entrevistador.name}} @{{ entrevistador.last_name}}</span>&nbsp;
							</template>
						</template>
						<template v-if="postulante.entrevistadores.length==0">
							<span class="label label-default">sin entrevistadores</span>
						</template>
					</td>
					<td>
						<div class="col-lg-12 row">
							<div v-if="postulante.fecha_entrevista!=null">
								<span class="label label-inverse">@{{ fechaformartear(postulante.fecha_entrevista) }}</span>
							</div>
							<div v-else>
								<span class="label label-default">Sin Fecha</span>
							</div>
							&nbsp;
							<div v-if="postulante.hora_entrevista!=null">
								<span class="label label-inverse">@{{ horaformatear(postulante.hora_entrevista) }}</span>
							</div>
							<div v-else>
								<span class="label label-default">Sin Hora</span>
							</div>
							&nbsp;
							<div v-if="postulante.lugar_entrevista!=null">
								<span class="label label-inverse">@{{ postulante.lugar_entrevista }}</span>
							</div>
							<div v-else>
								<span class="label label-default">Sin Lugar</span>
							</div>
						</div>
					</td>
					<td>
						<span data-toggle="tooltip" data-placement="bottom" title="Asignar Entrevistadores" >
							<button type="button" class="btn btn-xs sisbeca-btn-primary"  @click.prevent="mostrarModal(postulante,postulante.entrevistadores)">
								<i class="fa fa-pencil"></i>
							</button>
						</span>
					</td>
				</tr>
				<tr v-if="postulantes.length==0">
					<td colspan="4" class="text-center">No hay <strong>postulantes a entrevistas</strong></td>
				</tr>
			</tbody>
		</table>
	</div>

	<!-- Modal para añadir entrevistadores -->
	<form method="POST" @submit.prevent="asignarentrevistadores(id,seleccionados)">
	{{ csrf_field() }}
		<div class="modal fade" id="asignarmodal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title pull-left"><strong>Asignar Entrevistadores @{{id}}</strong></h5>
						<a class="pull-right mr-1" href="javascript(0)" data-dismiss="modal" ><i class="fa fa-remove"></i></a>
				    </div>
					<div class="modal-body">
						<div class="row">
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 0px !important">
								<label class="control-label " for="nombreyapellido" style="margin-bottom: 0px !important">Postulante Becario</label>
								<input type="text" name="nombreyapellido" class="sisbeca-input input-sm sisbeca-disabled" :value="nombreyapellido" style="margin-bottom: 0px" disabled="disabled">
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 0px !important">
								<label class="control-label " style="margin-bottom: 0px !important">Fecha</label>
									<date-picker class="sisbeca-input input-sm" name="fecha" v-model="fecha" placeholder="DD/MM/AAAA" :config="{ enableTime: false , dateFormat: 'd/m/Y'}"></date-picker>
							</div>
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 0px !important">
								<label class="control-label " for="lugar" style="margin-bottom: 0px !important">Lugar</label>
							<input type="text" name="lugar" v-model="lugar" class="sisbeca-input input-sm" placeholder="Los Ruices">
						  	</div>
						  	<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 0px !important">
							<label class="control-label " style="margin-bottom: 0px !important">Hora</label>
								<!--	<input type="text" autocomplete="off" class="sisbeca-input input-sm" > -->
								<date-picker class="sisbeca-input input-sm" v-model="hora" placeholder="HH:MM AA" placeholder="HH:MM AA" :config="{ enableTime: true, enableSeconds: false, noCalendar: true,  dateFormat: 'h:i K'}"></date-picker>
							</div>
						</div>


						<div class="row">
							<div class="col-lg-12">
								<label class="control-label" for="nota">Entrevistadores</label>
								<div class="row">
									<template v-if="entrevistadores.length!=0">
										<template v-for="entrevistador in todosentrevistadores">
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
													<div class="checkbox">
														<input type="checkbox" :id="entrevistador.id" :value="entrevistador.id" v-model="seleccionados" >
												  		<label :for="entrevistador.nombre_apellido" class="label label-default">@{{ entrevistador.name}} @{{ entrevistador.last_name}}</label>
													</div>
											  	</div>
										</template>
									</template>
									<template v-else>
										<template v-for="entrevistador in todosentrevistadores">
												<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
													<div class="checkbox">
														<input type="checkbox" :id="entrevistador.id" :value="entrevistador.id" v-model="seleccionados" >
												  		<label :for="entrevistador.nombre_apellido" class="label label-default">@{{ entrevistador.name}} @{{ entrevistador.last_name}}</label>
													</div>
											  	</div>
										</template>
									</template>

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

</div>

@endsection

@section('personaljs')
<script>
const app = new Vue({
	components:{DatePicker},
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
		fecha:'',
		hora:'',
		lugar:'',
		fechaseleccionada:'',
	},

	methods:
	{
		fechaformartear: function (fecha)
		{
			var d = new Date(fecha);
			var dia = d.getDate();
	        var mes = d.getMonth() + 1;
	        var anho = d.getFullYear();
	        var fecha = this.zfill(dia,2) + "/" + this.zfill(mes,2) + "/" + anho;
	        return fecha;
		},
		horaformatear: function (hora)
		{
			var cadena = "2018-11-11 "+hora;
			var dia = new Date (cadena);
			return moment(dia).format('hh:mm A');
		},
		mostrarModal: function(postulante,entrevistadores)
		{
			if(postulante.fecha_entrevista!=null)
	        {
				var d = new Date(postulante.fecha_entrevista);
			}
			else
			{
				var d = new Date("2018-01-01");
			}
	        var dia = d.getDate();
	        var mes = d.getMonth() + 1;
	        var anho = d.getFullYear();
	        var fecha = dia + "/" + this.zfill(mes,2) + "/" + anho;
	        if(postulante.hora_entrevista!=null)
	        {
	        	var cadena = "2018-11-11 "+postulante.hora_entrevista;
	        }
	        else
	        {
	        	var cadena = "2018-11-11 12:00:00";
	        }
			var diahora = new Date (cadena);
			this.id = postulante.user_id;
			this.fecha = fecha;
			this.nombreyapellido = postulante.user.name+' '+postulante.user.last_name;
			this.entrevistadores = entrevistadores;
			this.seleccionados = [];
	        this.hora = moment(diahora).format('hh:mm A');
	        this.lugar = postulante.lugar_entrevista;
	        $('#fecha').datepicker('setDate', new Date(anho, d.getMonth(), this.zfill(dia)));
			$('#fecha').datepicker('update');
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
            dataform.append('fecha', this.fecha);
            dataform.append('hora', this.hora);
			dataform.append('lugar', this.lugar);
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
		zfill: function(number, width)
		{
			var numberOutput = Math.abs(number); /* Valor absoluto del número */
    		var length = number.toString().length; /* Largo del número */
		    var zero = "0"; /* String de cero */

		    if (width <= length){
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
	},

});
</script>

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
</script>


@endsection