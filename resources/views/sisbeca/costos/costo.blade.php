@extends('sisbeca.layouts.main')
@section('title','Inicio')
@section('subtitle','Mantenimiento de Costos')
@section('content')

<div class="row">

    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon"> <img src="{{asset('images/bs.png')}}" style="height: 50px !important;"></span>

            <div class="info-box-content">
                <span class="info-box-text">Costo Membresias<br />(ind./VIP)</span>
                <span class="info-box-number">{{number_format($costo->costo_membresia, 2, ',', '.')}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>

        <!-- /.info-box -->
    </div>

    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon "><img src="{{asset('images/bs.png')}}" style="height: 50px !important;"></span>

            <div class="info-box-content">
                <span class="info-box-text">Costo Asesoria<br />(Básica)</span>
                <span class="info-box-number">{{number_format($costo->costo_ases_basica, 2, ',', '.')}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon"><img src="{{asset('images/bs.png')}}" style="height: 50px !important;"></span>

            <div class="info-box-content">
                <span class="info-box-text">Costo Asesoria<br />(Intermedia)</span>
                <span class="info-box-number">{{number_format($costo->costo_ases_intermedia, 2, ',', '.')}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-md-3 col-sm-6 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon"><img src="{{asset('images/bs.png')}}" style="height: 50px !important;"></span>

            <div class="info-box-content">
                <span class="info-box-text">Costo Asesoria<br />(Completa)</span>
                <span class="info-box-number">{{number_format($costo->costo_ases_completa, 2, ',', '.')}}</span>
            </div>
            <!-- /.info-box-content -->
        </div>

        <!-- /.info-box -->
    </div>


    <!-- /.col -->
</div>

<div class="row">
    <div class="col-12">
        <div class="panel panel-default">
            <div class="panel-heading"><span class="fa fa-user fa-fw"></span> Actualizar Costos</div>
            <form class="form-horizontal" accept-charset="UTF-8" method="POST" action="{{route('costos.createOrUpdate',$id)}}">

                {{csrf_field()}}
                @if($id!=0)
                {{method_field('PUT')}}
                @endif

                <div class="row">
                    <div class="col-lg-4 col-md-5 col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Costo Asesoria (Básica)</label>
                            <input type="text" onkeypress="handleNumber(event, '{20,2}')" placeholder="Asesoria Básica"
                                size=23 value="{{number_format($costo->costo_ases_basica, 2, ',', '.')}}" name="costo_ases_basica"
                                required class="sisbeca-input">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5 col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Costo Asesoria (Intermedia)</label>
                            <input type="text" onkeypress="handleNumber(event, '{20,2}')" placeholder="Asesoria Intermedia"
                                size=23 value="{{number_format($costo->costo_ases_intermedia, 2, ',', '.')}}" name="costo_ases_intermedia"
                                required class="sisbeca-input">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5 col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Costo Asesoria (Completa)</label>
                            <input type="text" onkeypress="handleNumber(event, '{20,2}')" placeholder="Asesoria Completa"
                                size=23 value="{{number_format($costo->costo_ases_completa, 2, ',', '.')}}" name="costo_ases_completa"
                                required class="sisbeca-input">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-0 col-sm-0"></div>
                    <div class="col-lg-4 col-md-5 col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Costo Membresia (Ind./VIP)</label>
                            <input type="text" onkeypress="handleNumber(event, '{20,2}')" placeholder="Membresia Ind./VIP"
                                size=23 required value="{{number_format($costo->costo_membresia, 2, ',', '.')}}" name="costo_membresia"
                                class="sisbeca-input">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-5 col-sm-12">
                        <div class="form-group">
                            <label class="control-label">Validos a partir de</label>
                            <input name="fecha_valido" type="text" id="datepicker" value="{{date('d/m/Y', strtotime($costo->fecha_valido))}}"
                                required placeholder="Fecha Valido..." class="sisbeca-input">
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-0 col-sm-0"></div>
                </div>

                <div align="center" class="form-group">

                    <input class="btn sisbeca-btn-primary" type="submit" value="Actualizar Costos">
                </div>

            </form>
        </div>

    </div>

</div>
@endsection

@section('personaljs')
<script>
    $(function () {
        $("#datepicker").datepicker({ maxDate: "+24 +0D", orientation: "bottom" });

    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

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
        txt = txt.replace(/[^-\d,]/g, '')

        var mask = mask.match(/^(\D*)\{(-)?(\d*|null)?(?:,(\d+|null))?\}(\D*)$/); if (!mask) return // meglio exception?
        var sign = !!mask[2], decimals = +mask[4], integers = Math.max(0, +mask[3] - (decimals || 0))
        if (!txt.match('^' + (!sign ? '' : '-?') + '\\d*' + (!decimals ? '' : '(,\\d*)?') + '$')) return

        txt = txt.split(',')
        if (integers && txt[0] && count(txt[0], /\d/) > integers) return
        if (decimals && txt[1] && txt[1].length > decimals) return
        txt[0] = txt[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.')

        with (event.target) {
            value = mask[1] + txt.join(',') + mask[5]
            selectionStart = selectionEnd = pos + (pos == 1 ? mask[1].length : count(value, /\./, pos) - dot)
        }

        function count(str, c, e) {
            e = e || str.length
            for (var n = 0, i = 0; i < e; i += 1) if (str.charAt(i).match(c)) n += 1
            return n
        }
    }
</script>
@endsection