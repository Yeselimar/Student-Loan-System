@extends('sisbeca.layouts.main')
@section('title',ucwords($actividad->tipo).': '.$actividad->nombre)
@section('personalcss')
<style>
	#informacion td, #informacion th,
	#facilitador td, #facilitador th,
	#becarios th
	{
		line-height: 10px !important;
		color: #424242;
	}
</style>
@endsection
@section('content')
<div class="col-lg-12" id="app">
	<div class="text-right">
		@if(Auth::user()->esBecario() ) <!-- Para el Becario -->
			<template v-if="!inscrito">
				@if($actividad->inscribionabierta())
				<button type="button" class="btn btn-sm sisbeca-btn-primary" @click="actividadinscribirme()">Inscribirme</button>
				@else
				<button type="button" class="btn btn-sm sisbeca-btn-primary" disabled="disabled">Inscribirme</button>
				@endif
			</template>
			<template v-else>
				@if($actividad->inscribionabierta())
					<button type="button" class="btn btn-sm sisbeca-btn-primary" @click="desinscribirme()">Desinscribirme</button>
				@else
					<button type="button" class="btn btn-sm sisbeca-btn-primary" disabled="disabled">Desinscribirme</button>
				@endif
			</template>
		@else <!-- Para el Administrador -->
			<a href="{{route('actividad.inscribir.becario',$actividad->id)}}" class="btn btn-sm sisbeca-btn-primary">Inscribir Becario</a>
		@endif
	</div>
	<div class="table-responsive">
		<table class="table table-bordered" id="informacion">
			<thead>
				<tr>
					<th colspan="2">
						Información General
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td class="text-left">
						<template v-if="actividad.tipo=='taller'">
							<strong>Taller</strong>
						</template>
						<template v-else>
							<strong>Chat Club</strong>
						</template>
					</td>
					<td class="text-left">
						@{{ actividad.nombre }}
					</td>
				</tr>
				<tr>
					<td class="text-left">
						<strong>Modalidad</strong>
					</td>
					<td class="text-left">
						<template v-if="actividad.modalidad=='virtual'">
							<i class="fa fa-laptop"></i>
						</template>
						<template v-else>
							<i class="fa fa-male"></i>
						</template>
						@{{ actividad.modalidad }}
					</td>
				</tr>
				<tr>
					<td class="text-left">
						<strong>Fecha</strong>
					</td>
					<td class="text-left">
						@{{ diaSemana(actividad.fecha)}}, 
						@{{ fechaformartear(actividad.fecha)}}
					</td>
				</tr>
				<tr>
					<td class="text-left">
						<strong>Hora</strong>
					</td>
					<td class="text-left">
						@{{ horaformatear(actividad.hora_inicio)}} 
						a 
						@{{ horaformatear(actividad.hora_fin)}} 
					</td>
				</tr>
				<tr>
					<td class="text-left">
						<strong>Nivel</strong>
					</td>
					<td class="text-left">
						@{{ actividad.nivel }}
					</td>
				</tr>
				<tr>
					<th class="text-left">
						<strong>Año Académico</strong>
					</th>
					<td class="text-left">
						@{{ actividad.anho_academico }}
					</td>
				</tr>
				<tr>
					<td class="text-left">
						<strong>Estatus @{{ actividad.tipo}}</strong>
					</td>
					<td class="text-left">
						<span v-if="actividad.status=='disponible'" class="label label-success">
							@{{ actividad.status }}</span>
						<span v-if="actividad.status=='suspedido'" class="label label-danger">
							@{{ actividad.status }}</span>
						<span v-if="actividad.status=='bloqueado'" class="label label-warning">
							@{{ actividad.status }}</span>
					</td>
				</tr>
				<tr>
					<td class="text-left">
						<strong>Límite participantes</strong>
					</td>
					<td class="text-left">
						@{{ actividad.limite_participantes }}
					</td>
				</tr>
				<tr>
					<td class="text-left">
						<strong>Descripción</strong>
					</td>
					<td class="text-left">
						@{{ actividad.descripcion }}
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<br>
	<div class="table-responsive">
		<table class="table table-bordered" id="facilitador">
			<thead>
				<tr>
					<th>
						Facilitador(es)
					</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="facilitador in facilitadores">
					<td class="text-left">
						<template v-if="facilitador.becario_id!=null">
							@{{ facilitador.user.name}} @{{ facilitador.user.last_name}}
						</template>
						<template>
							@{{ facilitador.nombreyapellido}}
						</template>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<br>
	<div class="table-responsive">
		<table class="table table-bordered table-striped" id="becarios">
			<thead>
				<tr>
					<th>
						Becarios Inscritos
					</th>
					<th class="text-center">
						Estatus
					</th>
					@if(Auth::user()->admin() )
					<th class="text-center">
						Acciones
					</th>
					@endif
				</tr>
			</thead>
			<tbody>
				<tr v-for="becario in becarios">
					<td class="text-left" colspan="1">
						@{{ becario.user.name}} @{{ becario.user.last_name}}
					</td>
					<td class="text-center">
						<span v-if="becario.estatus=='asistira'" class="label label-success">
							@{{ becario.estatus }}
						</span>
						<span v-if="becario.estatus=='en espera'" class="label label-warning">
							@{{ becario.estatus }}
						</span>
						<span v-if="becario.estatus=='por justificar'" class="label label-custom">
							@{{ becario.estatus }}
						</span>
						<span v-if="becario.estatus=='asistio'" class="label label-success">
							@{{ becario.estatus }}
						</span>
						<span v-if="becario.estatus=='no asistio'" class="label label-danger">
							@{{ becario.estatus }}
						</span>
					</td>
					@if(Auth::user()->admin() )
					<td>
						<button type="button" class="btn btn-xs sisbeca-btn-primary" @click="desinscribirModal(becario.user.id,becario.user.name+' '+becario.user.last_name)">Eliminar Inscripción</button>
						<div v-if="becario.estatus=='por justificar'">
							<a href="#" class="btn btn-xs sisbeca-btn-primary">Subir Justificación</a>
						</div>
					</td>
					@endif
				</tr>
				<tr v-if="becarios && becarios.length==0">
					<td class="text-left" @if(Auth::user()->admin() ) colspan="3" @else colspan="2" @endif>
						No hay <strong>becarios</strong> para este <strong>@{{ actividad.tipo }}</strong>
					</td>
				</tr>
			</tbody>
		</table>
		<hr>
		<p class="h6 text-right">@{{ becarios.length }} becario(s)</p>
	</div>


	<!-- Modal para eliminar inscripición -->
	<form method="POST" @submit.prevent="desinscribir(id)" class="form-horizontal"  >
	{{ csrf_field() }}
		<div class="modal fade" id="desinscribirModal">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
				    	<h5 class="modal-title"><strong>Eliminar Inscripción</strong></h5>
				    </div>
					<div class="modal-body">
						<br>
						<div class="col">
							<p class="text-center">¿Está seguro que desea eliminar al becario <strong>@{{ nombrebecario}}</strong> del <strong>@{{this.actividad.tipo}}</strong> con nombre <strong>@{{this.actividad.nombre}}</strong> ?</p>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-sm sisbeca-btn-default pull-right" data-dismiss="modal">No</button>
						<button type="submit" class="btn btn-sm sisbeca-btn-primary pull-right">Si</button>
					</div>
				</div>
			</div>
		</div>
	</form>
	<!-- Modal para eliminar inscripición -->
</div>
@endsection

@section('personaljs')

<script>
const app = new Vue({

    el: '#app',
    data:
    {
    	id:0,
    	nombrebecario:'',
        actividad:'',
        facilitadores:'',
        becarios:'',
        inscrito:true,
    },
    created: function()
    {
        this.obtenerdetallesactividad();

    },
    methods:
    {	
    	desinscribirme: function()
    	{
    		var actividad_id = '{{$actividad->id}}';
    		var becario_id = '{{Auth::user()->id}}';
    		var url = '{{route('actividad.desinscribir',array('actividad_id'=>':a_id','becario_id'=>':b_id'))}}';
    		url = url.replace(':a_id', actividad_id);
    		url = url.replace(':b_id', becario_id);
            axios.get(url).then(response => 
            {
            	this.obtenerdetallesactividad();
            	if(response.data.tipo=='danger')
            	{
            		toastr.error(response.data.mensaje);
            	}
                else
                {
                	toastr.success(response.data.mensaje);
                }
            });
    	},
    	desinscribirModal: function(id,becario)
    	{	
    		this.id = id;
    		this.nombrebecario = becario;
    		$('#desinscribirModal').modal('show');
    	},
    	desinscribir: function(id)
    	{
    		var actividad_id = '{{$actividad->id}}';
    		var becario_id = id;
    		var url = '{{route('actividad.desinscribir',array('actividad_id'=>':a_id','becario_id'=>':b_id'))}}';
    		url = url.replace(':a_id', actividad_id);
    		url = url.replace(':b_id', becario_id);
            axios.get(url).then(response => 
            {
            	$('#desinscribirModal').modal('hide');
            	this.obtenerdetallesactividad();
            	if(response.data.tipo=='danger')
            	{
            		toastr.error(response.data.mensaje);
            	}
                else
                {
                	toastr.success(response.data.mensaje);
                }
            });
    		
    	},
    	actividadinscribirme: function()
    	{
    		var actividad_id = '{{$actividad->id}}';
    		var becario_id = '{{Auth::user()->id}}';
    		var url = '{{route('actividad.inscribirme',array('actividad_id'=>':a_id','becario_id'=>':b_id'))}}';
    		url = url.replace(':a_id', actividad_id);
    		url = url.replace(':b_id', becario_id);
            //console.log(url);
            axios.get(url).then(response => 
            {
            	this.obtenerdetallesactividad();
            	if(response.data.tipo=='danger')
            	{
            		toastr.error(response.data.mensaje);
            	}
                else
                {
                	toastr.success(response.data.mensaje);
                }
            });
    		//console.log(becario_id+' '+actividad_id);
    	},
    	obtenerdetallesactividad()
    	{
    		var url = '{{route('actividad.detalles.servicio',$actividad->id)}}';
            axios.get(url).then(response => 
            {
                this.actividad = response.data.actividad;
                this.facilitadores = response.data.facilitadores;
                this.becarios = response.data.becarios;
                this.inscrito = response.data.inscrito;
            });
    	},
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
		},
		diaSemana: function(fecha)
		{
		    var dias=["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado"];
		    var dt = new Date(fecha);
		    return dias[dt.getUTCDay()];    
		}
    }
});
</script>
@endsection