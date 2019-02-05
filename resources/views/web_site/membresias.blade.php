@extends('web_site.layouts.main')
@section('title', "Membresias")
@section('content')
   <!-- Seccion Principal -->
   <section id="x" class="x" data-stellar-background-ratio="0.2">
      <br/><br/><br/>
      <!--
      <div class="container">
         <div class="section-header">
            <h2 class="section-title">Membresías</h2>
            <hr class="lines">
            <p class="section-subtitle" >AVAA financia sus programas de inversión social a través de distintos aportes;  donaciones directas de empresas y personas en Venezuela y Estados Unidos.</p>
            <p class="section-subtitle">
               También se financia a través de otros productos cuyos fondos permiten cubrir gastos indirectos, tales como el Torneo de Golf de la Amistad; la Feria Educativa Internacional; y la Feria de Empleo y Pasantías.
            </p>
            <br/>
         </div>
         <div class="row">
            <div class="col-lg-12 col-md-6 col-xs-4">
               <div class="container">
                  <div class="row" id="contentPrincipal">
                     <div class="col-lg-6 col-sm-6 col-xs-6 box-item" >
                        <a class="page-scroll" href="#membresias-corporativas">
                           <span class="icon">
                           <i class="lnr lnr-apartment icon-contenedor"></i>
                           </span>
                           <div class="text">
                              <p class="titulo-contenedor text-center h6">MEMBRESÍAS CORPORATIVAS</p>
                           </div>
                        </a>
                     </div>
                     <div class="col-lg-6 col-sm-6 col-xs-6 box-item" >
                        <a class="page-scroll" href="#membresia-institucional">
                           <span class="icon">
                           <i class="fa fa fa-users icon-contenedor"></i>
                           </span>
                           <div class="text">
                              <p class="titulo-contenedor text-center h6">MEMBRESÍA INSTITUCIONAL</p>
                           </div>
                        </a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      -->
   </section>
   <!-- Fin Seccion Principal -->

   <div class="linea-sobra"></div>
  
   <div class="container-cabecera">
      <img src="{{asset("info_sitio/img/cabeceras/membresia.png")}}" alt="AVAA - Membresías" class="cabecera-imagen">
      <div class="cabecera-titulo">
      <p class="h1">Membresías</p>
    </div>
   </div>

   <div style="height: 50px" id="membresias-corporativas"></div>

   <!-- Membresias Cooporativas-->
   <section id="membresiasCorporativas" class="section">
      <div class="container">
         <div class="section-header">
            <h2 class="section-title wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">Membresías Coorporativas</h2>
            <hr class="lines wow zoomIn" data-wow-delay="0.3s">
            <p class="section-subtitle wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">En esta sección se describen las membresías Coorporativas que existen actualmente en el programa AVAA .</p>
         </div>
         <section class="Material-accordion-section section-padding">
            <div class="">
               <div class="row letrasResponsive">
                  <div class="col-md-12 wow animated fadeInUp animated" data-wow-delay=".2s" style="visibility: visible;-webkit-animation-delay: .2s; -moz-animation-delay: .2s; animation-delay: .2s;" style="border: 1px solid red"> 
                     <ul align="justify">
                        <li class="list-group-item">
                           <p >
                              La Membresía Nacional puede realizarse de manera individual o por medio de una institución: 
                           </p>
                        </li>
                     </ul>
                     <div class="panel-group Material-default-accordion" id="Material-accordion3" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default mb-3">
                           <div class="panel-heading" role="tab" id="head1">
                              <h4 class="panel-title">
                                 <a role="button" data-toggle="collapse" data-parent="#Material-accordion3" href="#coll1" aria-expanded="false" aria-controls="coll1" class="collapsed">
                                 Membresía Individual o VIP
                                 </a>
                              </h4>
                           </div>
                           <div id="coll1" class="panel-collapse in collapse" role="tabpanel" aria-labelledby="head1" style="">
                              <div class="contenidoDeList panel-body" align="justify">
                                 <p >
                                    Son ejecutivos que se afilian de manera personal con el fin de participar en las actividades de la Asociación, con un aporte de Bs.{{number_format($costos->costo_membresia, 2, ',', '.')}} (+ IVA) anual y, reciben los siguientes beneficios:
                                 </p>
                                 <ul>
                                    <li  >
                                       <p >Carta de afiliación que lo acredita como miembro de AVAA. </p>
                                    </li>
                                    <li  >
                                       <p  >Descuentos especiales en nuestras asesorías.</p>
                                    </li>
                                    <li  >
                                       <p  >Información directa sobre oportunidades de cursos y becas en el exterior. </p>
                                    </li>
                                    <li  >
                                       <p  >Nombre en página web de AVAA.</p>
                                    </li>
                                    <li  >
                                       <p  >Información directa de los eventos AVAA.</p>
                                    </li>
                                    <li  >
                                       <p  >Mención pública de reconocimiento en eventos de la AVAA.</p>
                                    </li>
                                    <li  >
                                       <p >Copia digital del anuario del Programa Excelencia. 
                                          Otros servicios.
                                       </p>
                                    </li>
                                 </ul>
                                 <p style="font-size: 19px">
                                    <strong>¿Desea ser Miembro Individual de AVAA?</strong>
                                 </p>
                                 <p>
                                    <span>Descargue la Planilla de Solicitud de Afiliación y contáctenos.</span>
                                 </p>
                              </div>
                           </div>
                        </div>
                        <div class="panel panel-default mb-3">
                           <div class="panel-heading" role="tab" id="head2">
                              <h4 class="panel-title">
                                 <a class="collapsed" role="button" data-toggle="collapse" data-parent="#Material-accordion2" href="#coll2" aria-expanded="false" aria-controls="coll2">
                                 Fondo de Alianzas y Becas Estratégicas (FABE)
                                 </a>
                              </h4>
                           </div>
                           <div id="coll2" class="panel-collapse collapse" role="tabpanel" aria-labelledby="head2" style="">
                              <div class="contenidoDeList panel-body"  align="justify">
                                 <p>
                                    Las empresas pueden contribuir con la formación y educación integral de Becarios AVAA a través de convenios de inversión social (Fondo de Alianzas y Becas Estratégicas, FABE). Estos aportes son donaciones directas al Programa Excelencia AVAA y, son considerados deducibles de ISLR en Venezuela y Estados Unidos.
                                 </p>
                                 <p >
                                    Actualmente AVAA tiene 41 empresas como miembros corporativos en Venezuela y 7 en Estados Unidos.
                                 </p>
                                 <p>
                                    Los convenios de inversión son:
                                 </p>
                                 <ul>
                                    <p  >
                                       <strong>DONANTE PLATINUM</strong>
                                    </p>
                                    <li  >
                                       <p >Formamos Talentos del Futuro </p>
                                    </li>
                                    <li  >
                                       <p >Financia la Educación y Formación Integral de Becarios AVAA por 5 años. </p>
                                    </li>
                                 </ul>
                                 <ul>
                                    <p>
                                       <strong>DONANTE DIAMANTE</strong>
                                    </p>
                                    <li  >
                                       <p >Sembramos Futuro 2 x 2</p>
                                    </li>
                                    <li  >
                                       <p>Financia la Educación y Formación Integral de Becarios AVAA por 2 años. </p>
                                    </li>
                                 </ul>
                                 <ul>
                                    <p  >
                                       <strong>DONANTE ORO</strong>
                                    </p>
                                    <li  >
                                       <p >Abonamos Futuro</p>
                                    </li>
                                    <li  >
                                       <p>Financia la Educación y Formación Integral de Becarios AVAA por 1 año. </p>
                                    </li>
                                 </ul>
                                 <ul>
                                    <p  >
                                       <strong>DONANTE ESTRELLA</strong>
                                    </p>
                                    <li  >
                                       <p >Patrocinantes de sueños educativos </p>
                                    </li>
                                    <li  >
                                       <p>Invierte en la Educación y Formación Integral de Becarios AVAA por 5 años con un financiamiento del 10 % del total de los becarios cada año.</p>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </section>
      </div>
   </section>
   <!-- Fin Membresias Cooporativas-->

   <div class="linea-sobra" id="membresia-institucional"></div>

   <!-- Miembros Institucionales -->
   <section  class="section">
      <div class="container">
         <div class="section-header">
            <h2 class="section-title wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">Membresía Institucional </h2>
            <hr class="lines wow zoomIn" data-wow-delay="0.3s">

         </div>
         <div class="row letrasResponsive">
            <div class=" contenidoDeList side-center col-sm-12 col-md-12"  align="justify">

              <p> Nuestro programa de Membresías Institucionales (conocido como IMP por sus siglas en inglés Institutional Membership Program) incluye instituciones académicas de Estados Unidos, Canadá y Venezuela, que anualmente realizan un aporte para contribuir con el desarrollo de nuestros programas de inversión social.</p>
               <h3 class="lead">  <strong>En retribución a su ayuda, AVAA le ofrece los siguientes beneficios: </strong> </h3>
               <hr/>
               <ul >
                  <li>
                     <p><strong>Información de la institución en la página web de AVAA.</strong></p>
                  </li>
                  <li >
                     <p><strong>Envío mensual de listado de estudiantes potenciales.</strong></p>
                  </li>
                  <li>
                     <p><strong>Tarifas y descuentos especiales en los eventos educativos organizados por AVAA.</strong> </p>
                  </li>
                  <li >
                     <p><strong>Uso de la biblioteca de AVAA durante 3 días al año para dictar charlas. </strong> </p>
                  </li>
                  <li>
                     <p><strong>Asistencia en la publicación de avisos en prensa, reservación de hotel, transporte, etc. Otros servicios.</strong></p>
                  </li>
               </ul>
               <br/>
               <hr/>
               <p >  Los Representantes Educativos Internacionales (Agentes) son empresas reconocidas que en Venezuela, desempeñan funciones de representación educativa internacional, y con su aporte de reciben estos mismos beneficios.</p>
               <hr/>
               <p>  <strong>¿Desea convertirse en un Miembro Educativo de AVAA?</strong> <a href="{{asset('contactenos')}}" class="membresia-enlace"><strong>¡Contáctenos!</strong></a> </p>
            </div>
         </div>
      </div>
   </section>
   <!-- Fin Membresia Institucionales-->

   @endsection