@extends('sisbeca.layouts.main')
@section('title','Solicitudes/Reclamos')
@section('content')
<div class="col-lg-12">
    <div class="table-responsive">

        <table class="table table-bordered table-hover" id="solicitudes" style="border: 1px solid #eee">
            <thead>
                <tr>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Estatus <br> proceso</th>
                    <th class="text-center">Solicitada <br> Por</th>
                    <th class="text-center">Usuario <br> Respuesta</th>
                    <th class="text-center">Fecha <br> Solicitud</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if($solicitudes->count() > 0)
                @foreach($solicitudes as $solicitud)
                    <tr>
                        <td class="text-center">{{strtoupper( $solicitud->titulo )}}</td>
                        @if($solicitud->status==='aceptada')
                            <td class="text-center">
                                <span class="label label-success">{{strtoupper( $solicitud->status )}}
                                </span>
                            </td>
                        @else
                            @if($solicitud->status==='enviada')
                                <td class="text-center">
                                    <span class="label label-warning">POR PROCESAR</span>
                                </td>
                            @else
                                <td class="text-center">
                                    <span class="label label-danger">
                                        {{strtoupper( $solicitud->status )}}
                                    </span>
                                </td>
                            @endif
                        @endif
                        <td class="text-center">
                            {{ $solicitud->user->name.' '.$solicitud->user->last_name}}<br/> Rol: {{ucwords($solicitud->user->rol)}}
                            <br/>
                            Cedula: {{$solicitud->user->cedula}}
                            <br/>Email:({{ $solicitud->user->email}})
                        </td>


                    @if(\avaa\User::find($solicitud->usuario_respuesta))
                        <td class="text-center">
                            {{ \avaa\User::find($solicitud->usuario_respuesta)->name}}
                            <br> ({{\avaa\User::find($solicitud->usuario_respuesta)->email}})
                        </td>
                    @else
                            <td class="text-center">
                                <span class="label label-warning">-</span>
                            </td>
                        @endif

                        <td class="text-center" data-order="{{date('d/m/Y H:i:s', strtotime($solicitud->created_at))}}">
                            {{ date("d/m/Y h:i a", strtotime($solicitud->created_at)) }}
                        </td>

                        <td class="text-center">
                            <a href="{{route('solicitud.revisar',$solicitud->id)}}" class='btn btn-xs sisbeca-btn-primary'><i class='fa fa-eye'></i></a>
                        </td>
                    </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="6" class="text-center">No hay <strong>solicitudes</strong></td>
                </tr>
                @endif
            </tbody>
        </table>

    </div>
</div>
@endsection

@section('personaljs')
<!--
<script>
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
-->

<script>
$(document).ready(function(){
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
                "next": '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                "previous": '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
            }
        },
        "order": [[ 4, 'desc' ]],
    });
});
</script>
@endsection
