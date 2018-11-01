@extends('sisbeca.layouts.main')
@section('title','Becarios Graduados')
@section('subtitle','Listar Becarios Graduados')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="fa fa-users fa-fw"></span>
                    Becarios Graduados

                </div>

                <div class="col-lg-12 table-responsive">
                    @if($becarios->count() > 0)
                        <table id="myTable" data-order='[[ 0, "asc" ]]' data-page-length='10' class="display" style="width:100%">
                            <thead>
                            <tr>
                                <th class="text-center">Nombre y Apellido</th>
                                <th class="text-center">Cedula</th>
                                <th class="text-center">E-mail</th>
                                <th class="text-center">Observacion</th>
                                <th class="text-center">Fecha Graduado</th>



                                <th class="text-center">Perfil</th>
                            </tr>
                            </thead>
                            <tbody >
                            @foreach($becarios as $becario)
                                <tr class="tr">
                                    <td class="text-center">{{ $becario->user->name.' '.$becario->user->last_name }}</td>
                                    <td class="text-center">{{ $becario->user->cedula }}</td>
                                    <td class="text-center">{{ $becario->user->email }}</td>
                                    <td class="text-center">{{ $becario->observacion_egresado }}</td>
                                    <td class="text-center">{{ date("d/m/Y", strtotime($nomina->fecha_egresado)) }}</td>





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
                        targets: [5], searchable: false,
                    }
                ]
            } );
        } );

        $('#myTable')
            .removeClass( 'display' )
            .addClass('table table-hover');
    </script>

@endsection
