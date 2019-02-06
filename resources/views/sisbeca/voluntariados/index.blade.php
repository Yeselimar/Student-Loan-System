@extends('sisbeca.layouts.main')
@section('title','Voluntariados')
@section('content')
<div class="col-lg-12">
	<div class="text-right">
		<a href="{{route('voluntariados.crear',Auth::user()->id)}}" class="btn btn-sm sisbeca-btn-primary">Cargar Voluntariado</a>
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
					<td colspan="7" class="text-center">
						No hay <strong>voluntariados</strong>
					</td>
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
					    			<span class="label label-success">aceptada</span>
					    		@break

					    		@case ('negada')
					    			<span class="label label-danger">negada</span>
					    		@break
					    		@case ('devuelto')
					    			<span class="label label-danger">devuelto</span>
					    		@break
					    	@endswitch
						</td>
						
						<td>
							<a href="{{url($voluntariado->aval->url)}}" target="_blank" class="btn btn-xs sisbeca-btn-primary" data-toggle="tooltip" data-placement="bottom" title="Ver Comprobante">
								@if( $voluntariado->aval->esImagen() )
	                        		<i class="fa fa-photo"></i>
	                        	@else
	                        		<i class="fa fa-file-pdf-o"></i>
	                        	@endif
							</a>

							<a href="{{route('voluntariados.editar',$voluntariado->id)}}" class="btn btn-xs sisbeca-btn-primary" data-toggle="tooltip" data-placement="bottom" title="Editar Voluntariado">
	                        	<i class="fa fa-pencil"></i>
							</a>

							@if($voluntariado->aval->estatus!='aceptada')
								<span data-toggle="modal" data-target="#eliminarvoluntariado{{$voluntariado->id}}">
									<button type="button" class="btn btn-xs sisbeca-btn-default" data-toggle="tooltip" data-placement="bottom" title="Eliminar Voluntariado"  >
										<i class="fa fa-trash"></i>
									</button>
								</span>
							@else
								<button class="btn btn-xs sisbeca-btn-default" disabled="disabled">
									<i class="fa fa-trash"></i>
								</button>
							@endif
							
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

<!-- Modal para eliminar voluntariado -->
@foreach($voluntariados as $voluntariado)
<div class="modal fade" id="eliminarvoluntariado{{$voluntariado->id}}">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
		    	<h5 class="modal-title pull-left"><strong>Eliminar Voluntariado</strong></h5>
		    	<a class="pull-right mr-1" href="javascript(0)" data-dismiss="modal" ><i class="fa fa-remove"></i></a>
		    </div>
			<div class="modal-body">
				<div class="col-lg-12">
					<br>
					<p class="h6 text-center">
						¿Está seguro que desea eliminar permanentemente el voluntariado <strong>{{$voluntariado->nombre}}</strong> con <strong>{{$voluntariado->horas}}</strong> horas?
					</p>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm sisbeca-btn-default pull-right" data-dismiss="modal">No</button>
				<a href="{{route('voluntariados.eliminar',$voluntariado->id)}}" class="btn btn-sm sisbeca-btn-primary pull-right">Si</a>
			</div>
		</div>
	</div>
</div>
@endforeach
<!-- Modal para eliminar voluntariado -->

@endsection

@section('personaljs')
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>
@endsection
