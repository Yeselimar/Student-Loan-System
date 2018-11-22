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
					<th>ID Justificativo</th>
					<th>Becario</th>
					<th>Estatus</th>
					<th>Cargado el</th>
					<th>Actualizado el</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="justificativo in justificativos">
					<td>@{{ justificativo.aval.id}}</td>
					<td>@{{ justificativo.user.name}} @{{ justificativo.user.last_name}}</td>
					<td>@{{justificativo.aval.estatus}}</td>
					<td>@{{fechaformartear(justificativo.aval.created_at)}}</td>
					<td>@{{fechaformartear(justificativo.aval.updated_at)}}</td>
					<td>
						<a :href="getRutaVerJustificativo(justificativo.aval.url)" class="btn btn-xs sisbeca-btn-primary">
							<i class="fa fa-eye"></i>
						</a>
						<button type="button" class="btn btn-xs sisbeca-btn-primary">
							<i class="fa fa-legal"></i>
						</button>
					</td>
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