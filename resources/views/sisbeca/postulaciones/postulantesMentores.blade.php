@extends('sisbeca.layouts.main')
@section('title','Mentores')
@section('subtitle','Postulaciones a Mentor')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="fa fa-male fa-fw"></span> Postulantes a Mentor</div>

                <div class="col-lg-12 table-responsive">

              @if($users->count()>0)
                    <table id="myTable" data-order='[[ 0, "asc" ]]' data-page-length='10' class="display" style="width:100%">
                        <thead>
                        <tr>
                            <th class="text-center">Nombre y Apellido</th>
                            <th class="text-center">Cedula</th>
                            <th class="text-center">E-mail</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">Procesar</th>
                        </tr>
                        </thead>
                        <tbody >

                            @foreach($users as $user)
                                <tr class="tr">
                                    <td class="text-center">{{ $user->name.' '.$user->last_name }}</td>
                                    <td class="text-center">{{ $user->cedula }}</td>
                                    <td class="text-center">{{ $user->email }}</td>
                                     @if($user->rol=='rechazado')                                        
                                  
                                    <td class="text-center"><span class="label label-light-danger"><strong>Rechazado</strong></span></td>
                                    @else
                                    <td class="text-center"><span class="label label-light-warning"><strong>Sin Revisar</strong></span></td>
                                    @endif                                

                                    <td class="text-center">
                                        <a href="{{route('perfilPostulantesMentores', $user->id)}}" class='edit btn btn-primary' title="Ver Postulación"><i class='fa fa-eye -square-o'></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                  @else
                  <br/><br/>
                  @endif
               
                  <button type="button" onclick="finalizarConcurso()"  class="btn btn-md btn-warning pull-left"  style="margin-right: 5px;" >Finalizar Concurso</button>
                  
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
                    { targets: [3], searchable: false}
                ]
            } );
        } );

        $('#myTable')
            .removeClass( 'display' )
            .addClass('table table-hover');


         function finalizarConcurso() {

            var route= "#";


            $.ajax({
                url: route,
                beforeSend: function() {
                    $('.preloader').show();
                },
                complete: function(){
                    location.assign( "{{route('finalizarConcursoMentor')}}");
                }
            });

        }   
    </script>

@endsection
