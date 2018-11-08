<!-- Left Sidebar  -->
<div class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
        <!-- Sidebar navigation-->
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-devider"></li>

                {{--Inicio de Vistas del Administrador--}}
                @if(Auth::user()->admin())
                    <li class="nav-label">Inicio</li>
                    <li> <a class="has-arrow " href="#" aria-expanded="false"><i class="fa fa-user"></i><span class="hide-menu">Usuarios</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{asset(route('mantenimientoUser.index'))}}">Mantenimiento</a></li>
                            @if(\Request::route()->getName()==='mantenimientoUser.create')
                                <li class="opcion-menu-oculta"><a href="{{route('mantenimientoUser.create')}}"></a></li>
                            @endif
                            @if(\Request::route()->getName()==='mantenimientoUser.edit')
                                <li class="opcion-menu-oculta"><a href="{{route(\Request::route()->getName(),$user->id)}}"></a></li>
                            @endif
                        </ul>
                    </li>
                @endif
                {{--Fin de Vistas del Administrador--}}

                {{--Inicio de Vistas del Postulante a Becario--}}
                @if(Auth::user()->rol==='postulante_becario')
                    <li class="nav-label">Inicio</li>
                   @if(Auth::user()->becario->status=='prepostulante')
                   <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-spinner"></i><span class="hide-menu">Mi perfil</span></a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{ route('postulantebecario.datospersonales') }}">Datos Personales</a></li>
                        <li><a href="{{ route('postulantebecario.estudiossecundarios') }}">Estudios Secundarios</a></li>
                        <li><a href="{{ route('postulantebecario.estudiosuniversitarios') }}">Estudios Universitarios</a></li>
                        <li><a href="{{ route('postulantebecario.informacionadicional') }}">Información Adicional</a></li>
                        <li><a href="{{ route('postulantebecario.documentos') }}">Documentos</a></li>

                    </ul>

                   </li>
                    <li>
                        <a href="{{route('postulantebecario.enviarPostulacion', Auth::user()->id)}}" >  <i class="fa fa-send-o"></i><span class="hide-menu">Enviar Postulación</span></a>

                   </li>


                    @else
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-info"></i><span class="hide-menu">Postulación</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{route('status.postulanteBecario')}}">Ver Postulación</a></li>
                        </ul>
                    </li>
                    @endif
                @endif
                {{--Fin de Vistas del Postulante a Becario--}}


                {{--Inicio de Vistas del Postulante a Mentor--}}
                @if(Auth::user()->rol==='postulante_mentor')
                    <li class="nav-label">Inicio</li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-info"></i><span class="hide-menu">Postulación</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{route('status.postulanteMentor')}}">Ver Postulación</a></li>
                        </ul>
                    </li>
                @endif
                {{--Fin de Vistas del Postulante a Mentor--}}


                {{--Inicio de Vistas del  Mentor--}}
                @if(Auth::user()->rol==='mentor')
                    <li class="nav-label">Inicio</li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa  fa-odnoklassniki"></i><span class="hide-menu">Opciones</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{route('listar.becariosAsignados')}}">Ver Becarios asignados</a></li>
                        </ul>
                    </li>
                @endif
                {{--Fin de Vistas del Mentor--}}

                {{--Inicio de Vistas del Coordinador Educativo es decir el Editor--}}
                @if(Auth::user()->rol==='editor')
                    <li class="nav-label">Inicio</li>
                    
                    <li>
                        <a class="has-arrow " href="{{route('costos.index')}}" aria-expanded="false">
                        <i class="fa fa-usd"></i><span class="hide-menu">Costos</span></a>
                        </a>
                    </li>

                    <li> 
                        <a class="has-arrow " href="{{route('noticia.index')}}" aria-expanded="false">
                            <i class="fa fa-list-alt"></i><span class="hide-menu">Publicaciones</span>
                        </a>
                        
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{route('noticia.index')}}">Listar publicaciones</a></li>
                            <li><a href="{{route('noticia.create')}}">Crear publicación</a></li>
                            @if(\Request::route()->getName()==='mantenimientoNoticia.create')
                                <li class="opcion-menu-oculta"><a href="{{route('mantenimientoNoticia.create')}}"></a></li>
                            @endif
                            @if(\Request::route()->getName()==='mantenimientoNoticia.edit')
                                <li class="opcion-menu-oculta"><a href="{{route(\Request::route()->getName(),$noticia->id)}}"></a></li>
                            @endif
                        </ul>
                    </li>

                    <li> <a class="has-arrow " href="{{route('contacto.index')}}" aria-expanded="false"><i class="fa fa-envelope-o">
                        </i><span class="hide-menu">Contactos</span></a>
                    </li>

                    <li> <a class="has-arrow " href="{{route('charla.index')}}" aria-expanded="false"><i class="fa fa-comments-o">
                        </i><span class="hide-menu">Calendario Charlas</span></a>
                    </li>

                    <li> <a class="has-arrow " href="{{route('banner.index')}}" aria-expanded="false"><i class="fa fa-picture-o">
                        </i><span class="hide-menu">Banner</span></a>
                    </li>

                    <li class="nav-label">Gestion de Cronogramas</li>
                  {{--  <li> <a class="has-arrow " href="#" aria-expanded="false"><i class="fa fa-suitcase"></i><span class="hide-menu">Talleres y Voluntareados</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="#">Talleres</a></li>
                            <li><a href="#">Voluntareados</a></li>
                        </ul>
                    </li>
                    <li> <a class="has-arrow " href="#" aria-expanded="false"><i class="fa fa-suitcase"></i><span class="hide-menu">Cursos y ChatClubs</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="#">CVA</a></li>
                            <li><a href="#">ChatClubs</a></li>
                        </ul>
                    </li> --}}
                @endif
                {{--Fin de Vistas del Coordinador Educativo es decir el Editor--}}

                {{--Inicio de Vistas del Directivo Unicamente--}}
                @if(Auth::user()->rol==='directivo')
                   
                    
                      <li class="nav-label">Inicio</li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-plus"></i><span class="hide-menu">Postulaciones
                                @if($numT>0)
                                    <span class="label label-rouded label-danger pull-center">{{$numT}}</span>
                                @endif
                        </span></a>

                        <ul aria-expanded="false" class="collapse">

                                          
                                          

                            <li> <a class="has-arrow" href="#" aria-expanded="false">Becarios</a>
                                <ul aria-expanded="false" class="collapse">
                                    <li><a href="{{route('listarPostulantesBecarios',"2")}}">Listar Postulantes</a></li>
                                    <li><a href="{{route('listarPostulantesBecarios',"0")}}">Asignar Entrevistas</a></li>
                                    <li><a href="{{route('listarPostulantesBecarios',"1")}}">Gestion Entrevistas</a></li>
                                    <li><a href="{{route('listarPostulantesBecarios',"3")}}">Asignar Nuevo Ingreso</a></li>
                                </ul>

                            </li>
                     
                                         
                            <li><a href="{{ route('listarPostulantesMentores')}}">Mentores</a></li>
                            
                          

                        </ul>
                    </li>


                    <li class="nav-label">Gestionar</li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa  fa-file-excel-o"></i><span class="hide-menu">Nomina
                                @if($numNominas>0)
                                    <span class="label label-rouded label-danger pull-center">{{$numNominas}}</span>
                                @endif
                            </span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ route('nomina.procesar') }}">Nóminas por Procesar</a>
                            </li>
                            <li><a href="{{ route('nomina.listar') }}">Nóminas Generadas</a></li>
                            <li><a href="{{ route('nomina.pagadas') }}">Nóminas Pagadas</a></li>
                        </ul>
                    </li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-user-times"></i><span class="hide-menu">Desincorporaciones
                                @if($numdesincorporaciones>0)
                                    <span class="label label-rouded label-danger pull-center">{{$numdesincorporaciones}}</span>
                                @endif

                            </span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ route('desincorporaciones.listar') }}">Desincorporación</a>
                            </li>

                        </ul>
                    </li>
                @endif
                {{--Fin de Vistas del Directivo unicamente--}}


                {{--Inicio de Vistas del Coordinador--}}
                @if(Auth::user()->rol==='coordinador')
                    <li class="nav-label">Inicio</li>
                    <li> <a class="has-arrow  " href="javascript:void(0)" aria-expanded="false"><i class="fa fa-street-view"></i><span class="hide-menu">Seguimientos</span></a>
                      {{--  <ul aria-expanded="false" class="collapse">
                            <li><a href="#">CVA</a></li>
                            <li><a href="#">Universidad</a></li>
                            <li><a href="#">Voluntareados</a></li>
                            <li><a href="#">Cursos y Talleres</a></li>
                            <li><a href="#">ChatClubs</a></li>

                        </ul> --}}
                    </li>
                    <li class="nav-label">Gestionar </li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa  fa-users"></i><span class="hide-menu">Mentorias</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{route('asignarBecarios')}}">Asignacion de Mentores</a></li>
                        </ul>
                    </li>

                @endif
                {{--Fin de Vistas del Coordinador--}}
                
                {{--Inicio de Vista Compartida Coordinador/Directivo --}}
                @if((Auth::user()->rol==='coordinador') || (Auth::user()->rol==='directivo'))
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-question-circle"></i><span class="hide-menu">Solicitudes/Reclamos
                                @if($numSoliBecarios>0)
                                    <span class="label label-rouded label-danger pull-center">{{$numSoliBecarios}}</span>
                                @endif
                        </span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{route('gestionSolicitudes.listar')}}">Gestionar</a></li>
                        </ul>
                    </li>
                    <li class="nav-label">Consultas y Reportes</li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-users"></i><span class="hide-menu">Becarios</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ route('becarios.listar') }}">Listar</a></li>
                       {{--     <li><a href="#">Reportes de Notas</a></li>
                            <li><a href="#">Consultar Mejor Promedio</a></li> --}}
                        </ul>
                    </li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-street-view"></i><span class="hide-menu">Mentorias</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{ route('mentores.listar') }}">Listar Mentores</a></li>
                        </ul>
                    </li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-clone"></i><span class="hide-menu">Reportes de Solicitudes</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{route('formularioReporte.solicitudes')}}">Reporte Solicitud</a></li>
                        </ul>
                    </li>
                    @if((Auth::user()->rol==='directivo'))
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-eject"></i><span class="hide-menu">Egresados</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('listar.becariosGraduados')}}">Graduados</a></li>
                                <li><a href="{{route('listar.becariosInactivos')}}">Inactivos</a></li>
                            </ul>
                        </li>
                        @endif
                @endif
                {{--Fin d Vista Compartida Coordinador/Directivo --}}



                {{--Inicio de Vista de Becarios Unicamente--}}
                @if(Auth::user()->rol==='becario')
                    <li class="nav-label">Inicio</li>
                @if(Auth::user()->becario->acepto_terminos==0)
                    <li> <a class="has-arrow  " href="javascript:void(0)" aria-expanded="false"><i class="fa fa-bank"></i><span class="hide-menu">Terminos Generales</span></a>

                    </li>
                    @else
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-bank"></i><span class="hide-menu">Banco</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{route('verCuentaBancaria')}}">Ver o Cargar Cuenta</a></li>
                            <li><a href="{{route('carta.bancaria')}}" target="_blank">Carta Bancaria</a></li>
                        </ul>
                    </li>

                    <li class="nav-label">Control de Estudios</li>
                   {{-- <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa  fa-graduation-cap"></i><span class="hide-menu">CVA</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="#">Cargar Registro</a></li>
                            <li><a href="#">Notas(Periodo Lectivo)</a></li>
                            <li><a href="#">Carta CVA</a></li>
                        </ul>
                    </li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa  fa-graduation-cap"></i><span class="hide-menu">Cursos, Talleres </span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="#">Cargar Cursos</a></li>
                            <li><a href="#">Cargar Talleres</a></li>
                        </ul>
                    </li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa  fa-graduation-cap"></i><span class="hide-menu">ChatClubs</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="#">Pre-Incripcion ChatClubs</a></li>
                            <li><a href="#">Cargar ChatClubs</a></li>
                        </ul>
                    </li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa  fa-graduation-cap"></i><span class="hide-menu">Voluntareados</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="#">Pre-Incripcion Voluntareados</a></li>
                            <li><a href="#">Cargar Voluntareados</a></li>
                        </ul>
                    </li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa  fa-graduation-cap"></i><span class="hide-menu">Universidad</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="#">Cargar Comprobante</a></li>
                            <li><a href="#">Notas(Periodo Lectivo)</a></li>
                        </ul>
                    </li> --}}
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa  fa-book"></i><span class="hide-menu">Libros</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="{{route('crearVerFacturas')}}">Cargar Facturas</a></li>
                            </ul>
                        </li>

                    <li class="nav-label">Opciones</li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-file-pdf-o"></i><span class="hide-menu">Consultas y Reportes</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{route('ver.mentorAsignado')}}">Ver Mentor Asignado</a></li>
                            <li><a href="{{ route('postulanteObecario.perfil',Auth::user()->id) }}">Consultar Expendiente</a></li>

                        </ul>
                    </li>
                    @endif
                @endif
                {{--Fin de Vista de Becarios Unicamente--}}

                {{--Inicio de Vista Compartida Becarios/Mentores--}}
                @if((Auth::user()->rol==='mentor')|| (Auth::user()->rol==='becario' && Auth::user()->becario->acepto_terminos==1))
                    <li class="nav-label">Solicitudes y Reclamos</li>
                    <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-envelope-square"></i><span class="hide-menu">Solicitud/Reclamo</span></a>
                        <ul aria-expanded="false" class="collapse">
                            <li><a href="{{route('solicitud.showlist')}}">Petición</a></li>
                        </ul>
                    </li>
                @endif


                 @if(Auth::user()->rol==='becario')

                <li>
                    <a class="has-arrow  " href="#" aria-expanded="false">
                        <i class="fa  fa-graduation-cap"></i>
                        <span class="hide-menu">Notas Académicas</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('periodos.index')}}">Mis Periodos</a></li>
                    </ul>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('periodos.crear',Auth::user()->id)}}">Cargar Periodo</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow  " href="{{route('cursos.index')}}" aria-expanded="false">
                        <i class="fa  fa-graduation-cap"></i>
                        <span class="hide-menu">CVA</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('cursos.index')}}">Mis CVA</a></li>
                    </ul>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('cursos.crear',Auth::user()->id)}}">Cargar CVA</a></li>
                    </ul>
                </li>
                <li>
                    <a class="has-arrow  " href="#" aria-expanded="false">
                        <i class="fa  fa-graduation-cap"></i>
                        <span class="hide-menu">Voluntariado</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('voluntariados.index')}}">Mis Voluntariados</a></li>
                    </ul>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('voluntariados.crear',Auth::user()->id)}}">Cargar Voluntariado</a></li>
                    </ul>
                </li> 
                @endif
                @if(Auth::user()->rol==='admin')
                 <li>
                    <a class="has-arrow  " href="#" aria-expanded="false">
                        <i class="fa  fa-graduation-cap"></i>
                        <span class="hide-menu">Notas Académicas</span>
                    </a>
                    <ul aria-expanded="false" class="collapse">
                        <li><a href="{{route('periodos.todos')}}">Listar Periodos</a></li>
                    </ul>
                </li>
                @endif

                {{-- Fin de Vista Compartida Becarios/Mentores--}}

            </ul>
        </nav>
        <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
</div>