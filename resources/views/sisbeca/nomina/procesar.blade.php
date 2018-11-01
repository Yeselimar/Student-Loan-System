@extends('sisbeca.layouts.main')
@section('title','Nómina')
@section('subtitle','Nómina por Procesar')
@section('content')

<div class="row">
	<div class="col-lg-12" style="padding-top: 15px; padding-bottom: 15px;">
		Procesar Nómina
		@if($generar)
			<button type="button" onclick="procesarNomina()" class="btn btn-sm btn-danger pull-right ">Generar Nómina</button>

		@else
			<a href="javascript:void(0)" class="btn btn-sm btn-danger pull-right disabled" >Generar Nómina</a>
		@endif
		<hr/>

	</div>
	<div class="col-lg-12 table-responsive">
		@if($nominas->count() > 0)
		<table id="myTable" data-order='[[ 0, "asc" ]]' data-page-length='10' class="display" style="width:100%">
			<thead>
				<tr>
					
					<th class="text-center">Mes/Año</th>
					<th class="text-center">N° Becarios</th>
					<th class="text-right">Sueldo Base</th>
					<th class="text-center">Fecha de Creacion</th>
					<th class="text-center">Status Actual</th>
					<th class="text-center">Acciones</th>
				</tr>
			</thead>
			<tbody>
				@foreach($nominas as $nomina)
				<tr>
					<td class="text-center">{{ $nomina->mes.'/'.$nomina->year }}</td>
					<td class="text-center">{{ $nomina->total_becarios }}</td>
					<td class="text-right">{{ number_format($nomina->sueldo_base, 2, ',', '.') }}</td>
					<td class="text-center">{{ $nomina->created_at }}</td>
					@if($nomina->status==='pendiente')
						<td class="text-center"><span class="label label-light-danger"><strong>{{ strtoupper( $nomina->status) }}</strong></span></td>
					@else
						<td class="text-center"><span class="label label-light-succes"><strong>{{ strtoupper( $nomina->status) }}</strong></span></td>

					@endif
					<td class="text-center">
						<a href="{{ route('nomina.procesar.detalle',array('mes'=>$nomina->mes,'anho'=>$nomina->year)) }}" class="btn btn-xs btn-info">Procesar</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else
			<p class="text-center">No hay <strong>nóminas pendientes por ser procesadas</strong>.</p>
		@endif
		
	</div>
</div>
@endsection

@section('personaljs')
	<script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $('#myTable').DataTable( {
                columnDefs: [
                    { targets: [5], searchable: false}
                ]
            } );
        } );

        $('#myTable')
            .removeClass( 'display' )
            .addClass('table table-hover');


        function procesarNomina() {
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
