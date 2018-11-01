@extends('sisbeca.layouts.main')
@section('title','Perfil')
@section('subtitle','Mentor')
@section('content')

    <div class="row">
        <!-- Column -->
        @if(!is_null($mentor))
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="fa fa-user fa-fw"></span>
                    Perfil de {{$mentor->user->name.' '.$mentor->user->last_name}}
                </div>

            <div class="card">
                @if((Auth::user()->rol==='directivo' || Auth::user()->rol==='coordinador' || Auth::user()->rol==='mentor') && !is_null($documento))
                    <div class="text-right col-12" align="right">
                        <a target="_blank" href="{{asset($documento->url)}}" type='button' title="Ver Hoja de Vida" class='btn btn-md btn-info pull-right '>Ver Hoja de Vida</a>
                    </div>
                @endif

                <div class="card-body">
                    <div class="card-two">

                        <header>
                            <div class="avatar">
                                @if($img_perfil->count()>0)
                                    <img src="{{asset($img_perfil[0]->url)}}" style="height: 95px !important;">

                                @else

                                    @if($mentor->user->sexo==='femenino')
                                        <img src="{{asset('images/perfil/femenino.png')}}" style="height: 95px !important;">
                                    @else
                                        <img src="{{asset('images/perfil/masculino.png')}}" style="height: 95px !important;">

                                    @endif

                                @endif
                            </div>
                        </header>

                        <h3>{{$mentor->user->name}}</h3>
                        <div class="desc">
                           Rol: Mentor.
                        </div>
                        <div class="contacts">
                           <span class=" fa fa-venus-mars"> {{ucwords($mentor->user->sexo)}}</span> &nbsp;&nbsp;&nbsp;
                            <span class=" fa fa-calendar"> {{$mentor->user->edad}} Años</span> &nbsp;&nbsp;&nbsp;
                            <span class="fa fa-birthday-cake"> {{ date("d/m/Y", strtotime($mentor->user->fecha_nacimiento)) }}</span>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3 col-xs-6 b-r"> <strong>Nombre Completo</strong>
                        <br>
                        <p class="text-muted">{{$mentor->user->name.' '.$mentor->user->last_name}}</p>
                    </div>
                    <div class="col-md-3 col-xs-6 b-r"> <strong>Cedula</strong>
                        <br>
                        <p class="text-muted">{{$mentor->user->cedula}}</p>
                    </div>
                    <div class="col-md-3 col-xs-6 b-r"> <strong>Email</strong>
                        <br>
                        <p class="text-muted">{{$mentor->user->email}}</p>
                    </div>
                    <div class="col-md-3 col-xs-6"> <strong>Dirección</strong>
                        <br>
                        <p class="text-muted">{{$mentor->user->descripcion}}</p>
                    </div>
                </div>
            </div>
        </div>
        </div>
        @else
            <div class="alert  alert-warning alert-important col-sm-12" role="alert">
                Actualmente no tiene Mentor Asignado!!
            </div>
            @endif
        <!-- Column -->
    </div>
@endsection
