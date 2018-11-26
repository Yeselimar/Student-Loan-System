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
					<th>ID</th>
					<th>Becario</th>
					<th>Estatus</th>
					<th>Cambiar Estatus</th>
					<th>Cargado el</th>
					<th>Actualizado el</th>
					<th>Acciones</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="justificativo in justificativos">
					<td>@{{ justificativo.aval.id}}</td>
					<td>@{{ justificativo.user.name}} @{{ justificativo.user.last_name}}</td>
					<td>
						<span v-if="justificativo.aval.estatus=='pendiente'" class="label label-warning">
							@{{ justificativo.aval.estatus }}</span>
						<span v-if="justificativo.aval.estatus=='aceptada'" class="label label-success">
							@{{ justificativo.aval.estatus }}</span>
						<span v-if="justificativo.aval.estatus=='negada'" class="label label-danger">
							@{{ justificativo.aval.estatus }}</span>
					</td>
					<td>
						<select v-model="justificativo.aval.estatus" @change="actualizarestatus(justificativo.aval.estatus,justificativo.aval.id)" class="sisbeca-input input-sm sisbeca-select">
							<option v-for="estatu in estatus" :value="estatu">@{{ estatu}}</option>
						</select>
					</td>
					<td>@{{fechaformartear(justificativo.aval.created_at)}}</td>
					<td>@{{fechaformartear(justificativo.aval.updated_at)}}</td>
					<td>
						<a :href="getRutaVerJustificativo(justificativo.aval.url)" class="btn btn-xs sisbeca-btn-primary">
							<i class="fa fa-eye"></i>
						</a>
						<button type="button" class="btn btn-xs sisbeca-btn-primary" @click="modalTomarDecision(justificativo.user.name+' '+justificativo.user.last_name,justificativo.aval.id)">
							<i class="fa fa-legal"></i>
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

	<!-- Modal para tomar decisión -->
	<div class="modal fade" id="mostrarModal">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title "><strong>Decisión Justificativo</strong></h5>
			    </div>
				<div class="modal-body">
					<div class="col-lg-12">
						<br>
						<p class="h6 text-center">Seleccione la decisión con respecto al justificativo de <strong>@{{nombrebecario}}</strong> @{{ id}}?</p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm sisbeca-btn-default pull-right" @click="rechazarJustificativo()">
						<i class="fa fa-times"></i> Rechazar
					</button>
					<button type="button" class="btn btn-sm sisbeca-btn-primary pull-right" @click="devolverJustificativo()">
						<i class="fa fa-back"></i> Devolver
					</button>
					<button type="button" class="btn btn-sm sisbeca-btn-primary pull-right" @click="aprobarJustificativo()">
						<i class="fa fa-check"></i> Aprobar
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal para tomar decisión -->
</div>

@endsection

@section('personaljs')
<script>
const app = new Vue({

    el: '#app',
    data:
    {
    	nombrebecario:'',
    	id:0,
    	estatus: [],
        justificativos:[],
    },
    created: function()
    {
        this.obtenerjustificativos();
        this.obtenerestatusaval();
    },
    mounted: function()
    {
    	$('[data-toggle="tooltip"]').tooltip(); 
    },
    methods: 
    {
    	rechazarJustificativo: function()
    	{
    		console.log("Rechazar");
    		console.log(this.id);
    		$('#mostrarModal').modal('hide');
    	},
    	devolverJustificativo: function()
    	{
    		console.log("Devolver");
    		console.log(this.id);
    		$('#mostrarModal').modal('hide');
    	},
    	aprobarJustificativo: function()
    	{
    		console.log("Aprobar");
    		console.log(this.id);
    		$('#mostrarModal').modal('hide');
    	},
    	modalTomarDecision: function(nombre,id)
    	{
    		this.nombrebecario = nombre;
    		this.id = id;
    		$('#mostrarModal').modal('show');
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
				this.obtenerjustificativos();
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