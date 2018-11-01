@extends('sisbeca.layouts.main')
@section('title','Mentores')
@section('subtitle','Listar Mentores')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="fa fa-male fa-fw"></span> Mentores</div>

                <div class="col-lg-12 table-responsive">

              @if($mentores->count()>0)
                    <table id="myTable" data-order='[[ 0, "asc" ]]' data-page-length='10' class="display" style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-center">Nombre y Apellido</th>
                            <th class="text-center">Cedula</th>
                            <th class="text-center">E-mail</th>
                            <th class="text-center">Becario(s) Asignado(s)</th>
                            <th class="text-center">Perfil</th>
                        </tr>
                        </thead>
                        <tbody >

                            @foreach($mentores as $mentor)
                                <tr class="tr">
                                    <td class="text-center">{{ $mentor->user->name.' '.$mentor->user->last_name }}</td>
                                    <td class="text-center">{{ $mentor->user->cedula }}</td>
                                    <td class="text-center">{{ $mentor->user->email }}</td>


                                    @if($mentor->becarios->count()>0)
                                        <td class="text-center">

                                                @foreach($mentor->becarios as $becario)

                                                   <span class="label label-light-success"><strong>{{$becario->user->name.' '.$becario->user->last_name}}</strong></span>,
                                                  @endforeach

                                        </td>
                                    @else
                                        <td class="text-center"><span class="label label-light-danger"><strong>SIN ASIGNAR</strong></span></td>
                                    @endif

                                    <td class="text-center">
                                        <a href="{{ route('ver.perfilMentor',$mentor->user_id) }}" class='edit btn btn-primary' title="Ver Perfil"><i class='fa fa-eye -square-o'></i></a>
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
    </div>
@endsection

@section('personaljs')
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable( {
                columnDefs: [
                    { targets: [4], searchable: false}
                ]
            } );
        } );

        $('#myTable')
            .removeClass( 'display' )
            .addClass('table table-hover');
    </script>

@endsection
