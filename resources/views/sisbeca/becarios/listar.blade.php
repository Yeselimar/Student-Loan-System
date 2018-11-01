@extends('sisbeca.layouts.main')
@if(!(Auth::user()->rol==='mentor'))
	@section('title','Becarios')
	@section('subtitle','Listar Becarios')
@else
	@section('title','Becarios Asignados')
	@section('subtitle','Listar Becarios Asignados')
	@endif
@section('content')

	<div class="row">
		<div class="col-12">
			<div class="panel panel-default">
				<div class="panel-heading"><span class="fa fa-users fa-fw"></span>
					@if(!(Auth::user()->rol==='mentor'))
						Becarios
						@else
						Becarios Asignados
					@endif
				</div>

					<div class="col-lg-12 table-responsive">
						@if($becarios->count() > 0)
						<table id="myTable" data-order='[[ 0, "asc" ]]' data-page-length='10' class="display" style="width:100%">
							<thead>
								<tr>
									<th class="text-center">Nombre y Apellido</th>
									<th class="text-center">Cedula</th>
									<th class="text-center">E-mail</th>
									<th class="text-center">Condicion Actual</th>
									@if(!(Auth::user()->rol==='mentor'))
										<th class="text-center">Mentor Asignado</th>
										<th class="text-center">E-mail del Mentor</th>
									@endif
									<th class="text-center">Perfil</th>
								</tr>
							</thead>
							<tbody >
								@foreach($becarios as $becario)
								<tr class="tr">
									<td class="text-center">{{ $becario->user->name.' '.$becario->user->last_name }}</td>
									<td class="text-center">{{ $becario->user->cedula }}</td>
									<td class="text-center">{{ $becario->user->email }}</td>
									@if($becario->status==='activo')
										<td class="text-center"><span class="label label-light-success"><strong>{{strtoupper( $becario->status )}}</strong></span></td>
										@else
											@if($becario->status==='probatorio1')
												<td class="text-center"><span class="label label-light-warning"><strong>{{strtoupper( $becario->status )}}</strong></span></td>
											@else
												<td class="text-center"><span class="label label-light-danger"><strong>{{strtoupper( $becario->status )}}</strong></span></td>
											@endif
									@endif
									@if(!(Auth::user()->rol==='mentor'))
									@if($becario->mentor_id===null)
										<td class="text-center"><span class="label label-light-danger"><strong>SIN ASIGNAR</strong></span></td>
										<td class="text-center" ></td>
									@else
										<td class="text-center">{{ $becario->mentor->user->name.' '.$becario->mentor->user->last_name }}</td>
										<td class="text-center">{{ $becario->mentor->user->email }}</td>
									@endif
									@endif

									<td class="text-center">
										<a href="{{route('postulanteObecario.perfil',$becario->user_id)}}" class='edit btn btn-primary' title="Ver Expediente"><i class='fa fa-eye -square-o'></i></a>
									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
					@else
								<br/><br/>
					@endif
					</div>

				</div>
		</div>
	</div>
@endsection

@section('personaljs')
<script>
    $(document).ready(function() {
        $('#myTable').DataTable( {
            columnDefs: [
                {
					@if(!(Auth::user()->rol==='mentor'))
                    	targets: [6], searchable: false,
					@else
                   		 targets: [4], searchable: false,
					@endif


                }
            ]
        } );
    } );

    $('#myTable')
        .removeClass( 'display' )
        .addClass('table table-hover');
</script>

@endsection
