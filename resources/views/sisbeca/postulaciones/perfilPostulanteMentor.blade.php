@extends('sisbeca.layouts.main')
@if(Auth::user()->rol==='directivo')
  @section('title','Postulante Mentor: '.$postulanteMentor->name.' '.$postulanteMentor->last_name)
@else
  @section('title','Mi Perfil: '.$postulanteMentor->name.' '.$postulanteMentor->last_name)
@endif

@section('content')
<div class="text-right col-12" align="right" >
  @if(!is_null($documento))
    <a target="_blank" href="{{asset($documento->url)}}" class='btn btn-sm sisbeca-btn-primary'>Ver Hoja de Vida</a>
  @endif
  <a href="{{  URL::previous() }}" class=" btn btn-sm sisbeca-btn-primary">Atrás</a>
</div>
                
<div class="card">
  
    

      <div class="card-body" style="border: 1px solid #eee">
          <div class="card-two">

              <div class="text-right col-12" align="right">

              </div>

              <header>
                  <div class="avatar">
                      @if($img_perfil_postulante->count()>0)
                        <img src="{{asset($img_perfil_postulante[0]->url)}}" style="height: 95px !important;">

                      @else

                        @if($postulanteMentor->sexo==='femenino')
                          <img src="{{asset('images/perfil/femenino.png')}}" style="height: 95px !important;">
                        @else
                          <img src="{{asset('images/perfil/masculino.png')}}" style="height: 95px !important;">

                        @endif

                     @endif
                  </div>
              </header>

              <h3>{{$postulanteMentor->name}} {{$postulanteMentor->last_name}}</h3>

              <div class="desc">
                Postulante  Mentor
              </div>
              <div class="desc">
                 <span class="label label-info">Postulante Mentor</span>
              </div>

              <div class="text-center">
                <span class=" fa fa-venus-mars"></span>
                {{ucwords($postulanteMentor->sexo)}} &nbsp;&nbsp;&nbsp;
                

                <span class=" fa fa-calendar"></span> 
                {{$postulanteMentor->edad}} Años &nbsp;&nbsp;&nbsp;
                
                <span class="fa fa-birthday-cake"></span>
                {{ date("d/m/Y", strtotime($postulanteMentor->fecha_nacimiento)) }}
                
                <div class="clear"></div>
                <br>
              </div>
          
          </div>
      </div>

      <div class="col-lg-12" style="border:1px solid #eee">
        <div class="row">
           <div class="col-md-3 col-xs-6 b-r"> <strong>Nombre Completo</strong>
               <br>
               <p class="text-muted">{{$postulanteMentor->name.' '.$postulanteMentor->last_name}}</p>
           </div>
           <div class="col-md-3 col-xs-6 b-r"> <strong>Cédula</strong>
               <br>
               <p class="text-muted">{{$postulanteMentor->cedula}}</p>
           </div>
           <div class="col-md-3 col-xs-6 b-r"> <strong>Correo Electrónico</strong>
               <br>
               <p class="text-muted">{{$postulanteMentor->email}}</p>
           </div>
           <div class="col-md-3 col-xs-6"> <strong>Dirección</strong>
               <br>
               <p class="text-muted">{{$postulanteMentor->descripcion}}</p>
           </div>
        </div>
      </div>

      <br>

      @if(Auth::user()->rol==='directivo')
        @if($postulanteMentor->rol!='rechazado')
          <div align="center">
          <h3>¿Que Acción Tomar para el Postulante {{$postulanteMentor->name.' '.$postulanteMentor->last_name}} ?</h3>
          <br>
             <button type='button' title="Aprobar" class='btn sisbeca-btn-primary' data-toggle='modal' data-target='#modal' >Aprobar</button>&nbsp;&nbsp;
             <button type='button' title="Rechazar" class='btn sisbeca-btn-default' data-toggle='modal' data-target='#modal-default' >Rechazar</button>
          </div>
        @endif

      @endif

      <br>
</div>
    



  @if(Auth::user()->rol==='directivo')

    <!-- Modal para aprobar  --> 
    <div class="modal fade" id="modal">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                   <span aria-hidden="true">&times;</span></button>
               <h4 class="modal-title">Confirmación</h4>
            </div>
            <div class="modal-body">
            <br>
            ¿Está seguro que desea <strong>aprobar</strong> <strong>{{$postulanteMentor->name}} {{$postulanteMentor->last_name}}</strong> como mentor?
            </div>
           

           <form method="POST" action={{route('postulanteMentor.update',$postulanteMentor->id)}} accept-charset="UTF-8">

               {{csrf_field()}}
               {{method_field('PUT')}}
               <input type="hidden" id='valor' name="valor" value="1">
           <div class="modal-footer">
               <button type="button" class="btn sisbeca-btn-default pull-left" data-dismiss="modal">No</button>
               <button type="submit" class="btn sisbeca-btn-primary pull-left">Si</button>
           </div>

           </form>

        </div>

      </div>

    </div>
    <!-- Modal para aprobar  --> 


    <!-- Modal para rechazar --> 
    <div class="modal fade" id="modal-default">
      <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title pull-left">Confirmación</h4>
            </div>

            <div class="modal-body">
              <br>
              ¿Está seguro que desea <strong>rechazar</strong> a <strong>{{$postulanteMentor->name}} {{$postulanteMentor->last_name}}</strong> como mentor?
            </div>

            <form method="POST" action={{route('postulanteMentor.update',$postulanteMentor->id)}} accept-charset="UTF-8">

                {{csrf_field()}}
                {{method_field('PUT')}}
                <input type="hidden" id='valor' name="valor"  value="0">

                <div class="modal-footer">
                  <button type="button" class="btn sisbeca-btn-default pull-right" data-dismiss="modal">No</button>
                  <button type="submit" class="btn sisbeca-btn-primary pull-right" >Si</button>
                </div>

            </form>

        </div>
      </div>
    </div>
    <!-- Modal para rechazar --> 

  @endif


@endsection

@if(Auth::user()->rol==='directivo')
    @section('personaljs')
        <script type="text/javascript">

            function Regresar() {

                var route= "{{route('listarPostulantesMentores')}}";


                location.assign(route);

            }
        </script>
    @endsection
@endif
