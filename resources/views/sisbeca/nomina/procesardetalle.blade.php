@extends('sisbeca.layouts.main')
@section('title','Procesar Nómina')
@section('content')
<div class="col-lg-12">
    <strong>Procesar Nómina: {{ $mes.'/'.$anho }}</strong>
    <a href="{{route('nomina.procesar')}}" class="btn btn-sm sisbeca-btn-primary pull-right ">Atrás</a>
    

    <div class="table-responsive">

        <form class="form-horizontal" method="post" action ="{{ route('nomina.generar', array('mes'=>$mes, 'anho'=>$anho) ) }}">
            {{csrf_field()}}

            <!-- data-order='[[ 5, "asc" ],[2,"desc"],[0,"asc"]]'-->
            <table id="nomina"  class="table table-bordered table-hover" >
                <thead>
                    <tr>
                        <th class="text-center">Nombre y Apellido</th>
                        <th class="text-right">Retroactivo</th>
                        <th class="text-right">Libros</th>
                        <th class="text-right">Sueldo</th>
                        <th class="text-right" style="background-color: #eee;">Total a Pagar</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                 
                <tbody>
                    @if($nominas->count() > 0)
                        @foreach($nominas as $nomina)
                            <tr>
                                <td class="text-center"> {{ $nomina->becarios[0]->user->name.' '.$nomina->becarios[0]->user->last_name }} </td>
                                <td class="text-right">{{ number_format($nomina->retroactivo, 2, ',', '.') }}
                                </td>
                                <td class="text-right">{{ number_format($nomina->monto_libros, 2, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($nomina->sueldo_base, 2, ',', '.') }}</td>
                                <td class="text-right" style="background-color: rgba(113,113,113,0.1);">{{ number_format($nomina->total, 2, ',', '.') }}</td>
                                <td class="text-center">
                                    @if(\avaa\FactLibro::query()->where('status','=','por procesar')->where('becario_id','=',$nomina->becarios[0]->user->id)->get()->count()>0)
                                         <a href="{{ route('factlibros.verfacturas',array('id'=>$nomina->becarios[0]->user->id, 'mes'=>$mes, 'anho'=>$anho) ) }}" class="btn btn-xs sisbeca-btn-primary">Aprobar Facturas</a>
                                    @else
                                        <span class="label label-warning">no tiene facturas por aprobar</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <td class="text-center" colspan="6">No hay registros en esta<strong>nómina</strong>.</td>
                    @endif
                </tbody>
            </table>

        </div>
        <br>
        <br>
        <input class="btn btn-md sisbeca-btn-primary pull-right"  style="margin-left: 5px;" type="submit" value="Generar">
    </form>
   
</div>
@endsection
@section('personaljs')
<script>
    $(document).ready(function() {
        $('#nomina').DataTable({
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
