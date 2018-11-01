@extends('sisbeca.layouts.main')
@section('title','Nómina')
@section('subtitle','Nóminas Generadas')
@section('content')

<div class="row">
	
	<div class="col-lg-12" style="padding-top: 15px; padding-bottom: 15px;">
		Nóminadas Generadas
		<hr/>

	</div>
	<div class="col-lg-12 table-responsive">
		@if($nominas->count() > 0)
		<table class="display" style="width:100%" id="myTable">
			<thead>
				<tr>
					
					<th class="text-center">Mes/Año</th>
					<th class="text-center">N° Becarios</th>
					<th class="text-right">Sueldo Base</th>
					<th class="text-right">Total a Pagar</th>
					<th class="text-center">Fecha Generada</th>
					<th class="text-center">Acciones</th>
				</tr>
			</thead>
			<tbody>
				@foreach($nominas as $nomina)
				<tr>
					<td class="text-center">{{ $nomina->mes.'/'.$nomina->year }}</td>
					<td class="text-center">{{ $nomina->total_becarios }}</td>
					<td class="text-right">{{number_format($nomina->sueldo_base, 2, ',', '.')}}</td>
					<td class="text-right">{{ number_format($nomina->total_pagado, 2, ',', '.') }}</td>
					<td class="text-center">{{ date("d/m/Y", strtotime($nomina->fecha_generada)) }}</td>
					<td class="text-center">
						<a href="{{ route('nomina.listar.ver',array('mes'=>$nomina->mes,'anho'=>$nomina->year)) }}" class="btn btn-xs btn-info">Consultar</a>
						<a href="{{ route('nomina.generado.pdf',array('mes'=>$nomina->mes,'anho'=>$nomina->year)) }}" class="btn btn-xs btn-info" target="_blank">Generar PDF</a>
						<a href="{{ route('nomina.pagar',array('mes'=>$nomina->mes,'anho'=>$nomina->year)) }}" class="btn btn-xs btn-danger">Pagar Nómina</a>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else
			<p class="text-center">No existen <strong>nóminas generadas que esten pendientes por pagar</strong>.</p>
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
