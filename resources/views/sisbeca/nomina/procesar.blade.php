@extends('sisbeca.layouts.main')
@section('title','Nómina por procesar')
@section('content')

<div class="col-lg-12">
	
	@if($generar)
		<button type="button" onclick="procesarNomina()" class="btn btn-sm sisbeca-btn-primary pull-right ">Generar Nómina</button>
	@else
		<a href="javascript:void(0)" class="btn btn-sm sisbeca-btn-primary pull-right disabled" >Generar Nómina</a>
	@endif
	
	<div class="table-responsive">
		<table id="nomina" class="table table-bordered table-hover" style="border:1px solid #eee">
			<thead>
				<tr>
					<th class="text-center">Mes/Año</th>
					<th class="text-center">N° Becarios</th>
					<th class="text-right">Sueldo Base</th>
					<th class="text-center">Fecha de Creación</th>
					<th class="text-center">Estatus Actual</th>
					<th class="text-center">Acciones</th>
				</tr>
			</thead>
			<tbody>
				@if($nominas->count() > 0)
				@foreach($nominas as $nomina)
				<tr>
					<td class="text-center">{{ $nomina->mes.'/'.$nomina->year }}</td>
					<td class="text-center">{{ $nomina->total_becarios }}</td>
					<td class="text-right">{{ number_format($nomina->sueldo_base, 2, ',', '.') }}</td>
					<td class="text-center">
						{{date("d/m/Y h:i:s a", strtotime($nomina->created_at)) }}
					</td>
					@if($nomina->status==='pendiente')
						<td class="text-center">
							<span class="label label-danger">
								{{ $nomina->status }}
							</span>
						</td>
					@else
						<td class="text-center"><span class="label label-succes">
							{{ strtoupper( $nomina->status) }}</span>
						</td>

					@endif
					<td class="text-center">
						<a href="{{ route('nomina.procesar.detalle',array('mes'=>$nomina->mes,'anho'=>$nomina->year)) }}" class="btn btn-xs sisbeca-btn-primary">Procesar</a>
					</td>
				</tr>
				@endforeach

				@else
					<tr>
						<td colspan="6" class="text-center">No hay <strong>nóminas pendientes por ser procesadas</strong>.</td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
</div>
@endsection

@section('personaljs')
<script>
        
	$(document).ready(function(){
	$('#nomina').DataTable({

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
	        "search": "Buscar:",
	        "zeroRecords": "No hay resultados encontrados",
	        "paginate":
	            {
	                "first": "Primero",
	                "last": "Ultimo",
	                "next": "Siguiente",
	                "previous": "Anterior"
	            }
	        }
	    });
	});


    function procesarNomina()
    {
        var id=  $("#id").val();

        var route= "#";

        $.ajax({
            url: route,
            beforeSend: function() {
                $('.preloader').show();
            },
            complete: function(){
                location.assign( "{{ route('nomina.generar.todo',array('mes'=>$mes,'anho'=>$anho) ) }}");
            }
        });
    }
</script>
@endsection
