@extends('sisbeca.layouts.main')
@section('title','Perfil de '.$postulante->user->nombreyapellido())
@section('content')


<div class="text-right col-12" align="right" >
<a href="{{URL::previous()}}" class=" btn btn-sm sisbeca-btn-primary">Atrás</a>
</div>
<div class="container">
    <div class="card card-body bg-light border border-info p-2">
        <div class="col-xs-12 col-sm-8 col-md-8">

                <div class="row">
                    <div class="col xs-6 col-sm-4 col-md-4 p-t-20">
                            @if($img_perfil->count()>0)
                                <img src="{{asset($img_perfil[0]->url)}}" class="img-rounded img-responsive">
                            @else
                                @if($postulante->user->sexo==='femenino')
                                    <img src="{{asset('images/perfil/femenino.png')}}" class="img-rounded img-responsive">
                                @else
                                    <img src="{{asset('images/perfil/masculino.png')}}" class="img-rounded img-responsive">
                                @endif
                            @endif
                    <br/>
                    </div>
                    <div class="col-sm-6 col-md-8 p-4">
                        <h3>{{$postulante->user->name}} {{$postulante->user->last_name }}</h3>
                        <p>
                        @if($postulante->status==='postulante')
                                <span class="label label-default">Sin Revisar</span>
                            @else
                                @if($postulante->status==='entrevista')
                                    <span class="label label-inverse">Aprobado para Entrevista</span>
                                @elseif($postulante->status==='entrevistado')
                                    <span class="label label-warning">Entrevistado</span>
                                @elseif($postulante->status==='no_entrevista')
                                <span class="label label-danger">Rechazado</span>
                                @elseif($postulante->status==='rechazado')
                                <span class="label label-danger">Rechazado</span>
                                @elseif($postulante->status=='activo')
                                    @if($postulante->acepto_terminos=='false')
                                    <span class="label label-success">Aprobado a ProExcelencia</span>
                                    @else
                                    <span class="label label-success">Becario</span>
                                    @endif
                                @elseif($postulante->status==='probatorio1')
                                <span class="label label-warning">Probatorio1</span>
                                @elseif($postulante->status==='probatorio2')
                                <span class="label label-danger">Probatorio2</span>
                                @elseif($postulante->status==='inactivo')
                                <span class="label label-danger">Inactivo</span>
                                @elseif($postulante->status==='desincorporado')
                                <span class="label label-danger">Desincorporado</span>
                                @else
                                    <span class="label label-default">Egresado</span>
                                @endif
                            @endif
                            <br/>
                            <i class="fa fa-envelope"> &nbsp;</i>Email: {{$postulante->user->email}}
                            <br />
                            <i class="fa fa-user"> &nbsp;</i>Cedula: {{$postulante->user->cedula}}
                            <br/>
                            <i class="fa fa-phone">&nbsp; </i>Teléfono: {{$postulante->celular}}
                            <br/>
                            <i class="fa fa-graduation-cap">&nbsp; </i>Promedio Bachiller: {{$postulante->promedio_bachillerato}}
                            <br/>
                            <i class="fa fa-map-pin">&nbsp; </i>Dirección: {{$postulante->direccion_permanente}}
                        </p>
                    </div>
                </div>

        </div>
    </div>
    @if($postulante->status==='postulante')

    <div align="center">
    <h3>¿Desea seleccionar a {{$postulante->user->name.' '.$postulante->user->last_name}} para <b>Entrevista? </b>
        <button type='button' title="Rechazar" class="btn btn-sm sisbeca-btn-default" data-toggle='modal' data-target='#modal-default' > <i class="fa fa-times" data-target="modal-asignar"></i></button>
        <button type='button' title="Aprobar" class="btn btn-sm sisbeca-btn-success" data-toggle='modal' data-target='#modal' ><i class="fa fa-check" data-target="modal-asignar"></i></button>&nbsp;&nbsp;</h3>
    </div>
    @endif
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
                                        <a target="_blank" href="{{ asset($fotografia->url) }}" class="btn btn-xs sisbeca-btn-primary">Ver Imagen</a>
                                    @else
                                        <span class="label label-default"><strong>Sin Fotografia</strong></span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Copia Cédula</strong></td>
                                <td class="text-left">
                                    @if(!is_null($cedula))
                                        <a target="_blank" href="{{ asset($cedula->url) }}" class="btn btn-xs sisbeca-btn-primary">Ver Imagen</a>
                                    @else
                                        <span class="label label-default"><strong>Sin Cedula</strong></span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Constancia CNU</strong></td>
                                <td class="text-left">
                                    @if(!is_null($constancia_cnu))
                                        <a target="_blank" href="{{ asset($constancia_cnu->url) }}" class="btn btn-xs sisbeca-btn-primary">Ver Documento</a>
                                    @else
                                        <span class="label label-default"><strong>Sin Constancia CNU</strong></span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Calificaciones de Bachillerato</strong></td>
                                <td class="text-left">
                                    @if(!is_null($calificaciones_bachillerato))
                                        <a target="_blank" href="{{ asset($calificaciones_bachillerato->url) }}" class="btn btn-xs sisbeca-btn-primary">Ver Documento</a>
                                    @else
                                        <span class="label label-default"><strong>Sin Calificaciones de Bachillerato</strong></span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Constancia de Aceptación</strong></td>
                                <td class="text-left">
                                    @if(!is_null($constancia_aceptacion))
                                        <a target="_blank" href="{{ asset($constancia_aceptacion->url) }}" class="btn btn-xs sisbeca-btn-primary">Ver Documento</a>
                                    @else
                                        <span class="label label-default"><strong>Sin Constancia de Aceptación</strong></span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Constancia de Estudio</strong></td>
                                <td class="text-left">
                                    @if(!is_null($constancia_estudios))
                                        <a target="_blank" href="{{ asset($constancia_estudios->url) }}" class="btn btn-xs sisbeca-btn-primary">Ver Documento</a>
                                    @else
                                        <span class="label label-default"><strong>Sin Constancia de Estudio</strong></span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Calificaciones de la Universidad</strong></td>
                                <td class="text-left">
                                    @if(!is_null($calificaciones_universidad))
                                        <a target="_blank" href="{{ asset($calificaciones_universidad->url) }}" class="btn btn-xs sisbeca-btn-primary">Ver Documento</a>
                                    @else
                                        <span class="label label-default"><strong>Sin Calificaciones de la Universidad</strong></span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Constanca de Trabajo</strong></td>
                                <td class="text-left">
                                    @if(!is_null($constancia_trabajo))
                                        <a target="_blank" href="{{ asset($constancia_trabajo->url) }}" class="btn btn-xs sisbeca-btn-primary">Ver Documento</a>
                                    @else
                                        <span class="label label-default"><strong>Sin Constanca de Trabajo</strong></span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Declaración de Impuestos</strong></td>
                                <td class="text-left">
                                    @if(!is_null($declaracion_impuestos))
                                        <a target="_blank" href="{{ asset($declaracion_impuestos->url) }}" class="btn btn-xs sisbeca-btn-primary">Ver Documento</a>
                                    @else
                                        <span class="label label-default"><strong>Sin Declaración de Impuestos</strong></span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Recibo de pago</strong></td>
                                <td class="text-left">
                                    @if(!is_null($recibo_pago))
                                        <a target="_blank" href="{{ asset($recibo_pago->url) }}" class="btn btn-xs sisbeca-btn-primary">Ver Documento</a>
                                    @else
                                        <span class="label label-default"><strong>Sin Recibo de pago</strong></span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Referencia del Profesor 1</strong></td>
                                <td class="text-left">
                                    @if(!is_null($referencia_profesor1))
                                        <a target="_blank" href="{{ asset($referencia_profesor1->url) }}" class="btn btn-xs sisbeca-btn-primary">Ver Documento</a>
                                    @else
                                        <span class="label label-default"><strong>Sin Referencia del Profesor 1</strong></span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Referencia del Profesor 2</strong></td>
                                <td class="text-left">
                                    @if(!is_null($referencia_profesor2))
                                        <a target="_blank" href="{{ asset($referencia_profesor2->url) }}" class="btn btn-xs sisbeca-btn-primary">Ver Documento</a>
                                    @else
                                        <span class="label label-default"><strong>Sin Referencia del Profesor 2</strong></span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left"><strong>Ensayo</strong></td>
                                <td class="text-left">
                                    @if(!is_null($ensayo))
                                        <a target="_blank" href="{{ asset($ensayo->url) }}" class="btn btn-xs sisbeca-btn-primary">Ver Documento</a>
                                    @else
                                        <span class="label label-default"><strong>Sin Ensayo</strong></span>
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

        @if((Auth::user()->rol=='coordinador')||(Auth::user()->rol=='directivo')||(Auth::user()->rol=='entrevistador')||(Auth::user()->rol=='mentor'))
        <div class="panel-group Material-default-accordion" id="docs-entrevista" role="tablist" aria-multiselectable="true">

                <div class="panel panel-default-accordion mb-3">
                    <div class="panel-accordion" role="tab" id="heading">
                        <h5 class="panel-title">
                            <a class="collapsed" role="button" data-toggle="collapse" data-parent="#docs-entrevista" href="#docs-entrevistadores" aria-expanded="false" aria-controls="docs-entrevistadores">
                    Documentos Entrevista
                            </a>
                        </h5>
                    </div>
                    <div id="docs-entrevistadores" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading">
                        <div align="justify" class="panel-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tbody>

                                @foreach( $entrevistadores as $entrevistador)
                                <tr>
                                        <td class="text-left"><strong> Informe de {{$entrevistador->user->nombreyapellido()}}</strong></td>
                                        <td class="text-left">
                                            @if(!is_null($entrevistador->documento))
                                            <a target="_blank" href="{{asset($entrevistador->documento)}}" class="btn btn-xs sisbeca-btn-primary"> Ver Informe</a>
                                            @else
                                            <span class="label label-default"><strong>No ha cargado Documento</strong></span>
                                            @endif
                                        </td>
                                </tr>
                                @endforeach
                                <tr>
                                        <td class="text-left"><strong> Informe Final</strong></td>
                                        <td class="text-left">
                                            @if(!is_null($postulante->documento_final_entrevista))
                                            <a target="_blank" href="{{asset($postulante->documento_final_entrevista)}}" class="btn btn-xs sisbeca-btn-primary"> Ver Informe</a>
                                            @else
                                            <span class="label label-default"><strong>No ha cargado Documento</strong></span>
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
            @endif
    </div>


    <form method="POST" action="{{route('agregarObservacion',$postulante->user_id)}}" accept-charset="UTF-8">
                    {{csrf_field()}}

            <div class="form-group">
                <div class="col">
                    <label for="exampleFormControlTextarea1">Observaciones: </label>
                    <textarea  class="sisbeca-input" id="observaciones" for="observaciones" name="observaciones" style="height: 100px;" >{{$postulante->observacion}}</textarea>

                    <button type='submit' title="Aprobar" class='btn sisbeca-btn-primary pull-right'>Guardar</button>

                </div>
            </div>
    </form>
    <!-- Modal para aprobar -->
    <div class="modal fade" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"> &times;</span>
                </button>

                <h5 class="modal-title pull-left"><strong>Confirmación</strong></h5>

            </div>

            <form method="POST" action={{route('aprobarParaEntrevista',$postulante->user_id)}} accept-charset="UTF-8">
                {{csrf_field()}}
                {{method_field('PUT')}}
                <input type="hidden" id='valor' name="valor"  value="1">

                <div class="modal-body">
                    <br>
                    ¿Está seguro que desea <strong class="letras-verdes">Seleecionar</strong> a {{$postulante->user->name}} {{$postulante->user->last_name}} <strong> para ir a entrevista?</strong>
                </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-sm sisbeca-btn-default pull-right" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-sm sisbeca-btn-primary pull-right">Si</button>

            </div>

            </form>
            </div>
        </div>
    </div>
    <!-- Modal para aprobar -->

    <!-- Modal para rechazar -->
    <div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
                <h4 class="modal-title pull-left">Confirmación</h4>
                <a class="pull-right mr-1" href="javascript(0)" data-dismiss="modal" ><i class="fa fa-remove"></i></a>
        </div>
        <div class="modal-body">
            <br>
            ¿Está seguro que desea <strong class="letras-rojas">Descartar</strong> a {{$postulante->user->name}} {{ $postulante->user->last_name}} <strong>para ir a entrevista?</strong>
        </div>
        <form method="POST" action={{route('aprobarParaEntrevista', $postulante->user_id)}} accept-charset="UTF-8">

            {{csrf_field()}}
            {{method_field('PUT')}}

            <input type="hidden" id='valor' name="valor"  value="0">

            <div class="modal-footer">
                <button type="button" class="btn btn-sm sisbeca-btn-default pull-right" data-dismiss="modal">No</button>
                <button type="submit" class="btn btn-sm sisbeca-btn-primary pull-right" >Si</button>
            </div>

        </form>
        </div>
    </div>

    </div>

@endsection


@section('personaljs')
    <script type="text/javascript">
    function aprobar(){
        var observaciones = $('#observaciones').val();
        alert("Debe Aceptar los Terminos y Condiciones");
    }
    </script>

@endsection
