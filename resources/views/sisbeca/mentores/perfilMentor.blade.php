@extends('sisbeca.layouts.main')
@section('title','Mentor: '.$mentor->user->nombreyapellido())
@section('content')

    @if((Auth::user()->rol==='directivo' || Auth::user()->rol==='coordinador' || Auth::user()->rol==='mentor') && !is_null($documento))
    <div class="text-right col-12" align="right" >
        <a href="{{asset($documento->url)}}" class=" btn btn-sm sisbeca-btn-primary">Ver Hoja de Vida</a>
        <a href="{{  URL::previous() }}" class=" btn btn-sm sisbeca-btn-primary">Atrás</a>
    </div>
    @endif
    <div class="card">
  
        <div class="card-body" style="border: 1px solid #eee">
            <div class="card-two">

                <div class="text-right col-12" align="right">

                </div>

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

                <h3>{{$mentor->user->name}} {{$mentor->user->last_name}}</h3>

                <!--<div class="desc">
                Mentor
                </div>-->
                <div class="desc">
                 <span class="label label-info">Mentor</span>
                </div>

                <div class="text-center">
                <span class=" fa fa-venus-mars"></span>
                {{ucwords($mentor->user->sexo)}} &nbsp;&nbsp;&nbsp;
                

                <span class=" fa fa-calendar"></span> 
                {{$mentor->user->edad}} Años &nbsp;&nbsp;&nbsp;
                
                <span class="fa fa-birthday-cake"></span>
                {{ date("d/m/Y", strtotime($mentor->user->fecha_nacimiento)) }}
                
                <div class="clear"></div>
                <br>
              </div>
          
            </div>
        </div>

        <div class="col-lg-12" style="border:1px solid #eee">
            <div class="row">
               <div class="col-md-3 col-xs-6 b-r"> <strong>Nombre Completo</strong>
                   <br>
                   <p class="text-muted">{{$mentor->user->name.' '.$mentor->user->last_name}}</p>
                </div>
                <div class="col-md-3 col-xs-6 b-r"> <strong>Cédula</strong>
                   <br>
                   <p class="text-muted">{{$mentor->user->cedula}}</p>
                </div>
                <div class="col-md-3 col-xs-6 b-r"> <strong>Correo Electrónico</strong>
                   <br>
                   <p class="text-muted">{{$mentor->user->email}}</p>
                </div>
                <div class="col-md-3 col-xs-6"> <strong>Dirección</strong>
                   <br>
                   <p class="text-muted">{{$mentor->user->descripcion}}</p>
                </div>
            </div>
        </div>
        <br>

    </div>
@endsection
