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
						<a :href="getJustificativo(justificativo.aval.url)" class="btn btn-xs sisbeca-btn-primary" title="Ver justificativo" target="_blank">
                            <i class="fa fa-eye"></i>
                        </a>
                        
                        <button type="button" class="btn btn-xs sisbeca-btn-primary" @click="aprobarJustificativo(justificativo.aval.id)" title="Aprobar justificativo">
                            <i class="fa fa-check"></i>
                        </button>
                    
                        <button type="button" class="btn btn-xs sisbeca-btn-default" @click="negarJustificativo(justificativo.aval.id)" title="Rechazar justificativo">
                            <i class="fa fa-remove"></i>
                        </button>
                        
                        <button type="button" class="btn btn-xs sisbeca-btn-default" @click="devolverJustificativo(justificativo.aval.id)" title="Devolver justificativo">
                            <i class="fa fa-reply"></i>
                        </button>
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

	
</div>

@endsection

@section('personaljs')
<script>
const app = new Vue({

    el: '#app',
    data:
    {
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
        aprobarJustificativo(id)
        {
            var url = '{{route('aval.aceptar',':id')}}';
            url = url.replace(':id', id);
            axios.get(url).then(response => 
            {
                console.log("aprobar");
                toastr.success(response.data.success);
            });
            this.obtenerjustificativos();
        },
        negarJustificativo(id)
        {
            var url = '{{route('aval.negar',':id')}}';
            url = url.replace(':id', id);
            axios.get(url).then(response => 
            {
                console.log("negar");
                toastr.success(response.data.success);
            });
            this.obtenerjustificativos();
        },
        devolverJustificativo(id)
        {
            var url = '{{route('aval.devolver',':id')}}';
            url = url.replace(':id', id);
            axios.get(url).then(response => 
            {
                console.log("devolver");
                toastr.success(response.data.success);
            });
            this.obtenerjustificativos();
        },
    	getRutaVerJustificativo: function(url_justificativo)
    	{
    		var url = "{{url(':slug')}}";
    		url = url.replace(':slug', url_justificativo);
            return url;
    	},
    	obtenerjustificativos: function()
    	{
    		var url = '{{route('actividad.justificativos.servicio',$actividad->id)}}';
            axios.get(url).then(response => 
            {
            	this.justificativos = response.data.justificativos;
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