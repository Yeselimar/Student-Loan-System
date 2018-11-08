@extends('sisbeca.layouts.main')
@section('title','Todos los Postulantes a ProExcelencia')
@section('content')
<div class="col-12">
    <strong> Lista de todos los becarios</strong>

    <div class=" table-responsive">
    
        <form class="form-horizontal" method="post" action ="">
         {{csrf_field()}}
                           
            <table id="postulantes" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <!--  <th class="text-center">Revisado</th> -->
                        <th class="text-center">Nombre y Apellido</th>
                        <th class="text-center">Cédula</th>
                        <th class="text-center">Estatus</th>
                        <th class="text-center">Correo Electrónico</th>
                        <th class="text-center">Ver Postulación</th>

                    </tr>
                </thead>
                <tbody>
                @if($becarios->count() > 0)
                    @foreach($becarios as $becario)
                        @if($becario->status !='pre-postulante')
                            <tr>
                                <!--     @if(($becario->status=='entrevista')||($becario->status=='rechazado')) 
                                <td class="text-center"><a class="btn btn-success btn-xs"><span style="color:#26dad2;display:none">.</span> </td></a>
                                @else
                                <td class="text-center"><a class="btn btn-warning btn-xs"><span style="display:none">..</span> </td></a>
                                @endif -->
                                <td class="text-center">{{ $becario->user->name.' '.$becario->user->lastname }}</td>
                                <td class="text-center">{{ $becario->user->cedula }}</td>

                                @if($becario->status=='entrevista')                                        
                                    <td class="text-center">
                                        <span class="label label-success">A Entrevista</span>
                                    </td>
                                @elseif($becario->status=='rechazado')
                                <td class="text-center">
                                    <span class="label label-danger">Rechazado</span>
                                </td>
                                @else
                                <td class="text-center">
                                    <span class="label label-warning">Sin Revisar</span>
                                </td>
                                @endif

                                <td class="text-center">{{ $becario->user->email }}</td>

                                @if(($becario->status=='entrevista')||($becario->status=='rechazado'))
                                <td class="text-center">
                                    <a href="{{route('perfilPostulanteBecario', $becario->user_id)}}" class='btn btn-xs sisbeca-btn-primary' data-toggle="tooltip" data-placement="bottom" title="Ver Expediente" >
                                        <i class='fa fa-eye' ></i>
                                    </a>
                                </td>
                                @else
                                <td class="text-center">
                                    <a href="{{route('perfilPostulanteBecario', $becario->user_id)}}" class='btn btn-xs  sisbeca-btn-primary' data-toggle="tooltip" data-placement="bottom" title="Ver Expediente">
                                        <i class='fa fa-eye'></i>
                                    </a>
                                </td>
                                @endif
                            </tr>
                        @endif
                    @endforeach
                @else
                    <tr>
                        <td class="text-center" colspan="5">No hay <strong>postulantes a ProExcelencia</strong>.</td>
                    </tr>
                @endif
                </tbody>
            </table>

        </form>
        
    </div>

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
    $('#postulantes').DataTable({
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

    $( function() {
        $( "#datepicker" ).datepicker({ minDate: 0, maxDate: "+2M +10D",orientation: "bottom" });
    } );

/*
$('#select_all').change(function() {
    var checkboxes = $(this).closest('form').find(':checkbox');
    checkboxes.prop('checked', $(this).is(':checked'));
});
*/

</script>

@endsection
