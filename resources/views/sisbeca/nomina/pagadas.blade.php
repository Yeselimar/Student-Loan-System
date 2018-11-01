@extends('sisbeca.layouts.main')
@section('title','Nómina')
@section('subtitle','Nóminas Pagadas')
@section('content')

<div class="row">
	
	<div class="col-lg-12" style="padding-top: 15px; padding-bottom: 15px;">
		Nóminas Pagadas
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
					<th class="text-right">Total Pagado</th>
					<th class="text-center">Fecha Pago</th>
					<th class="text-center">Acciones</th>
				</tr>
			</thead>
			<tbody>
				@foreach($nominas as $nomina)
				<tr>
					<td class="text-center">{{ $nomina->mes.'/'.$nomina->year }}</td>
					<td class="text-center">{{ $nomina->total_becarios }}</td>
					<td class="text-right">{{ number_format($nomina->sueldo_base, 2, ',', '.') }}</td>
					<td class="text-right">{{ number_format($nomina->total_pagado, 2, ',', '.') }}</td>
					<td class="text-center">{{ date("d/m/Y", strtotime($nomina->fecha_pago)) }}</td>
					<td class="text-center">
						<a href="{{ route('nomina.listar.pagadas',array('mes'=>$nomina->mes,'anho'=>$nomina->year)) }}" class="btn btn-xs btn-info">Consultar</a>
						<a href="{{ route('nomina.pagado.pdf',array('mes'=>$nomina->mes,'anho'=>$nomina->year)) }}" class="btn btn-xs btn-info" target="_blank">Generar PDF</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else
			<p class="text-center">No hay <strong>nóminas</strong> pagadas.</p>
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
	</script>
@endsection
