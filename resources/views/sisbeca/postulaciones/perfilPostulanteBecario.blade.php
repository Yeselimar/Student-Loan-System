@extends('sisbeca.layouts.main')
@section('title','Postulante: '.$postulante->user->last_name.' '.$postulante->user->last_name)
@section('content')
   
     
<div class="card">
        <div class="text-right col-12" align="right" >
          <a href="{{  URL::previous() }}" class=" btn btn-sm sisbeca-btn-default">Atrás</a>
        </div>
        <div class="card-body" style="border: 1px solid #eee">
            <div class="card-two">
                

                <div class="text-right col-12" align="right">

                </div>
                
                <header>
                    <div class="avatar">
                      {{$img_perfil}}
                        @if($img_perfil->count()>0)
                            <img src="{{asset($img_perfil[0]->url)}}" style="height: 95px !important;">

                        @else

                            @if($postulante->user->sexo==='femenino')
                                <img src="{{asset('images/perfil/femenino.png')}}" style="height: 95px !important;">
                            @else
                                <img src="{{asset('images/perfil/masculino.png')}}" style="height: 95px !important;">

                            @endif

                        @endif
                    </div>
                    
                </header>

                <h3>{{$postulante->user->name}} {{$postulante->user->last_name }}</h3>

                <div class="desc">
                   
                   Postulante Becario
                   
                </div>

                <div class="desc">
              
                    @if($postulante->status==='postulante')
                        <span class="label label-info">Postulante</span>
                    @else
                        @if($postulante->status==='entrevista')
                            <span class="label label-warning">Aprobado para Entrevista</span>
                        @else
                            <span class="label label-danger">Rechazado</span>
                        @endif
                    @endif
                </div>

                <div class="text-center">
                   <span class="fa fa-venus-mars"> </span> {{ucwords($postulante->user->sexo)}} &nbsp;&nbsp;&nbsp;
                    <span class="fa fa-calendar"></span> {{$postulante->user->edad}} Años &nbsp;&nbsp;&nbsp;
                    <span class="fa fa-birthday-cake"></span> {{ date("d/m/Y", strtotime($postulante->user->fecha_nacimiento)) }}
                    <div class="clear"></div>
                    <br>
                </div>
               
            </div>
        </div>
        <div class="col-lg-12" style="border:1px solid #eee">
            <div class="row">
                <div class="col-md-3 col-xs-6 b-r"> <strong>Nombre Completo</strong>
                    <br>
                    <p class="text-muted">{{$postulante->user->name.' '.$postulante->user->last_name}}</p>
                </div>
                <div class="col-md-3 col-xs-6 b-r"> <strong>Cedula</strong>
                    <br>
                    <p class="text-muted">{{$postulante->user->cedula}}</p>
                </div>
                <div class="col-md-3 col-xs-6 b-r"> <strong>Email</strong>
                    <br>
                    <p class="text-muted">{{$postulante->user->email}}</p>
                </div>
                <div class="col-md-3 col-xs-6"> <strong>Dirección</strong>
                    <br>
                    <p class="text-muted">{{$postulante->direccion_permanente}}</p>
                </div>
            </div>
        </div>
        <br>
        @if($postulante->status==='postulante')
        <div align="center">
            <button type='button' title="Aprobar" class='btn sisbeca-btn-primary' data-toggle='modal' data-target='#modal' >Aprobar</button>&nbsp;&nbsp;
            <button type='button' title="Rechazar" class='btn sisbeca-btn-default' data-toggle='modal' data-target='#modal-default' >Rechazar</button>
        </div>
         @endif
         
    </div>


   <div class="modal fade" id="modal">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true"> &times;</span>
                    </button>
                
                    <h5 class="modal-title pull-left"><strong>Confirmación</strong></h5>
               </div>
               <div class="modal-body">
               <form method="POST" action={{route('aprobarParaEntrevista',$postulante->user_id)}} accept-charset="UTF-8">
                   {{csrf_field()}}
                   {{method_field('PUT')}}
                   <input type="hidden" id='valor' name="valor" value="1">
                   <label for="entrevistador-1" class="control-label ">Por Favor Selecciones el Primer Entrevistador:</label>
                   <select class="form-control" id="entrevistador1" name="entrevistador1"> 
                    <option>Opcion1</option> 
                    <option>Opcion2</option> 
                    <option>Opcion3</option> 
                    <option>Opcion4</option>
                    <option>Opcion1</option> 
                    <option>Opcion2</option> 
                    <option>Opcion3</option> 
                    <option>Opcion4</option> 
                </select>
                <label for="entrevistador-2" class="control-label ">Por Favor Selecciones el Segundo Entrevistador:</label>
                <select class="form-control" id="entrevistador2" name="entrevistador2"> 
                    <option>Opcion1</option> 
                    <option>Opcion2</option> 
                    <option>Opcion3</option> 
                    <option>Opcion4</option>
                    <option>Opcion1</option> 
                    <option>Opcion2</option> 
                    <option>Opcion3</option> 
                    <option>Opcion4</option> 
                </select>
                <p align="center">¿Esta seguro que desea Aprobar a {{$postulante->user->name}} para la entrevista?</p>
               <div class="modal-footer">
                   <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                   <button type="submit" class="btn btn-info pull-left">Si</button>
               
               </div>

               </form>
               </div>
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

          <p align="center">¿Esta seguro que desea Rechazar a {{$postulante->user->name}} para la entrevista?</p>

          <form method="POST" action={{route('aprobarParaEntrevista', $postulante->user_id)}} accept-charset="UTF-8">

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

   <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
      <div class="panel-group Material-default-accordion" id="datos-personales" role="tablist" aria-multiselectable="true">

        <div class="panel panel-default-accordion mb-3">
            <div class="panel-accordion" role="tab" id="heading">
                <h5 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#datos-personales" href="#datospersonales" aria-expanded="false" aria-controls="datospersonales">
              Datos Personales
                    </a>
                </h5>
            </div>
            <div id="datospersonales" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading">
                <div align="justify" class="panel-body">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <tbody>
                        <tr>
                          <td class="text-left"><strong>Nombres</strong></td>
                          <td class="text-left">{{ $usuario->name }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Apellidos</strong></td>
                          <td class="text-left">{{ $usuario->last_name }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Fecha Nacimiento</strong></td>
                          <td class="text-left">{{ $usuario->getFechaNacimiento() }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Lugar de Nacimiento</strong></td>
                          <td class="text-left">{{ $postulante->lugar_nacimiento }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Edad</strong></td>
                          <td class="text-left">{{ $usuario->getEdad() }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Sexo</strong></td>
                          <td class="text-left">{{ $usuario->sexo }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Cédula</strong></td>
                          <td class="text-left">{{ $usuario->cedula }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Correo Electrónico</strong></td>
                          <td class="text-left">{{ $usuario->email }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Dirección Permanente</strong></td>
                          <td class="text-left">{{ $postulante->direccion_permanente }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Dirección Temporal</strong></td>
                          <td class="text-left">{{ $postulante->direccion_temporal }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Teléfono Celular</strong></td>
                          <td class="text-left">{{ $postulante->celular }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Teléfono Habitación</strong></td>
                          <td class="text-left">{{ $postulante->telefono_habitacion }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Teléfono Pariente</strong></td>
                          <td class="text-left">{{ $postulante->telefono_pariente }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Promedio Ingreso Familiar</strong></td>
                          <td class="text-left">{{ $postulante->ingreso_familiar }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Trabaja</strong></td>
                          <td class="text-left">{{ $postulante->getTrabaja() }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Lugar de Trabajo</strong></td>
                          <td class="text-left">{{ $postulante->lugar_trabajo }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Cargo que desempeña en el trabajo</strong></td>
                          <td class="text-left">{{ $postulante->cargo_trabajo }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Horas mensuales de trabajo</strong></td>
                          <td class="text-left">{{ $postulante->horas_trabajo }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Contribuye con el ingreso familiar</strong></td>
                          <td class="text-left">{{ $postulante->getContribuyeIngreso() }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Contribuye con el ingreso familiar (en porcentaje) </strong></td>
                          <td class="text-left">{{ $postulante->getContribuyePorcentaje() }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Vive con </strong></td>
                          <td class="text-left">{{ $postulante->vives_con }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Vive con otros (en específico) </strong></td>
                          <td class="text-left">{{ $postulante->vives_otros }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Tipo Vivienda </strong></td>
                          <td class="text-left">{{ $postulante->tipo_vivienda }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Composición Familiar</strong></td>
                          <td class="text-left">{{ $postulante->composicion_familiar }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Ocupación del Padre</strong></td>
                          <td class="text-left">{{ $postulante->ocupacion_padre }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Nombre de la empresa del Padre</strong></td>
                          <td class="text-left">{{ $postulante->nombre_empresa_padre }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Experiencia Laboral del Padre</strong></td>
                          <td class="text-left">{{ $postulante->getExperienciaPadre() }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Ocupación del Madre</strong></td>
                          <td class="text-left">{{ $postulante->ocupacion_madre }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Nombre de la empresa del Madre</strong></td>
                          <td class="text-left">{{ $postulante->nombre_empresa_madre }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Experiencia Laboral del Madre</strong></td>
                          <td class="text-left">{{ $postulante->getExperienciaMadre() }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-group Material-default-accordion" id="estudios-secundarios" role="tablist" aria-multiselectable="true">

        <div class="panel panel-default-accordion mb-3">
            <div class="panel-accordion" role="tab" id="heading">
                <h5 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#estudios-secundarios" href="#estudiossecundarios" aria-expanded="false" aria-controls="estudiossecundarios">
              Estudios Secundarios
                    </a>
                </h5>
            </div>
            <div id="estudiossecundarios" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading">
                <div align="justify" class="panel-body">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <tbody>
                        <tr>
                          <td class="text-left"><strong>Nombre de la Institución</strong></td>
                          <td class="text-left">{{ $postulante->nombre_institucion }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Dirección de la institución</strong></td>
                          <td class="text-left">{{ $postulante->direccion_institucion }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Director de la institución</strong></td>
                          <td class="text-left">{{ $postulante->director_institucion }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Bachiller en</strong></td>
                          <td class="text-left">{{ $postulante->bachiller_en }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Promedio en Bachillerato</strong></td>
                          <td class="text-left">{{ $postulante->promedio_bachillerato }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Actividades Extracurriculares</strong></td>
                          <td class="text-left">{{ $postulante->actividades_extracurriculares }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Lugar de la Labor Social</strong></td>
                          <td class="text-left">{{ $postulante->lugar_labor_social }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Dirección de la Labor Social</strong></td>
                          <td class="text-left">{{ $postulante->direccion_labor_social }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Supervisor de la Labor Social</strong></td>
                          <td class="text-left">{{ $postulante->supervisor_labor_social }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Habla otro idioma</strong></td>
                          <td class="text-left">{{ $postulante->habla_otro_idioma }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Idioma que habla</strong></td>
                          <td class="text-left">{{ $postulante->habla_idioma }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Nivel de conocimiento del idioma</strong></td>
                          <td class="text-left">{{ $postulante->nivel_idioma }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-group Material-default-accordion" id="estudios-universitarios" role="tablist" aria-multiselectable="true">

        <div class="panel panel-default-accordion mb-3">
            <div class="panel-accordion" role="tab" id="heading">
                <h5 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#estudios-universitarios" href="#estudiosuniversitarios" aria-expanded="false" aria-controls="estudiosuniversitarios">
              Estudios Universitarios
                    </a>
                </h5>
            </div>
            <div id="estudiosuniversitarios" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading">
                <div align="justify" class="panel-body">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <tbody>
                        <tr>
                          <td class="text-left"><strong>Fecha Inicio de la Universidad</strong></td>
                          <td class="text-left">{{ $postulante->getInicioUniversidad() }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Universidad</strong></td>
                          <td class="text-left">{{ $postulante->nombre_universidad }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Carrera</strong></td>
                          <td class="text-left">{{ $postulante->carrera_universidad }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Costo de la matrícula académica</strong></td>
                          <td class="text-left">{{ $postulante->costo_matricula }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Promedio Universidad</strong></td>
                          <td class="text-left">{{ $postulante->promedio_universidad }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Periódo Académico</strong></td>
                          <td class="text-left">{{ $postulante->periodo_academico }}</td>
                        </tr>

                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-group Material-default-accordion" id="informacion-adicional" role="tablist" aria-multiselectable="true">

        <div class="panel panel-default-accordion mb-3">
            <div class="panel-accordion" role="tab" id="heading">
                <h5 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#informacion-adicional" href="#informacionadicional" aria-expanded="false" aria-controls="informacionadicional">
              Informacion Adicional
                    </a>
                </h5>
            </div>
            <div id="informacionadicional" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading">
                <div align="justify" class="panel-body">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                      <tbody>
                        <tr>
                          <td class="text-left"><strong>Medio de que como enteró del Programa Proexcelencia</strong></td>
                          <td class="text-left">{{ $postulante->medio_proexcelencia }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Otro medio de como se enteró del Programa Proexcelencia</strong></td>
                          <td class="text-left">{{ $postulante->otro_medio_proexcelencia }}</td>
                        </tr>
                        <tr>
                          <td class="text-left"><strong>Motivo de la beca</strong></td>
                          <td class="text-left">{{ $postulante->motivo_beca }}</td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-group Material-default-accordion" id="todos-documentos" role="tablist" aria-multiselectable="true">

        <div class="panel panel-default-accordion mb-3">
            <div class="panel-accordion" role="tab" id="heading">
                <h5 class="panel-title">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#todos-documentos" href="#todosdocumentos" aria-expanded="false" aria-controls="todosdocumentos">
              Documentos
                    </a>
                </h5>
            </div>
            <div id="todosdocumentos" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading">
                <div align="justify" class="panel-body">
                  <div class="table-responsive">
                    <table class="table table-bordered">
                        <tbody>
                        <tr>
                            <td class="text-left"><strong>Foto Tipo Carnet</strong></td>
                            <td class="text-left">
                                @if(!is_null($fotografia))
                                    <a target="_blank" href="{{ asset($fotografia->url) }}" class="btn btn-xs btn-primary">Ver Imagen</a>
                                @else
                                    <span class="label label-light-danger"><strong>Sin Fotografia</strong></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Copia Cédula</strong></td>
                            <td class="text-left">
                                @if(!is_null($cedula))
                                    <a target="_blank" href="{{ asset($cedula->url) }}" class="btn btn-xs btn-primary">Ver Imagen</a>
                                @else
                                    <span class="label label-light-danger"><strong>Sin Cedula</strong></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Constancia CNU</strong></td>
                            <td class="text-left">
                                @if(!is_null($constancia_cnu))
                                    <a target="_blank" href="{{ asset($constancia_cnu->url) }}" class="btn btn-xs btn-primary">Ver Documento</a>
                                @else
                                    <span class="label label-light-danger"><strong>Sin Constancia CNU</strong></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Calificaciones de Bachillerato</strong></td>
                            <td class="text-left">
                                @if(!is_null($calificaciones_bachillerato))
                                    <a target="_blank" href="{{ asset($calificaciones_bachillerato->url) }}" class="btn btn-xs btn-primary">Ver Documento</a>
                                @else
                                    <span class="label label-light-danger"><strong>Sin Calificaciones de Bachillerato</strong></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Constancia de Aceptación</strong></td>
                            <td class="text-left">
                                @if(!is_null($constancia_aceptacion))
                                    <a target="_blank" href="{{ asset($constancia_aceptacion->url) }}" class="btn btn-xs btn-primary">Ver Documento</a>
                                @else
                                    <span class="label label-light-danger"><strong>Sin Constancia de Aceptación</strong></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Constancia de Estudio</strong></td>
                            <td class="text-left">
                                @if(!is_null($constancia_estudios))
                                    <a target="_blank" href="{{ asset($constancia_estudios->url) }}" class="btn btn-xs btn-primary">Ver Documento</a>
                                @else
                                    <span class="label label-light-danger"><strong>Sin Constancia de Estudio</strong></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Calificaciones de la Universidad</strong></td>
                            <td class="text-left">
                                @if(!is_null($calificaciones_universidad))
                                    <a target="_blank" href="{{ asset($calificaciones_universidad->url) }}" class="btn btn-xs btn-primary">Ver Documento</a>
                                @else
                                    <span class="label label-light-danger"><strong>Sin Calificaciones de la Universidad</strong></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Constanca de Trabajo</strong></td>
                            <td class="text-left">
                                @if(!is_null($constancia_trabajo))
                                    <a target="_blank" href="{{ asset($constancia_trabajo->url) }}" class="btn btn-xs btn-primary">Ver Documento</a>
                                @else
                                    <span class="label label-light-danger"><strong>Sin Constanca de Trabajo</strong></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Declaración de Impuestos</strong></td>
                            <td class="text-left">
                                @if(!is_null($declaracion_impuestos))
                                    <a target="_blank" href="{{ asset($declaracion_impuestos->url) }}" class="btn btn-xs btn-primary">Ver Documento</a>
                                @else
                                    <span class="label label-light-danger"><strong>Sin Declaración de Impuestos</strong></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Recibo de pago</strong></td>
                            <td class="text-left">
                                @if(!is_null($recibo_pago))
                                    <a target="_blank" href="{{ asset($recibo_pago->url) }}" class="btn btn-xs btn-primary">Ver Documento</a>
                                @else
                                    <span class="label label-light-danger"><strong>Sin Recibo de pago</strong></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Referencia del Profesor 1</strong></td>
                            <td class="text-left">
                                @if(!is_null($referencia_profesor1))
                                    <a target="_blank" href="{{ asset($referencia_profesor1->url) }}" class="btn btn-xs btn-primary">Ver Documento</a>
                                @else
                                    <span class="label label-light-danger"><strong>Sin Referencia del Profesor 1</strong></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Referencia del Profesor 2</strong></td>
                            <td class="text-left">
                                @if(!is_null($referencia_profesor2))
                                    <a target="_blank" href="{{ asset($referencia_profesor2->url) }}" class="btn btn-xs btn-primary">Ver Documento</a>
                                @else
                                    <span class="label label-light-danger"><strong>Sin Referencia del Profesor 2</strong></span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-left"><strong>Ensayo</strong></td>
                            <td class="text-left">
                                @if(!is_null($ensayo))
                                    <a target="_blank" href="{{ asset($ensayo->url) }}" class="btn btn-xs btn-primary">Ver Documento</a>
                                @else
                                    <span class="label label-light-danger"><strong>Sin Ensayo</strong></span>
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                  </div>
                </div>
            </div>
        </div>
    </div>
   </div>
  
  
    <form method="POST" action="{{route('agregarObservacion',$postulante->user_id)}}" accept-charset="UTF-8">   
                    {{csrf_field()}}
                   
            <div class="form-group">
                <div class="col">
                    <label for="exampleFormControlTextarea1">Observaciones</label>
                    <textarea  class="sisbeca-input" id="observaciones" for="observaciones" name="observaciones" style="height: 100px;" >{{$postulante->observacion}}</textarea>
                  
                    <button type='submit' title="Aprobar" class='btn sisbeca-btn-primary pull-right'>Guardar</button>
                 
                </div>
            </div>
            </form>
           
     
    
   

@endsection


@section('personaljs')
    <script type="text/javascript">
function aprobar(){
    
    var observaciones = $('#observaciones').val();
    alert("Debe Aceptar los Terminos y Condiciones");
    
}
    
    </script>

    <script>
        Vue.component('modal', {
            template: '#modal-template'
            })

            // start app
            new Vue({
            el: '#app',
            data: {
            showModal: false
            }
        })
    </script>
@endsection
