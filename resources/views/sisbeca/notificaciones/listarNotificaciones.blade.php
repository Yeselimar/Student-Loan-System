@extends('sisbeca.layouts.main')
@section('title','Notificaciones')
@section('subtitle','Todas las notificaciones')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="fa fa-bell fa-fw"></span> Notificaciones</div>

                <div class="col-lg-12 table-responsive">
                    @if($notificaciones->count() > 0)
                        <table id="myTable" data-order='[[ 2, "desc" ]]' data-page-length='10' class="display" style="width:100%">
                            <thead>
                            <tr>
                                <th class="text-right" style="width: 50px!important;display: none;">Imagen</th>
                                <th class="text-left" style="display: none;">Descripcion</th>
                                <th class="text-center" style="display: none;">Fecha</th>
                            </tr>
                            </thead>
                            <tbody >
                            @foreach($notificaciones as $alerta)
                                <tr class="tr">
                                    @if(Auth::user()->rol==='coordinador')
                                    <td class="text-right" style="width: 50px!important;"><a href="{{route('solicitud.revisar',$alerta->solicitud)}}"> <div class="btn btn-danger btn-circle m-r-10"><i class="ti-user"></i></div></a></td>

                                    <td class="text-left" style="font-size: 16px;font-weight: bold"><a style="color: #3d91d6;" href="{{route('solicitud.revisar',$alerta->solicitud)}}">{{$alerta->descripcion}}</a></td>
                                    @else
                                        @if(Auth::user()->rol==='becario'||Auth::user()->rol==='mentor')
                                        <td class="text-right" style="width: 50px!important;">
                                                <a href="
                               @if(is_null($alerta->solicitud))
                                                @if(Auth::user()->rol==='becario')
                                                {{route('ver.mentorAsignado')}}
                                                @else
                                                {{route('listar.becariosAsignados')}}
                                                @endif
                                                @else
                                                {{route('solicitud.edit',$alerta->solicitud)}}
                                                @endif
                                                        "
                                                >
                                                <div class="btn btn-danger btn-circle m-r-10"><i class="ti-user"></i></div></a></td>

                                        <td class="text-left" style="font-size: 16px;font-weight: bold">
                                            <a style="color: #3d91d6;"

                                               href="
                                               @if(is_null($alerta->solicitud))
                                                               @if(Auth::user()->rol==='becario')
                                                               {{route('ver.mentorAsignado')}}
                                                               @else
                                                               {{route('listar.becariosAsignados')}}
                                                               @endif
                                                               @else
                                                               {{route('solicitud.edit',$alerta->solicitud)}}
                                                               @endif
                                                                       "
                                            >

                                                {{$alerta->descripcion}}


                                            </a></td>
                                        @else
                                            @if(Auth::user()->rol==='directivo')
                                                <td class="text-right" style="width: 50px!important;"><a href="{{route('nomina.procesar')}}"> <div class="btn btn-danger btn-circle m-r-10"><i class="ti-user"></i></div></a></td>

                                                <td class="text-left" style="font-size: 16px;font-weight: bold"><a style="color: #3d91d6;" href="{{route('nomina.procesar')}}">{{$alerta->descripcion}}</a></td>

                                            @else
                                            <td class="text-right" style="width: 50px!important;"><a href="javascript:void(0)"> <div class="btn btn-danger btn-circle m-r-10"><i class="ti-user"></i></div></a></td>

                                            <td class="text-left" style="font-size: 16px;font-weight: bold"><a style="color: #3d91d6;" href="javascript:void(0)">{{$alerta->descripcion}}</a></td>
                                                @endif
                                        @endif
                                    @endif

                                        <td class="text-left" style="font-size: 16px;font-weight: bold"><strong>
                                        {{ date("d/m/Y", strtotime($alerta->created_at)) }}

                                        </strong></td>

                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert  alert-warning alert-important" role="alert">
                            Actualmente no tiene registrada ninguna notificación!!
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
                    { targets: [0], searchable: false}
                ]
            } );
        } );

        $('#myTable')
            .removeClass( 'display' )
            .addClass('');
    </script>

@endsection
