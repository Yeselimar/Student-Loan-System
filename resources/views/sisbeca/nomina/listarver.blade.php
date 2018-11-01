@extends('sisbeca.layouts.main')
@section('title','Nómina')
@section('subtitle','Nómina Generadas')
@section('content')
    <div class="row">

        <div class="col-lg-12" style="padding-top: 15px; padding-bottom: 15px;">
            Nómina Generada: {{ $nominas[0]::getMes($mes).'/'.$anho }}
            <a href="{{ route('nomina.listar') }}" class="btn btn-sm btn-danger pull-right ">Atrás</a>
            <hr/>


        </div>

       
        {{csrf_field()}}
        <div class="col-lg-12 table-responsive">
            @if($nominas->count() > 0)
            <table id="myTable" data-order='[[ 0, "asc" ]]' data-page-length='10' class="display" style="width:100%">
                <thead>
                <tr>
                    <th class="text-center">Nombre y Apellido</th>
                    <th class="text-right">Retroactivo</th>
                    <th class="text-right">Libros</th>
                    <th class="text-right">Sueldo</th>
                    <th class="text-right" style="background-color: rgba(113,113,113,0.1);">Total</th>
                    <th class="text-center">F. Generada</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($nominas as $nomina)
                        <tr>
                            <td class="text-center"> {{ $nomina->datos_nombres.' '.$nomina->datos_apellidos}}</td>
                            <td class="text-right">{{ number_format($nomina->retroactivo, 2, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($nomina->monto_libros, 2, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($nomina->sueldo_base, 2, ',', '.')}}</td>
                            <td class="text-right" style="background-color: rgba(113,113,113,0.1);">{{ number_format($nomina->total, 2, ',', '.') }}</td>
                            <td class="text-center">{{ $nomina->getFechaGenerada() }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <hr/>

        @else
            <p class="text-center">No hay registros en esta<strong>nómina</strong>.</p>
        @endif

    	</div>
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
