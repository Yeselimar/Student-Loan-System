@extends('sisbeca.layouts.main')
@section('title','Cursos')
@section('content')
	<div class="col-lg-12">
		<div class="text-right">
			<a href="{{route('cursos.crear',Auth::user()->id)}}" class="btn btn-sm sisbeca-btn-primary">Añadir Curso</a>
		</div>
		<br>
		<div class="table-responsive" >
			<table class="table table-hover table-bordered">
				<thead>
					<tr>
						<th>Tipo Curso</th>
						<th>Modo</th>
						<th>Nivel</th>
						<th class="text-center">Módulo</th>
						<th class="text-center">Nota</th>
						<th class="text-center">Estatus</th>
						<th class="text-right">Acciones</th>
					</tr>
				</thead>
				<tbody>
					@if($cursos->count()==0)
						<td colspan="7" class="text-center">No hay <strong>cursos</strong></td>
					@else
						@foreach($cursos as $curso)
						<tr>
							<td>
								{{$curso->tipocurso->tipo}}
							</td>
							<td>{{$curso->modo}}</td>
							<td>{{$curso->nivel}}</td>
							<td class="text-center">{{$curso->modulo}}</td>
							<td class="text-center">{{$curso->nota}}</td>
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
								<a href="{{url($curso->aval->url)}}" target="_blank" class="btn btn-xs sisbeca-btn-primary" data-toggle="tooltip" data-placement="bottom" title="Ver Nota">
									@if( $curso->aval->esImagen() )
		                        		<i class="fa fa-photo"></i>
		                        	@else
		                        		<i class="fa fa-file-pdf-o"></i>
		                        	@endif
								</a>

								<a href="{{route('cursos.editar',$curso->id)}}" class="btn btn-xs sisbeca-btn-primary" data-toggle="tooltip" data-placement="bottom" title="Editar">
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
		<p class="h6 text-right">{{ $cursos->count() }} curso(s) </p>
	</div>
@endsection

@section('personaljs')
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>
@endsection
