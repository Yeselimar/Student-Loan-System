@extends('sisbeca.layouts.main')
@section('title','CVA')
@section('content')
<div class="col-lg-12">
	<div class="text-right">
		<a href="{{route('cursos.crear',Auth::user()->id)}}" class="btn btn-sm sisbeca-btn-primary">Cargar CVA</a>
	</div>
	<br>
	<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th class="text-center">Nivel</th>
					<th class="text-center">Módulo</th>
					<th class="text-center">Modo</th>
					<th class="text-center">Nota</th>
					<th class="text-center">Estatus</th>
					<th class="text-right">Acciones</th>
				</tr>
			</thead>
			<tbody>
				@if($cursos->count()==0)
					<td colspan="7" class="text-center">No hay <strong>CVA</strong></td>
				@else
					@foreach($cursos as $curso)
					<tr>
						<td class="text-center">{{$curso->getNivel()}}</td>
						<td class="text-center">{{$curso->modulo}}</td>
						<td class="text-center">{{ucwords($curso->modo)}}</td>
						<td class="text-center">{{$curso->getNota()}}</td>
						<td class="text-center">
							@switch($curso->aval->estatus)
					    		@case('pendiente')
					    			<span class="label label-warning">pendiente</span>
					    		@break;
					    		
					    		@case( 'aceptada')
					    			<span class="label label-success">aceptada</span>
					    		@break

					    		@case ('negada')
					    			<span class="label label-danger">negada</span>
					    		@break
					    	@endswitch
						</td>
						
						<td>
							<a href="{{url($curso->aval->url)}}" target="_blank" class="btn btn-xs sisbeca-btn-primary" data-toggle="tooltip" data-placement="bottom" title="Ver Nota CVA">
								@if( $curso->aval->esImagen() )
	                        		<i class="fa fa-photo"></i>
	                        	@else
	                        		<i class="fa fa-file-pdf-o"></i>
	                        	@endif
							</a>

							<a href="{{route('cursos.editar',$curso->id)}}" class="btn btn-xs sisbeca-btn-primary" data-toggle="tooltip" data-placement="bottom" title="Editar CVA">
	                        	<i class="fa fa-pencil"></i>
							</a>

							@if($curso->aval->estatus!='aceptada')
								<span data-toggle="modal" data-target="#eliminarcurso{{$curso->id}}">
									<button type="button" class="btn btn-xs sisbeca-btn-default" data-toggle="tooltip" data-placement="bottom" title="Eliminar CVA"  >
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
					<tr>
						<td colspan="4" class="text-right">
							<strong>Promedio General</strong>
						</td>
						<td class="text-center">
							<strong>{{$becario->promediotodoscva()}}</strong>
						</td>
						<td colspan="2"></td>
					</tr>
				@endif
			</tbody>
		</table>
	</div>
	<hr>
	<p class="h6 text-right">{{ $cursos->count() }} cva(s) </p>
</div>

<!-- Modal para eliminar curso -->
@foreach($cursos as $curso)
<div class="modal fade" id="eliminarcurso{{$curso->id}}">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
		    	<h5 class="modal-title pull-left"><strong>Eliminar CVA</strong></h5>
		    	<a class="pull-right mr-1" href="javascript(0)" data-dismiss="modal" ><i class="fa fa-remove"></i></a>
		    </div>
			<div class="modal-body">
				<div class="col-lg-12">
					<br>
					<p class="h6 text-center">
						¿Está seguro que desea eliminar permanentemente el CVA <strong>{{$curso->getIdCurso()}}</strong>?
					</p>
				</div>
				
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-sm sisbeca-btn-default pull-right" data-dismiss="modal">No</button>
				<a href="{{route('cursos.eliminar',$curso->id)}}" class="btn btn-sm sisbeca-btn-primary pull-right">Si</a>
			</div>
		</div>
	</div>
</div>
@endforeach
<!-- Modal para eliminar curso -->

@endsection

@section('personaljs')
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>
@endsection
