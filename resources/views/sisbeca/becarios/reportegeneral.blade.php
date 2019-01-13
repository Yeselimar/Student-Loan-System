@extends('sisbeca.layouts.main')
@section('title','Reporte General')
@section('content')
<div class="col-lg-12" id="app">
	<div class="row" style="border:1px solid #fff">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<select class="form-control sisbeca-input" v-model="anho">
			  	<option disabled value="">Año</option>
			  	<option>2019</option>
			  	<option>2018</option>
			  	<option>2017</option>
			</select>
			<!--<span>Año: @{{ anho }}</span>-->
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<select class="form-control sisbeca-input" v-model="mes">
			  	<option disabled value="">Mes</option>
			  	<option value="01">Todos</option>
			  	<option value="01">Enero</option>
			  	<option value="02">Febrero</option>
			  	<option value="03">Marzo</option>
			  	<option value="04">Abril</option>
			  	<option value="05">Mayo</option>
			  	<option value="06">Junio</option>
			  	<option value="07">Julio</option>
			  	<option value="08">Agosto</option>
			  	<option value="09">Septiembre</option>
			  	<option value="10">Octubre</option>
			  	<option value="11">Noviembre</option>
			  	<option value="12">Diciembre</option>
			</select>
			<!--<span>Año: @{{ mes }}</span>-->
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<button type="submit" class="btn btn-md sisbeca-btn-primary btn-block" style="line-height: 1.80 !important">Consultar</button>
		</div>
	</div>
	<div class="table-responsive">
		<table class="table table-hover table-bordered" id="reporte">
			<thead>
				<tr>
					<th>Becario</th>
					<th class="text-center">Año o Semestre</th>
					<th class="text-center">H. Vol.</th>
					<th class="text-center"># Taller</th>
					<th class="text-center"># Chat</th>
					<th class="text-center">CVA</th>
					<th class="text-center">AVG CVA</th>
					<th class="text-center">AVG Acad.</th>
					<th>AVG Desemp.</th>
				</tr>
			</thead>
			<tbody>
				@foreach($becarios as $becario)
				<tr>
					<th>
						{{$becario->user->nombreyapellido()}}
						<br>
						{{$becario->user->cedula}}
					</th>
					<th class="text-center">{{$becario->getAnhoSemestreCarrera()}}</th>
					<th class="text-center">{{$becario->getHorasVoluntariados()}}</th>
					<th class="text-center">{{$becario->getTotalTalleres()}}</th>
					<th class="text-center">{{$becario->getTotalChatClubs()}}</th>
					<th class="text-center">{{$becario->getNivelCVA()}}</th>
					<th class="text-center">{{$becario->promediotodoscva()}}</th>
					<th class="text-center">{{$becario->promediotodosperiodos()}}</th>
					<th></th>
				</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@endsection

@section('personaljs')
<script>
$(document).ready(function() {
    $('#reporte').DataTable({

        "language": {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar",
        "zeroRecords": "No hay resultados encontrados",
        "paginate":
            {
                "first": "Primero",
                "last": "Ultimo",
                "next": '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                "previous": '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
            }
        }
    });
});
</script>

<script>
	const app = new Vue({

		el: '#app',
		data:
		{
			anho:'',
			mes:'',
		},
		methods:
		{
		}
	});
</script>
@endsection