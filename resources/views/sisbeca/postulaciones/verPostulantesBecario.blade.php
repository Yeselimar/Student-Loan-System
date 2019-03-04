@extends('sisbeca.layouts.main')
@section('title','Todos los Postulantes a ProExcelencia')
@section('content')
<div class="col-12">
    <div class=" table-responsive">
        <form class="form-horizontal" method="post" action ="">
            {{csrf_field()}}
            <table id="postulantes" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th class="text-center">Estatus</th>
                        <th class="text-center">Nombre y Apellido</th>
                        <th class="text-center">Cédula</th>
                        <th class="text-center">Teléfono</th>
                        <th class="text-center">P. Bachiller</th>
                        <th class="text-center">Ver Perfil</th>
                    </tr>
                </thead>
                <tbody>
                @if($becarios->count() > 0)
                    @foreach($becarios as $becario)
                        @if($becario->status !='pre-postulante')
                            <tr>
                                @if($becario->status=='entrevista')
                                <td class="text-center">
                                    <span class="label label-inverse">Por entrevistar</span>
                                </td>
                                @elseif($becario->status=='rechazado' && $becario->fecha_entrevista==NULL)
                                <td class="text-center">
                                    <span class="label label-danger">Rechazado</span>
                                </td>
                                @elseif($becario->status=='rechazado' && $becario->fecha_entrevista!=NULL)
                                <td class="text-center">
                                    <span class="label label-danger">E.Rechazada</span>
                                </td>
                                @elseif($becario->status=='activo')
                                <td class="text-center">
                                    <span class="label label-success">Aprobado</span>
                                </td>
                                @elseif($becario->status=='entrevistado')
                                <td class="text-center">
                                    <span class="label label-success">E.Aprobada</span>
                                </td>
                                @else
                                <td class="text-center">
                                    <span class="label label-default">Sin Revisar</span>
                                </td>
                                @endif
                                <td class="text-center">{{ $becario->user->name.' '.$becario->user->last_name }}</td>
                                <td class="text-center">{{ $becario->user->cedula }}</td>
                                <td class="text-center">{{ $becario->celular }}</td>
                                <td class="text-center">{{ $becario->promedio_bachillerato }}</td>
                                <td class="text-center">
                                    <a href="{{route('perfilPostulanteBecario', $becario->user_id)}}" class='btn btn-xs sisbeca-btn-primary' data-toggle="popover" data-trigger="hover" data-content="Ver Perfil" data-placement="left" >
                                        <i class='fa fa-eye' ></i>
                                    </a>
                                </td>
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
    <br>
    <div class="alert  alert-success alert-important" role="alert">
    <a class="label label-success letras-blancas">E.Aprobada</a> Postulantes que Aprobaron la Entrevista.
    </div>
    <div class="alert  alert-success alert-important" role="alert">
    <a class="label label-success letras-blancas">Aprobado</a> Postulantes que fueron Aprobados como becario y aún no han iniciado actividades.
    </div>
    <div class="alert  alert-danger alert-important" role="alert">
       <a class="label label-danger letras-blancas">E.Rechazada</a> Postulantes que fueron rechazados en el proceso de Entrevista.
    </div>
    <div class="alert  alert-danger alert-important" role="alert">
    <a class="label label-danger letras-blancas">Rechazado</a> Postulantes que fueron Rechazados para ir a la Entrevista.
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
</script>
<script>
$(document).ready(function(){
$('[data-toggle="popover"]').popover();
});
</script>
@endsection
