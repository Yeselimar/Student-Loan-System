@extends('sisbeca.layouts.main')
@if(Auth::user()->rol=='becario')
    @section('title','Becario')
@else
    @section('title','Postulante Becario')
@endif
@section('subtitle','Perfil')
@section('content')
    <div class="card">
             
        <div class="card-body">
            <div class="card-two">
				<div class="text-right col-12" align="right">
					<strong>Status Actual: </strong>
					@if($becario->status==='activo')
						<span class="label label-light-success"><strong>Activo</strong></span>
					@else
						@if($becario->status==='probatorio1')
							<span class="label label-light-warning"><strong>En Probatorio 1</strong></span>
						@else
							@if($becario->status==='probatorio2')
								<span class="label label-light-danger"><strong>En Probatorio 2</strong></span>
							@else
								<span class="label label-light-info"><strong>{{ucwords($becario->status)}}</strong></span>
							@endif
						@endif
					@endif

				</div>

				<a href="{{  URL::previous() }}" class=" btn-sm btn-danger">Atrás</a>
                <header>
                    <div class="avatar">
                        @if(!is_null($img_perfil))
                            <img src="{{asset($img_perfil->url)}}" style="height: 95px !important;">

                        @else

                            @if($becario->user->sexo==='femenino')
                                <img src="{{asset('images/perfil/femenino.png')}}" style="height: 95px !important;">
                            @else
                                <img src="{{asset('images/perfil/masculino.png')}}" style="height: 95px !important;">

                            @endif

                        @endif
                    </div>
                </header>

                <h3>{{$becario->user->name}}</h3>
                <div class="desc">
                   Rol: 
                   @if($becario->user->rol=='becario')
                   Becario
                   @else
                   Postulante Becario
                   @endif
                </div>
				<div class="contacts">
					@if(is_null($becario->user->sexo))
					<span class=" fa fa-venus-mars"> No Definido</span>
						@else
						<span class=" fa fa-venus-mars"> {{ucwords($becario->user->sexo)}}</span>
					@endif
						&nbsp;&nbsp;&nbsp;
						@if(is_null($becario->user->edad))
							<span class=" fa fa-calendar"> S/D</span>
						@else
							<span class=" fa fa-calendar"> {{$becario->user->edad}} Años</span> &nbsp;&nbsp;&nbsp;
						@endif

					<span class="fa fa-birthday-cake"> {{ date("d/m/Y", strtotime($becario->user->fecha_nacimiento)) }}</span>
					<div class="clear"></div>
				</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3 col-xs-6 b-r"> <strong>Nombre Completo</strong>
                <br>
                <p class="text-muted">{{$becario->user->name.' '.$becario->user->last_name}}</p>
            </div>
            <div class="col-md-3 col-xs-6 b-r"> <strong>Cedula</strong>
                <br>
                <p class="text-muted">{{$becario->user->cedula}}</p>
            </div>
            <div class="col-md-3 col-xs-6 b-r"> <strong>Email</strong>
                <br>
                <p class="text-muted">{{$becario->user->email}}</p>
            </div>
            <div class="col-md-3 col-xs-6"> <strong>Dirección</strong>
                <br>
                <p class="text-muted">{{$becario->user->descripcion}}</p>
            </div>
        </div>
    </div>

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
                					<td class="text-left">{{ $becario->lugar_nacimiento }}</td>
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
                					<td class="text-left">{{ $becario->direccion_permanente }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Dirección Temporal</strong></td>
                					<td class="text-left">{{ $becario->direccion_temporal }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Teléfono Celular</strong></td>
                					<td class="text-left">{{ $becario->celular }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Teléfono Habitación</strong></td>
                					<td class="text-left">{{ $becario->telefono_habitacion }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Teléfono Pariente</strong></td>
                					<td class="text-left">{{ $becario->telefono_pariente }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Promedio Ingreso Familiar</strong></td>
                					<td class="text-left">{{ $becario->ingreso_familiar }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Trabaja</strong></td>
                					<td class="text-left">{{ $becario->getTrabaja() }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Lugar de Trabajo</strong></td>
                					<td class="text-left">{{ $becario->lugar_trabajo }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Cargo que desempeña en el trabajo</strong></td>
                					<td class="text-left">{{ $becario->cargo_trabajo }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Horas mensuales de trabajo</strong></td>
                					<td class="text-left">{{ $becario->horas_trabajo }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Contribuye con el ingreso familiar</strong></td>
                					<td class="text-left">{{ $becario->getContribuyeIngreso() }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Contribuye con el ingreso familiar (en porcentaje) </strong></td>
                					<td class="text-left">{{ $becario->getContribuyePorcentaje() }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Vive con </strong></td>
                					<td class="text-left">{{ $becario->vives_con }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Vive con otros (en específico) </strong></td>
                					<td class="text-left">{{ $becario->vives_otros }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Tipo Vivienda </strong></td>
                					<td class="text-left">{{ $becario->tipo_vivienda }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Composición Familiar</strong></td>
                					<td class="text-left">{{ $becario->composicion_familiar }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Ocupación del Padre</strong></td>
                					<td class="text-left">{{ $becario->ocupacion_padre }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Nombre de la empresa del Padre</strong></td>
                					<td class="text-left">{{ $becario->nombre_empresa_padre }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Experiencia Laboral del Padre</strong></td>
                					<td class="text-left">{{ $becario->getExperienciaPadre() }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Ocupación del Madre</strong></td>
                					<td class="text-left">{{ $becario->ocupacion_madre }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Nombre de la empresa del Madre</strong></td>
                					<td class="text-left">{{ $becario->nombre_empresa_madre }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Experiencia Laboral del Madre</strong></td>
                					<td class="text-left">{{ $becario->getExperienciaMadre() }}</td>
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
                					<td class="text-left">{{ $becario->nombre_institucion }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Dirección de la institución</strong></td>
                					<td class="text-left">{{ $becario->direccion_institucion }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Director de la institución</strong></td>
                					<td class="text-left">{{ $becario->director_institucion }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Bachiller en</strong></td>
                					<td class="text-left">{{ $becario->bachiller_en }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Promedio en Bachillerato</strong></td>
                					<td class="text-left">{{ $becario->promedio_bachillerato }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Actividades Extracurriculares</strong></td>
                					<td class="text-left">{{ $becario->actividades_extracurriculares }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Lugar de la Labor Social</strong></td>
                					<td class="text-left">{{ $becario->lugar_labor_social }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Dirección de la Labor Social</strong></td>
                					<td class="text-left">{{ $becario->direccion_labor_social }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Supervisor de la Labor Social</strong></td>
                					<td class="text-left">{{ $becario->supervisor_labor_social }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Habla otro idioma</strong></td>
                					<td class="text-left">{{ $becario->getHablaOtroIdioma() }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Idioma que habla</strong></td>
                					<td class="text-left">{{ $becario->habla_idioma }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Nivel de conocimiento del idioma</strong></td>
                					<td class="text-left">{{ $becario->nivel_idioma }}</td>
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
                					<td class="text-left">{{ $becario->getInicioUniversidad() }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Universidad</strong></td>
                					<td class="text-left">{{ $becario->nombre_universidad }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Carrera</strong></td>
                					<td class="text-left">{{ $becario->carrera_universidad }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Costo de la matrícula académica</strong></td>
                					<td class="text-left">{{ $becario->costo_matricula }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Promedio Universidad</strong></td>
                					<td class="text-left">{{ $becario->promedio_universidad }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Periódo Académico</strong></td>
                					<td class="text-left">{{ $becario->periodo_academico }}</td>
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
                					<td class="text-left">{{ $becario->medio_proexcelencia }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Otro medio de como se enteró del Programa Proexcelencia</strong></td>
                					<td class="text-left">{{ $becario->otro_medio_proexcelencia }}</td>
                				</tr>
                				<tr>
                					<td class="text-left"><strong>Motivo de la beca</strong></td>
                					<td class="text-left">{{ $becario->motivo_beca }}</td>
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

@endsection