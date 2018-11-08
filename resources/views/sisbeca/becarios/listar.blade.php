@extends('sisbeca.layouts.main')
@if(!(Auth::user()->rol==='mentor'))
	@section('title','Becarios')
@else
	@section('title','Becarios Asignados')
@endif
@section('content')

<div class="col-lg-12">
	@if(!(Auth::user()->rol==='mentor'))
		Becarios
		@else
		Becarios Asignados
	@endif

	<div class="table-responsive">
		@if($becarios->count() > 0)
		<table id="becarios" class="table table-bordered table-hover">
			<thead>
				<tr>
					<th class="text-center">Nombre y Apellido</th>
					<th class="text-center">Cédula</th>
					<th class="text-center">Correo electrónico</th>
					<th class="text-center">Condición Actual</th>
					@if(!(Auth::user()->rol==='mentor'))
						<th class="text-center">Mentor Asignado</th>
						<th class="text-center">Correo del Mentor</th>
					@endif
					<th class="text-center">Perfil</th>
				</tr>
			</thead>
			<tbody>
				@foreach($becarios as $becario)
				<tr>
					<td class="text-center">{{ $becario->user->name.' '.$becario->user->last_name }}</td>
					<td class="text-center">{{ $becario->user->cedula }}</td>
					<td class="text-center">{{ $becario->user->email }}</td>
					@if($becario->status==='activo')
						<td class="text-center">
							<span class="label label-success">{{strtoupper( $becario->status )}}</span>
						</td>
						@else
							@if($becario->status==='probatorio1')
								<td class="text-center">
									<span class="label label-warning">{{strtoupper( $becario->status )}}</span>
								</td>
							@else
								<td class="text-center">
									<span class="label label-danger">{{strtoupper( $becario->status )}}</span>
								</td>
							@endif
					@endif
					@if(!(Auth::user()->rol==='mentor'))
						@if($becario->mentor_id===null)
							<td class="text-center">
								<span class="label label-danger">sin asignar</span>
							</td>
							<td class="text-center"></td>
						@else
							<td class="text-center">
								{{ $becario->mentor->user->name.' '.$becario->mentor->user->last_name }}
							</td>
							<td class="text-center">{{ $becario->mentor->user->email }}</td>
						@endif
					@endif

					<td class="text-center">
						<span data-toggle="modal" data-placement="bottom" title="Ver Expediente">
							<a href="{{route('postulanteObecario.perfil',$becario->user_id)}}" class='btn btn-xs sisbeca-btn-primary'>
								<i class='fa fa-eye'></i>
							</a>
						</span>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@endif
	</div>

</div>
@endsection

@section('personaljs')

<script>
$(document).ready(function(){
    $('#becarios').DataTable({
        "ordering": true,

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
</script>

 
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>

@endsection
