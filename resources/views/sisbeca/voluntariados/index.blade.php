@extends('sisbeca.layouts.main')
@section('title','Voluntariados')
@section('content')
	<div class="col-lg-12">
		<div class="text-right">
			<a href="{{route('voluntariados.crear',Auth::user()->id)}}" class="btn btn-sm sisbeca-btn-primary">Añadir Voluntariado</a>
		</div>
		<br>
		<div class="table-responsive">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>Nombre</th>
						<th>Fecha</th>
						<th>Tipo</th>
						<th class="text-center">Horas</th>
						<th class="text-center">Estatus</th>
						<th class="text-right">Acciones</th>
					</tr>
				</thead>
				<tbody>
					@if($voluntariados->count()==0)
						<td colspan="7" class="text-center">No hay <strong>voluntariados</strong></td>
					@else
						@foreach($voluntariados as $voluntariado)
						<tr>
							<td>
								{{$voluntariado->nombre}}
							</td>
							<td>{{$voluntariado->getFecha()}}</td>
							<td>{{$voluntariado->tipo}}</td>
							<td class="text-center">{{$voluntariado->horas}}</td>
							<td class="text-center">
								@switch($voluntariado->aval->estatus)
						    		@case('pendiente')
						    			<span class="label label-warning">pendiente</span>
						    		@break;
						    		
						    		@case( 'aceptada')
						    			<span class="label badge-success">aceptada</span>
						    		@break

						    		@case ('negada')
						    			<span class="label label-danger">negada</span>
						    		@break
						    	@endswitch
							</td>
							
							<td>
								<a href="{{url($voluntariado->aval->url)}}" target="_blank" class="btn btn-xs sisbeca-btn-primary" data-toggle="tooltip" data-placement="bottom" title="Ver Nota">
									@if( $voluntariado->aval->esImagen() )
		                        		<i class="fa fa-photo"></i>
		                        	@else
		                        		<i class="fa fa-file-pdf-o"></i>
		                        	@endif
								</a>

								<a href="{{route('voluntariados.editar',$voluntariado->id)}}" class="btn btn-xs sisbeca-btn-primary" data-toggle="tooltip" data-placement="bottom" title="Editar">
		                        	<i class="fa fa-pencil"></i>
								</a>

								<a href="#" class="btn btn-xs sisbeca-btn-default" data-toggle="tooltip" data-placement="bottom" title="Eliminar">
		                        	<i class="fa fa-trash"></i>
								</a>
								
							</td>
						</tr>
						@endforeach
					@endif
				</tbody>
			</table>
		</div>
		<hr>
		<p class="h6 text-right">{{ $voluntariados->count() }} voluntariado(s) </p>
	</div>
@endsection

@section('personaljs')
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>
@endsection
