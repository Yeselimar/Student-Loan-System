@extends('sisbeca.layouts.main')
@section('title',"Justificativos de Talleres y Chat Club")
@section('personalcss')
<style>

</style>
@endsection
@section('content')
<div class="col-lg-12" id="app">
	<div class="text-right">
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
					<td>@{{ justificativo.id}}</td>
					<td>@{{ justificativo.user.name}} @{{ justificativo.user.last_name}}</td>
					<td>@{{justificativo.estatus}}</td>
					<td>@{{justificativo.created_at}}</td>
					<td>@{{justificativo.updated_at}}</td>
					<td></td>
				</tr>
			</tbody>
		</table>
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
    		var url = '{{route('actividad.obtenerjustificativos')}}';
            axios.get(url).then(response => 
            {
            	this.justificativos = response.data.justificativos;
            });
    	}
    }
});
</script>
@endsection