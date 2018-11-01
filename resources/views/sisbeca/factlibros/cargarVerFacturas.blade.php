@extends('sisbeca.layouts.main')
@section('title','Cargar Factura')
@section('subtitle','Cargar Facturas')
@section('content')

<div class="col-lg-12">
    <div class="panel-group Material-default-accordion" id="Material-accordion" role="tablist" aria-multiselectable="true">

        <div class="panel panel-default-accordion mb-3">
            <div class="panel-accordion" role="tab" id="heading">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#Material-accordion" href="#collapse" aria-expanded="false" aria-controls="collapse">
                        Subir Nueva Factura
                    </a>
                </h4>
            </div>
            <div id="collapse" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading">
                <div align="justify" class="panel-body">
                    <form class="form-horizontal" enctype="multipart/form-data" accept-charset="UTF-8" method="POST" action="{{route('facturas.store')}}">

                        {{csrf_field()}}

                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <label class="control-label" for="name">Nombre</label>
                                    <input class="sisbeca-input" type="text" name="name" id="name" placeholder="Ingrese el Nombre del Libro" value="{{old('name')}}" required>
                                </div>


                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <label class="control-label" for="curso">Curso</label>
                                    <input class="sisbeca-input" type="text" name="curso" id="curso" placeholder="Ingrese el Nombre del Curso" value="{{old('curso')}}" required>
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <label class="control-label" for="costo">Costo</label>
                                    <input class="sisbeca-input" type="text" onkeypress="handleNumber(event, '{20,2}')" placeholder="Ingrese el Costo del Libro" size=23 value="{{number_format(old('costo'), 2, ',', '.')}}"  name="costo" required id="costo" >
                                </div>

                                <div class="col-lg-4 col-md-4 col-sm-6">
                                    <label class="control-label" for="url_factura" >Factura(PDF)</label>
                                    <input class="sisbeca-input" name="url_factura" accept="application/pdf" type="file" id="url_factura" required>
                                </div>
                            </div>
                        </div>

                        <hr>    

                        <div class="form-group">
                            <div class="row">
                                <div class="col-lg-12 text-right" >
                                    <button type="submit" class="btn sisbeca-btn-primary">
                                        Cargar Factura
                                    </button>
                                </div>
                            </div>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    </div>

    <div class="panel-group Material-default-accordion" id="Material-accordion3" role="tablist" aria-multiselectable="true">

        <div class="panel panel-default-accordion mb-3">
            <div class="panel-accordion" role="tab" id="heading2">
                <h4 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#Material-accordion3" href="#collapse2" aria-expanded="false" aria-controls="collapse2">
                        Listar Facturas
                    </a>
                </h4>
            </div>
            <div id="collapse2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading2">
                <div align="justify" class="panel-body">


                    @if($facturas->count()>0)
                        <table id="myTable" data-order='[[ 4, "desc" ]]' data-page-length='10' class="display" style="width:100%">
                            <thead>
                            <tr>
                                <th class="text-center">Nombre</th>
                                <th class="text-center">Curso</th>
                                <th class="text-center">Costo</th>
                                <th class="text-center">Status Actual</th>
                                <th class="text-center">Fecha Registro</th>
                                <th class="text-center">Revisar</th>
                            </tr>
                            </thead>
                            <tbody >
                            @foreach($facturas as $factura)
                                <tr>
                                    <td class="text-center">{{$factura->name }}</td>

                                    <td class="text-center">{{ $factura->curso }}</td>

                                    <td class="text-center">{{number_format($factura->costo, 2, ',', '.')}}</td>

                                    @if($factura->status==='cargada')
                                        <td class="text-center"><span class="label label-warning"><strong>{{strtoupper( $factura->status )}}</strong></span></td>
                                    @else
                                        @if($factura->status==='por procesar')
                                            <td class="text-center"><span class="label label-primary"><strong>{{strtoupper( $factura->status )}}</strong></span></td>
                                        @else
                                            @if($factura->status==='revisada')
                                            <td class="text-center"><span class="label label-info"><strong>{{strtoupper( $factura->status )}}</strong></span></td>
                                            @else
                                                @if($factura->status==='pagada')
                                                    <td class="text-center"><span class="label label-success"><strong>{{strtoupper( $factura->status )}}</strong></span></td>
                                                @else
                                                    <td class="text-center"><span class="label label-default"><strong>{{strtoupper( $factura->status )}}</strong></span></td>

                                                @endif

                                            @endif
                                        @endif
                                    @endif

                                    <td class="text-center">{{$factura->created_at}}</td>

                                    <td class="text-center">
                                        <a class="btn btn-xs sisbeca-btn-primary" target="_blank" href="{{asset($factura->url)}}" title="Ver Factura" data-toggle="tooltip" data-placement="bottom">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="alert  alert-warning alert-important" role="alert">
                            Actualmente no tiene registrada ninguna Factura!!
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>
@endsection


@section('personaljs')
    <script type="text/javascript">

        $(document).ready(function(){

            $('#myTable').DataTable( {
                columnDefs: [
                    { targets: [5], searchable: false}
                ]
            } );



        });

        $('#myTable')
            .removeClass( 'display' )
            .addClass('table table-hover');


        function handleNumber(event, mask) {
            /* numeric mask with pre, post, minus sign, dots and comma as decimal separator
                {}: positive integer
                {10}: positive integer max 10 digit
                {,3}: positive float max 3 decimal
                {10,3}: positive float max 7 digit and 3 decimal
                {null,null}: positive integer
                {10,null}: positive integer max 10 digit
                {null,3}: positive float max 3 decimal
                {-}: positive or negative integer
                {-10}: positive or negative integer max 10 digit
                {-,3}: positive or negative float max 3 decimal
                {-10,3}: positive or negative float max 7 digit and 3 decimal
            */
            with (event) {
                stopPropagation()
                preventDefault()
                if (!charCode) return
                var c = String.fromCharCode(charCode)
                if (c.match(/[^-\d,]/)) return
                with (target) {
                    var txt = value.substring(0, selectionStart) + c + value.substr(selectionEnd)
                    var pos = selectionStart + 1
                }
            }
            var dot = count(txt, /\./, pos)
            txt = txt.replace(/[^-\d,]/g,'')

            var mask = mask.match(/^(\D*)\{(-)?(\d*|null)?(?:,(\d+|null))?\}(\D*)$/); if (!mask) return // meglio exception?
            var sign = !!mask[2], decimals = +mask[4], integers = Math.max(0, +mask[3] - (decimals || 0))
            if (!txt.match('^' + (!sign?'':'-?') + '\\d*' + (!decimals?'':'(,\\d*)?') + '$')) return

            txt = txt.split(',')
            if (integers && txt[0] && count(txt[0],/\d/) > integers) return
            if (decimals && txt[1] && txt[1].length > decimals) return
            txt[0] = txt[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.')

            with (event.target) {
                value = mask[1] + txt.join(',') + mask[5]
                selectionStart = selectionEnd = pos + (pos==1 ? mask[1].length : count(value, /\./, pos) - dot)
            }

            function count(str, c, e) {
                e = e || str.length
                for (var n=0, i=0; i<e; i+=1) if (str.charAt(i).match(c)) n+=1
                return n
            }
        }
    </script>
@endsection