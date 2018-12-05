@extends('sisbeca.layouts.main')
@section('title','Todos los becarios')
@section('content')
<div class="col-lg-12" id="app">
	<div class="text-right">
		<a href="{{route('becarios.todos')}}" class="btn btn-sm sisbeca-btn-primary">Listar Becarios</a>
	</div>
	<br>
	<div class="table-responsive">
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>Becario</th>
					<th>Rol</th>
					<th>Estatus</th>
					<th class="text-right">Acciones</th>
				</tr>
			</thead>
			<tbody>
				@foreach($becarios as $becario)
					<tr>
						<td>{{$becario->user_id}}</td>
						<td>{{$becario->user->nombreyapellido()}}</td>
						<td>{{$becario->user->rol}}</td>
						<td>{{$becario->status}}</td>
						<td>
							<a href="{{route('periodos.crear',$becario->user_id)}}" class="btn btn-xs sisbeca-btn-primary">Cargar Periodo</a>
							<a href="{{route('cursos.crear',$becario->user_id)}}" class="btn btn-xs sisbeca-btn-primary">Cargar CVA</a>
							<a href="{{route('voluntariados.crear',$becario->user_id)}}" class="btn btn-xs sisbeca-btn-primary">Cargar Voluntariado</a>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
</div>

@endsection