@extends('sisbeca.layouts.main')
@section('title','Costos')
@section('content')

<div class="col-lg-12">
    <div class="text-right">
        <a href="{{route('costos.edit',$id )}}" class="btn btn-sm sisbeca-btn-primary">Actualizar Costos</a>
    </div>
    <br>

    <div class="row">

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box costos-border">
                <span class="info-box-icon costos-icon">
                    <img src="{{asset('images/bs_white.png')}}" style="height: 50px !important;">
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Costo Membresias<br />(ind./VIP)</span>
                    <span class="info-box-number">
                        @if(isset($costo))
                            {{number_format($costo->costo_membresia, 2, ',', '.')}}
                        @else
                            {{number_format(0, 2, ',', '.')}}
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box costos-border">
                <span class="info-box-icon costos-icon">
                    <img src="{{asset('images/bs_white.png')}}" style="height: 50px !important;">
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Costo Asesoria<br />(Básica)</span>
                    <span class="info-box-number">
                    @if(isset($costo))
                        {{number_format($costo->costo_ases_basica, 2, ',', '.')}}
                    @else
                        {{number_format(0, 2, ',', '.')}}
                    @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box costos-border">
                <span class="info-box-icon costos-icon">
                    <img src="{{asset('images/bs_white.png')}}" style="height: 50px !important;">
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Costo Asesoria<br />(Intermedia)</span>
                    <span class="info-box-number">
                    @if(isset($costo))
                        {{number_format($costo->costo_ases_intermedia, 2, ',', '.')}}
                    @else
                        {{number_format(0, 2, ',', '.')}}
                    @endif
                    </span>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 col-sm-6 col-xs-12">
            <div class="info-box costos-border">
                <span class="info-box-icon costos-icon">
                    <img src="{{asset('images/bs_white.png')}}" style="height: 50px !important;">
                </span>

                <div class="info-box-content">
                    <span class="info-box-text">Costo Asesoria<br/>(Completa)</span>
                    <span class="info-box-number">
                    @if(isset($costo))
                        {{number_format($costo->costo_ases_completa, 2, ',', '.')}}
                    @else
                        {{number_format(0, 2, ',', '.')}}
                    @endif
                    </span>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <p class="text-right">Fecha válido: 
        @if(isset($costo))
            <strong>{{ $costo->getFechaValido() }}</strong>
        @else
            <strong>DD/MM/AAAA</strong>
        @endif
    </p>
</div>



@endsection

@section('personaljs')

@endsection