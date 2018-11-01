@extends('sisbeca.layouts.main')
@section('title','Becarios')
@section('subtitle','Todos los Postulantes a ProExcelencia')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="fa fa-users fa-fw"></span> Lista de todos los becarios</div>


                <br/>
                <div class="col-lg-12 table-responsive">
                @if($becarios->count() > 0)
                    <form class="form-horizontal" method="post" action ="">
                     {{csrf_field()}}
                                       
                        <table id="myTable" data-order='[[ 0, "asc" ]]' data-page-length='10' class="display" style="width:100%">
                            <thead>
                            <tr>
                             <!--   <th class="text-center">Revisado</th> -->
                                <th class="text-center">Nombre y Apellido</th>
                                <th class="text-center">Cedula</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">E-mail</th>
                                <th class="text-center">Ver Postulación</th>

                            </tr>
                            </thead>
                            <tbody >
                            @foreach($becarios as $becario)
                       
                            @if($becario->status !='pre-postulante')
                                <tr class="tr">
                               <!--     @if(($becario->status=='entrevista')||($becario->status=='rechazado')) 
                                    <td class="text-center"><a class="btn btn-success btn-xs"><span style="color:#26dad2;display:none">.</span> </td></a>
                                    @else
                                    <td class="text-center"><a class="btn btn-warning btn-xs"><span style="display:none">..</span> </td></a>
                                    @endif -->
                                    <td class="text-center">{{ $becario->user->name.' '.$becario->user->lastname }}</td>
                                    <td class="text-center">{{ $becario->user->cedula }}</td>
                                    @if($becario->status=='entrevista')                                        
                                   <td class="text-center"><span class="label label-success"><strong> A Entrevista </strong></span></td>
                                    @elseif($becario->status=='rechazado')
                                    <td class="text-center"><span class="label label-danger"><strong>Rechazado</strong></span></td>
                                    @else
                                    <td class="text-center"><span class="label label-warning"><strong>Sin Revisar</strong></span></td>
                                    @endif
                                    <td class="text-center">{{ $becario->user->email }}</td>
                                    @if(($becario->status=='entrevista')||($becario->status=='rechazado'))
                                    <td class="text-center">
                                        <a href="{{route('perfilPostulanteBecario', $becario->user_id)}}" class='edit btn btn-warning' title="Ver Expediente" ><i class='fa fa-eye -square-o' ></i></a>
                                    </td>
                                    @else
                                    <td class="text-center">
                                        <a href="{{route('perfilPostulanteBecario', $becario->user_id)}}" class='edit btn btn-primary' title="Ver Expediente"><i class='fa fa-eye -square-o'></i></a>
                                    </td>
                                    @endif
                                </tr>
                                @endif
                            @endforeach
                            </tbody>
                        </table>

                        </form>
                    @else
                        <div class="alert  alert-warning alert-important" role="alert">
                            Actualmente no hay Postulantes a ProExcelencia...
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
            .addClass('table table-hover');

        $( function() {
            $( "#datepicker" ).datepicker({ minDate: 0, maxDate: "+2M +10D",orientation: "bottom" });
        } );

/*Checkbox all*/
        $('#select_all').change(function() {
    var checkboxes = $(this).closest('form').find(':checkbox');
    checkboxes.prop('checked', $(this).is(':checked'));
});


    </script>




@endsection
