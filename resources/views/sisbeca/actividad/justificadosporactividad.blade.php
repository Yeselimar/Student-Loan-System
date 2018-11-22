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
					<td>@{{fechaformartear(justificativo.created_at)}}</td>
					<td>@{{justificativo.updated_at}}</td>
					<td>
						<button type="button" class="btn btn-xs sisbeca-btn-primary">
							<i class="fa fa-eye"></i>
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
    }
});
</script>
@endsection