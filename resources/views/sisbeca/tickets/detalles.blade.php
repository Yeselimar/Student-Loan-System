@extends('sisbeca.layouts.main')
@section('title','Ticket: '.$ticket->getNro())
@section('content')
<div class="col-lg-12" id="app">
	<div class="text-right">
		@if(Auth::user()->esSoporte())
        <button v-b-popover.hover.bottom="'Responder ticket'" class="btn btn-sm sisbeca-btn-primary" @click="modalActualizar()">
        	<i class="fa fa-gavel"></i>
        </button>
        @endif
    </div>
    <br>
	<div class="col sisbeca-container-formulario">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<label class="control-label ">Pertenece a</label>
				<input type="text" class="sisbeca-input sisbeca-disabled" :value="ticket.pertenece" disabled="disabled">
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<label class="control-label ">Estatus</label>
				<input type="text" class="sisbeca-input sisbeca-disabled" :value="ticket.estatus" disabled="disabled">
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<label class="control-label ">Cargado el</label>
				<input type="text" class="sisbeca-input sisbeca-disabled" :value="fechaformatear(ticket.created_at)" disabled="disabled">
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<label class="control-label ">Prioridad</label>
				<input type="text" class="sisbeca-input sisbeca-disabled" :value="ticket.prioridad" disabled="disabled">
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<label class="control-label ">Tipo</label>
				<input type="text" class="sisbeca-input sisbeca-disabled" :value="ticket.tipo" disabled="disabled">
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
				<label class="control-label ">Asunto</label>
				<input type="text" class="sisbeca-input sisbeca-disabled" :value="ticket.asunto" disabled="disabled">
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<label class="control-label ">URL</label>
				<input type="text" class="sisbeca-input sisbeca-disabled" :value="ticket.url" disabled="disabled">
			</div>
			<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
				<label class="control-label ">Imagen</label>
				<a :href="urlVerImagen(ticket.imagen)" target="_blank" class="btn sisbeca-btn-primary btn-block">
                	Ver Imagen <i class="fa fa-photo"></i>
            	</a>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label class="control-label ">Descripción</label>
				<textarea class="sisbeca-textarea sisbeca-input sisbeca-disabled" :value="ticket.descripcion" disabled="disabled"></textarea> 
			</div>
		</div>

		<hr>
		
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label class="control-label ">Respuesta</label>
				<textarea class="sisbeca-textarea sisbeca-input sisbeca-disabled" :value="ticket.respuesta" disabled="disabled">
				</textarea>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<label class="control-label ">Respondido por</label>
				<input type="text" class="sisbeca-input sisbeca-disabled" :value="ticket.usuariorespuesta" disabled="disabled">
			</div>
		</div>
	</div>

	<!-- Modal para tomar accion -->
    <div class="modal fade" id="modalActualizar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title pull-left">
                    	<strong>Ticket @{{ticket.nro}}</strong>
                    </h5>
                    <a class="pull-right mr-1" href="javascript(0)" data-dismiss="modal" ><i class="fa fa-remove"></i></a>
                </div>
                <div class="modal-body">
                    <div class="col" style="padding-left: 0px;padding-right: 0px;">
                        <label class="control-label " for="nombre">Estatus</label>
                       	<select v-model="ticket.estatus" class="sisbeca-input input-sm sisbeca-select">
                            <option v-for="estatu in estatus" :value="estatu">@{{ estatu}}</option>
                        </select>
                        
                    </div>
                    <div class="col" style="padding-left: 0px;padding-right: 0px;">
                        <label class="control-label" for="observacion">Respuesta</label>
                        <textarea name="observacion" class="sisbeca-input " v-model="ticket.respuesta" placeholder="EJ: No se observacion bien el archivo..." style="margin-bottom: 0px">
                        </textarea> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm sisbeca-btn-default pull-right" data-dismiss="modal" >Cancelar</button>
                    <button @click="actualizarEstatus()" class="btn btn-sm sisbeca-btn-primary pull-right">Guardar</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal para tomar accion -->

	<!-- Cargando.. -->
	<section class="loading" id="preloader">
		<div>
			<svg class="circular" viewBox="25 25 50 50">
				<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
		</div>
	</section>
	<!-- Cargando.. -->
</div>
@endsection

@section('personaljs')

<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>

<script>
	Vue.use(BootstrapVue);

	const app = new Vue({
	el: '#app',
	data:
	{
		estatus:'',
		ticket: {
	    },
	},
	created: function()
	{
		this.obtenerticket();
		this.obtenerestatusticket();
	},
	methods: 
	{
		obtenerticket()
		{
			var id = '{{$ticket->id}}';
			var url = '{{route('ticket.detalles.servicio',':id')}}';
			url = url.replace(':id', id);
			axios.get(url).then(response => 
			{
				var t = response.data.ticket;
				Vue.set(app.ticket, 'id', t.id);
				Vue.set(app.ticket, 'nro', t.nro);
				Vue.set(app.ticket, 'estatus', t.estatus);
				Vue.set(app.ticket, 'prioridad', this.primeramayuscula(t.prioridad));
				Vue.set(app.ticket, 'tipo', this.primeramayuscula(t.tipo));
				Vue.set(app.ticket, 'asunto', t.asunto);
				Vue.set(app.ticket, 'descripcion', t.descripcion);
				Vue.set(app.ticket, 'imagen', t.imagen);
				Vue.set(app.ticket, 'url', t.url);
				Vue.set(app.ticket, 'respuesta', t.respuesta);
				Vue.set(app.ticket, 'usuariogenero', t.usuariogenero);
				Vue.set(app.ticket, 'usuariorespuesta', t.usuariorespuesta);
				Vue.set(app.ticket, 'pertenece',  t.usuariogenero+' ('+this.primeramayuscula(t.rolgenero)+')');
				
				Vue.set(app.ticket, 'created_at', t.created_at.date);
				Vue.set(app.ticket, 'updated_at', t.updated_at.date);
				$("#preloader").hide();
			}).catch( error => {
				console.log(error);
				$("#preloader").hide();
			});
		},
		modalActualizar()
		{
			$('#modalActualizar').modal('show');
		},
		obtenerestatusticket()
        {
            var url = '{{route('ticket.estatus')}}';
            axios.get(url).then(response => 
            {
                this.estatus = response.data.estatus;
            });
        },
		actualizarEstatus(id)
		{

		},
		urlVerImagen(slug)
		{
			var url = "{{url(':slug')}}";
    		url = url.replace(':slug', slug);
            return url;
		},
		primeramayuscula(string)
		{
			return string.charAt(0).toUpperCase() + string.slice(1);
		},
		fechaformatear(fecha)
		{
			return moment(new Date (fecha)).format('DD/MM/YYYY hh:mm A');
		}
	}
});
</script>

@endsection