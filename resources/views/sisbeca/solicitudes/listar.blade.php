@extends('sisbeca.layouts.main')
@section('title','Listar Solicitudes')
@section('content')

<div class="col-lg-12">
    <div class="text-right">
        <a href="{{ route('solicitud.crear') }}" class="btn btn-sm sisbeca-btn-primary">Crear solicitud</a>
    </div>
    <table class="table table-bordered table-hover" id="solicitudes">
        <thead>
            <tr>
            <th class="text-center">Tipo</th>
            <th class="text-center">Estatus Actual</th>
            <th class="text-center">Fecha Enviada</th>
            <th class="text-center">Acciones</th>
            </tr>
        </thead>
        <tbody >
            @if($solicitudes->count()>0)
                @foreach($solicitudes as $solicitud)
                <tr>
                    <td class="text-center">{{strtoupper( $solicitud->titulo) }}</td>

                    @if($solicitud->status==='enviada')
                        <td class="text-center">
                            <span class="label label-warning">{{ $solicitud->status }}</span>
                        </td>
                    @else
                        @if($solicitud->status==='aceptada')
                            <td class="text-center">
                                <span class="label label-success">{{ $solicitud->status }}</span>
                            </td>
                        @else
                            <td class="text-center">
                                <span class="label label-danger">{{ $solicitud->status }}</span>
                            </td>
                        @endif
                    @endif

                    <td class="text-center">{{ $solicitud->fechaActualizacion() }}</td>

                    <td class="text-center">
                        <a href="{{route('solicitud.edit',$solicitud->id)}}" class='btn btn-xs sisbeca-btn-primary' data-toggle="tooltip" data-placement="bottom" title="Ver Solicitud"><i class='fa fa-eye'></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            @else
            <tr>
                <td class="text-center" colspan="4">No hay <strong>solicitudes</strong> registradas</td>
            </tr>
            @endif
        </tbody>
    </table>

</div>

@endsection

@section('personaljs')
<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>

<script>
$(document).ready(function() {
    $('#solicitudes').DataTable({

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

@endsection