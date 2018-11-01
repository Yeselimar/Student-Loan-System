@extends('sisbeca.layouts.main')
@section('title','Nómina')
@section('subtitle','Procesar Nómina')
@section('content')
    <div class="row">

        <div class="col-lg-12" style="padding-top: 15px; padding-bottom: 15px;">
            Procesar Nómina: {{ $mes.'/'.$anho }}
            <a href="{{route('nomina.procesar')}}" class="btn btn-sm btn-danger pull-right ">Atrás</a>
            <hr/>


        </div>

        <div class="col-lg-12 table-responsive">
        <form class="form-horizontal" method="post" action ="{{ route('nomina.generar', array('mes'=>$mes, 'anho'=>$anho) ) }}">
        {{csrf_field()}}

            @if($nominas->count() > 0)
            <table id="myTable" data-order='[[ 5, "asc" ],[2,"desc"],[0,"asc"]]' data-page-length='10' class="display" style="width:100%">
                <thead>
                <tr>
                    <th class="text-center">Nombre y Apellido</th>
                    <th class="text-right">Retroactivo</th>
                    <th class="text-right">Libros</th>
                    <th class="text-right">Sueldo</th>
                    <th class="text-right" style="background-color: rgba(113,113,113,0.1);">Total a Pagar</th>
                    <th class="text-center">Acciones</th>
                </tr>
                </thead>
                <tbody>
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
                                     <a href="{{ route('factlibros.verfacturas',array('id'=>$nomina->becarios[0]->user->id, 'mes'=>$mes, 'anho'=>$anho) ) }}" class="btn btn-xs btn-success">Aprobar Facturas</a>
                                @else
                                <span class="label label-light-warning"><strong>No Tiene Facturas por aprobar</strong></span>

                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>



            <input class="btn btn-md btn-primary pull-right"  style="margin-left: 5px;" type="submit" value="Generar">
        </form>
        </div>
        @else
            <p class="text-center">No hay registros en esta<strong>nómina</strong>.</p>
        @endif

    	</div>
	@endsection
@section('personaljs')
    <script type="text/javascript" charset="utf-8">
        $(document).ready(function() {
            $('#myTable').DataTable();



        } );

        $('#myTable')
            .removeClass( 'display' )
            .addClass('table table-hover');
    </script>
@endsection
