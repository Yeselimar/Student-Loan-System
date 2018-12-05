@extends('sisbeca.layouts.main')
@section('title','Periodos')
@section('subtitle','Periodos')
@section('content')
	<div class="col-lg-12">
		<div class="text-right">
			<a href="{{route('periodos.crear',Auth::user()->id)}}" class="btn btn-sm sisbeca-btn-primary">Crear Periodo</a>
		</div>
		<br>
		<div class="table-responsive">
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>Año Lectivo</th>
						<th>Número Periodo</th>
						<th class="text-center">Nro Materias</th>
						<th class="text-center">Promedio</th>
						<th class="text-center">Estatus</th>
						<th class="text-right">Acciones</th>
					</tr>
				</thead>
				<tbody>
					@if($periodos->count()==0)
						<td colspan="6" class="text-center">No hay <strong>periodos</strong></td>
					@else
						@foreach($periodos as $periodo)
						<tr>
							<td>
								{{$periodo->anho_lectivo}}
							</td>
							<td>{{$periodo->getNumeroPeriodo()}}</td>
							<td class="text-center">{{$periodo->getTotalMaterias()}} materia(s)</td>
							<td class="text-center">{{$periodo->getPromedio()}}</td>
							<td class="text-center">
								@switch($periodo->aval->estatus)
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
								<a href="{{url($periodo->aval->url)}}" target="_blank" class="btn btn-xs sisbeca-btn-primary" data-toggle="tooltip" data-placement="bottom" title="Ver Constancia">
									@if( $periodo->aval->esImagen() )
		                        		<i class="fa fa-photo"></i>
		                        	@else
		                        		<i class="fa fa-file-pdf-o"></i>
		                        	@endif
								</a>

								<a href="{{route('materias.mostrar',$periodo->id)}}" class="btn btn-xs sisbeca-btn-primary" data-toggle="tooltip" data-placement="bottom" title="Ver Materias">
									<i class="fa fa-search"></i>
								</a>

								<a href="{{route('periodos.editar',$periodo->id)}}" class="btn btn-xs sisbeca-btn-primary" data-toggle="tooltip" data-placement="bottom" title="Editar">
									<i class="fa fa-pencil"></i>
								</a>

								@if($periodo->aval->estatus!='aceptada')
									<span data-toggle="modal" data-target="#eliminarperiodo{{$periodo->id}}">
										<button type="button" class="btn btn-xs sisbeca-btn-default" data-toggle="tooltip" data-placement="bottom" title="Eliminar"  >
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
							<td colspan="3" class="text-right">
								<strong>Promedio General</strong>
							</td>
							<td class="text-center">
								<strong>{{$becario->promediotodosperiodos()}}</strong>
							</td>
							<td colspan="2"></td>
						</tr>
					@endif
				</tbody>
			</table>
		</div>
		<hr>
		<p class="h6 text-right">{{ $periodos->count() }} periodo(s) </p>
	</div>

	<!-- Modal para eliminar periodo -->
	@foreach($periodos as $periodo)
	<div class="modal fade" id="eliminarperiodo{{$periodo->id}}">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
			    	<h5 class="modal-title"><strong>Eliminar Periodo</strong></h5>
			    </div>
				<div class="modal-body">
					<div class="col-lg-12">
						<br>
						<p class="h6 text-center">
							¿Está seguro que desea eliminar permanentemente el periodo <strong>{{$periodo->getNumeroPeriodo()}}</strong> del año lectivo <strong>{{$periodo->anho_lectivo}}</strong>?
						</p>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm sisbeca-btn-default pull-right" data-dismiss="modal">No</button>
					<a href="{{route('periodos.eliminar',$periodo->id)}}" class="btn btn-sm sisbeca-btn-primary pull-right">Si</a>
				</div>
			</div>
		</div>
	</div>
	@endforeach
	<!-- Modal para eliminar periodo -->
@endsection

@section('personaljs')
    <script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip(); 
    });
    </script>
@endsection
