@extends('sisbeca.layouts.main')
@section('title','Solicitudes/Reclamos')
@section('subtitle','Listar Solicitudes')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="fa fa-users fa-fw"></span> Solicitudes</div>

                <div class="col-lg-12 table-responsive">
                    @if($solicitudes->count() > 0)
                        <table id="myTable" data-order='[[ 4, "desc" ]]' data-page-length='10' class="display" style="width:100%">
                            <thead>
                            <tr>
                                <th class="text-center">Tipo</th>
                                <th class="text-center">Status proceso</th>
                                <th class="text-center">Solicitada Por</th>
                                <th class="text-center">Usuario Respuesta</th>
                                <th class="text-center">Fecha Solicitud</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                            </thead>
                            <tbody >
                            @foreach($solicitudes as $solicitud)
                                <tr class="tr">
                                    <td class="text-center">{{strtoupper( $solicitud->titulo )}}</td>
                                    @if($solicitud->status==='aceptada')
                                        <td class="text-center"><span class="label label-light-success"><strong>{{strtoupper( $solicitud->status )}}</strong></span></td>
                                    @else
                                        @if($solicitud->status==='enviada')
                                            <td class="text-center"><span class="label label-light-warning"><strong>POR PROCESAR</strong></span></td>
                                        @else
                                            <td class="text-center"><span class="label label-light-danger"><strong>{{strtoupper( $solicitud->status )}}</strong></span></td>
                                        @endif
                                    @endif
                                    <td class="text-center">{{ $solicitud->user->name.' '.$solicitud->user->last_name}}<br/> Rol: {{ucwords($solicitud->user->rol)}}<br/>Cedula: {{$solicitud->user->cedula}} <br/>Email:<strong>({{ $solicitud->user->email}})</strong></td>


                                   @if(\avaa\User::find($solicitud->usuario_respuesta))
                                    <td class="text-center">{{ \avaa\User::find($solicitud->usuario_respuesta)->name}} <br> <strong>({{\avaa\User::find($solicitud->usuario_respuesta)->email}})</strong></td>
                                   @else
                                        <td class="text-center"><span class="label label-light-warning">Información no Encontrada</span></td>
                                    @endif

                                    <td class="text-center">{{ date("d/m/Y h:i:sA", strtotime($solicitud->updated_at)) }}</td>


                                    <td class="text-center">
                                        <a href="{{route('solicitud.revisar',$solicitud->id)}}" class='edit btn btn-primary' title="Revisar Solicitud"><i class='fa fa-eye -square-o'></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert  alert-warning alert-important" role="alert">
                            Actualmente no tiene registrada ninguna solicitud!!
                        </div>
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
                    { targets: [5], searchable: false}
                ]
            } );
        } );

        $('#myTable')
            .removeClass( 'display' )
            .addClass('table table-hover');
    </script>

@endsection
