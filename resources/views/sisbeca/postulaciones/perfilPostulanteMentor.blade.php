@extends('sisbeca.layouts.main')
@if(Auth::user()->rol==='directivo')
@section('title','Mentores')
@section('subtitle','Detalle de la Postulación')
@else
    @section('title','Mi Perfil')
@section('subtitle','Postulante Mentor')
    @endif

@section('content')
   <div class="row">
        <div class="col-12">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="fa fa-male fa-fw"></span> Postulante {{$postulanteMentor->name.' '.$postulanteMentor->last_name}}</div>
 <a href="{{  URL::previous() }}" class=" btn-sm btn-danger">Atrás</a>

                <div class="card">
                  
                   @if(!is_null($documento))
                       <div class="text-right col-12" align="right">
                           <a target="_blank" href="{{asset($documento->url)}}" type='button' title="Ver Hoja de Vida" class='btn btn-md btn-info pull-right '>Ver Hoja de Vida</a>
                       </div>
                   @endif
                       <div class="card-body">
                           <div class="card-two">

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

                               <h3>{{$postulanteMentor->name}}</h3>
                               <div class="desc">
                                   Rol: Postulante Mentor.
                               </div>
                               <div class="contacts">
                                   <span class=" fa fa-venus-mars"> {{ucwords($postulanteMentor->sexo)}}</span> &nbsp;&nbsp;&nbsp;
                                   <span class=" fa fa-calendar"> {{$postulanteMentor->edad}} Años</span> &nbsp;&nbsp;&nbsp;
                                   <span class="fa fa-birthday-cake"> {{ date("d/m/Y", strtotime($postulanteMentor->fecha_nacimiento)) }}</span>
                                   <div class="clear"></div>
                               </div>
                           </div>
                       </div>
                       <div class="row">
                           <div class="col-md-3 col-xs-6 b-r"> <strong>Nombre Completo</strong>
                               <br>
                               <p class="text-muted">{{$postulanteMentor->name.' '.$postulanteMentor->last_name}}</p>
                           </div>
                           <div class="col-md-3 col-xs-6 b-r"> <strong>Cedula</strong>
                               <br>
                               <p class="text-muted">{{$postulanteMentor->cedula}}</p>
                           </div>
                           <div class="col-md-3 col-xs-6 b-r"> <strong>Email</strong>
                               <br>
                               <p class="text-muted">{{$postulanteMentor->email}}</p>
                           </div>
                           <div class="col-md-3 col-xs-6"> <strong>Dirección</strong>
                               <br>
                               <p class="text-muted">{{$postulanteMentor->descripcion}}</p>
                           </div>
                       </div>

                       @if(Auth::user()->rol==='directivo')
                        @if($postulanteMentor->rol!='rechazado')
                    <div align="center" style="background-color: rgba(150,150,150,0.1); padding: 10px">
                       <button type='button' title="Aprobar" class='btn btn-primary' data-toggle='modal' data-target='#modal' >Aprobar</button>&nbsp;&nbsp;
                       <button type='button' title="Rechazar" class='btn btn-danger' data-toggle='modal' data-target='#modal-default' >Rechazar</button>
                    </div>
                           @endif

                           @endif


                </div>
            </div>
           </div>

       </div>


   @if(Auth::user()->rol==='directivo')
   <div class="modal fade" id="modal">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span></button>
                   <h4 class="modal-title">Confirmación</h4>
               </div>

               <p align="center">¿Esta seguro que desea Aprobar {{$postulanteMentor->name}} como mentor?</p>

               <form method="POST" action={{route('postulanteMentor.update',$postulanteMentor->id)}} accept-charset="UTF-8">

                   {{csrf_field()}}
                   {{method_field('PUT')}}
                   <input type="hidden" id='valor' name="valor" value="1">
               <div class="modal-footer">
                   <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                   <button type="submit" class="btn btn-info pull-left">Si</button>
               </div>

               </form>

           </div>


       </div>

       <!-- /.modal-content -->
   </div>


   <div class="modal fade" id="modal-default">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span></button>
                   <h4 class="modal-title">Confirmación</h4>
               </div>

               <p align="center">¿Esta seguro que desea Rechazar a {{$postulanteMentor->name}} como mentor?</p>

               <form method="POST" action={{route('postulanteMentor.update',$postulanteMentor->id)}} accept-charset="UTF-8">

                   {{csrf_field()}}
                   {{method_field('PUT')}}
                   <input type="hidden" id='valor' name="valor"  value="0">
                   <div class="modal-footer">
                       <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                       <button type="submit" class="btn btn-info pull-left" >Si</button>
                   </div>

               </form>

           </div>


       </div>

       <!-- /.modal-content -->
   </div>
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
