@extends('sisbeca.layouts.main')
@section('title',"Justificativos del ".ucwords($actividad->tipo).': '.$actividad->nombre)
@section('personalcss')
<style>

</style>
@endsection
@section('content')
<div class="col-lg-12" id="app">
	<div class="text-right">
		<a href="{{route('actividad.detalles',$actividad->id)}}" class="btn btn-sm sisbeca-btn-primary">Atrás</a>
	</div>
	<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th>Becario</th>
					<th>Estatus</th>
					<th>Inscrito el</th>
					<th>Justificativo Actualizado el</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="justificativo in justificativos">
					<td>@{{ justificativo.user.name}} @{{ justificativo.user.last_name}}</td>
					<td>
						<template v-if="justificativo.estatus=='asistio'">
                            <span class="label label-success">
                                @{{ justificativo.estatus }}
                            </span>
                             
                            <template v-if="justificativo.aval_id!=null">
                                &nbsp;/&nbsp;
                                <span  class="label label-custom">justificación cargada</span>
                                
                                fue 

                                <span v-if="justificativo.aval.estatus=='aceptada'" class="label label-success">
                                    @{{ justificativo.aval.estatus }}
                                </span>
                            </template>
                        </template>

                        <template v-if="justificativo.estatus=='no asistio'">
                            <span class="label label-danger">
                                @{{ justificativo.estatus }}
                            </span>
                             
                            <template v-if="justificativo.aval_id!=null">
                                &nbsp;/&nbsp;
                                <span  class="label label-custom">justificación cargada</span>
                                
                                fue 

                                <span v-if="justificativo.aval.estatus=='negada'" class="label label-danger">
                                    @{{ justificativo.aval.estatus }}
                                </span>
                            </template>
                        </template>

                        <template v-if="justificativo.estatus=='justificacion cargada'">
                            <span  class="label label-custom">@{{ justificativo.estatus }}</span>

                            está

                            <span v-if="justificativo.aval.estatus=='pendiente'" class="label label-warning">
                                @{{ justificativo.aval.estatus }}
                            </span>

                            <span v-if="justificativo.aval.estatus=='devuelto'" class="label label-danger">
                                @{{ justificativo.aval.estatus }}
                            </span>
                        </template>

                        <!-- 
						<span v-if="justificativo.aval.estatus=='pendiente'" class="label label-warning">
							@{{ justificativo.aval.estatus }}</span>
						<span v-if="justificativo.aval.estatus=='aceptada'" class="label label-success">
							@{{ justificativo.aval.estatus }}</span>
						<span v-if="justificativo.aval.estatus=='negada'" class="label label-danger">
							@{{ justificativo.aval.estatus }}</span>
						-->

					</td>
					<td>@{{fechaformartear(justificativo.created_at)}}</td>
					<td>@{{fechaformartear(justificativo.aval.updated_at)}}</td>
					<td>
						<a v-b-popover.hover.bottom="'Ver Justificativo'" :href="getJustificativo(justificativo.aval.url)" class="btn btn-xs sisbeca-btn-primary" target="_blank">
                            <i class="fa fa-eye"></i>
                        </a>
                        
                        <button v-b-popover.hover.bottom="'Aprobar justificativo'" class="btn btn-xs sisbeca-btn-primary" @click="modalAprobar(justificativo)">
                            <i class="fa fa-check"></i>
                        </button>
                        <!-- @click="aprobarJustificativo(justificativo.aval.id)"-->
                        <button v-b-popover.hover.bottom="'Rechazar justificativo'" class="btn btn-xs sisbeca-btn-default" @click="modalRechazar(justificativo)">
                            <i class="fa fa-remove"></i>
                        </button>
                        <!--  @click="negarJustificativo(justificativo.aval.id)"-->
                        <button v-b-popover.hover.bottom="'Devolver justificativo'" class="btn btn-xs sisbeca-btn-default" @click="modalDevolver(justificativo)">
                            <i class="fa fa-reply"></i>
                        </button>
                        <!--@click="devolverJustificativo(justificativo.aval.id)"-->
					</td>
				</tr>
				<tr v-if="justificativos.length==0">
					<td colspan="7" class="text-center">No hay <strong>justificativos</strong> para este <strong>{{$actividad->tipo}}</strong>.</td>
				</tr>
			</tbody>
		</table>
		<hr>
		<p class="text-right h6">@{{ justificativos.length}} justificativo(s)</p>
	</div>

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
const app = new Vue({

    el: '#app',
    data:
    {
        justificativo:{},
        justificativos:[],
    },
    created: function()
    {
        this.obtenerjustificativos();
    },
    mounted: function()
    {
    	$('[data-toggle="tooltip"]').tooltip(); 
    },
    methods: 
    {
    	getJustificativo(link)
        {

            var url = '{{url(':link')}}';
            url = url.replace(':link', link);
            return url;
        },
        modalAprobar(justificativo)
        {
            Vue.set(app.justificativo, 'id', t.id);
        },
        aprobarJustificativo(id)
        {
            $("#preloader").show();
            var url = '{{route('aval.aceptar',':id')}}';
            url = url.replace(':id', id);
            axios.get(url).then(response => 
            {
                this.obtenerjustificativos();
                $("#preloader").hide();
                toastr.success(response.data.success);
            });
        },
        negarJustificativo(id)
        {
            $("#preloader").show();
            var url = '{{route('aval.negar',':id')}}';
            url = url.replace(':id', id);
            axios.get(url).then(response => 
            {
                this.obtenerjustificativos();
                $("#preloader").hide();
                toastr.success(response.data.success);
            });
        },
        devolverJustificativo(id)
        {
            $("#preloader").show();
            var url = '{{route('aval.devolver',':id')}}';
            url = url.replace(':id', id);
            axios.get(url).then(response => 
            {
                this.obtenerjustificativos();
                $("#preloader").hide();
                toastr.success(response.data.success);
            });
            
        },
    	getRutaVerJustificativo: function(url_justificativo)
    	{
    		var url = "{{url(':slug')}}";
    		url = url.replace(':slug', url_justificativo);
            return url;
    	},
    	obtenerjustificativos: function()
    	{
            $("#preloader").show();
    		var url = '{{route('actividad.justificativos.servicio',$actividad->id)}}';
            axios.get(url).then(response => 
            {
            	this.justificativos = response.data.justificativos;
                $("#preloader").hide();
            });
    	},
    	fechaformartear: function (fecha)
		{
			var d = new Date(fecha);
			return moment(d).format('DD/MM/YYYY hh:mm A');
		}
    }
});
</script>
@endsection