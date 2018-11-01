@extends('web_site.layouts.main')
@section('title', "Nosotros")
@section('content')
      
   <!-- Principal -->
   <section id="seccionPrincipal" class="section" data-stellar-background-ratio="0.2">
      <br/><br/><br/>
      <div class="container">
         <div class="section-header">
            <h2 class="section-title">Nosotros</h2>
            <hr class="lines">
            <p class="section-subtitle h4">
               La Asociación Venezolano Americana de Amistad a lo largo de sus 75 años de acción ha desarrollado una reputación pública e institucional importante, logrando excelentes indicadores de credibilidad, imparcialidad y transparencia en el seno de la sociedad venezolana.
            </p>
            <p class="section-subtitle h4">
               Por ser una institución sin fines de lucro, AVAA obtiene sus ingresos a través de distintos eventos de recaudación de fondos que apoyan su labor de formación; al mismo tiempo que fomentan el intercambio cultural entre estas naciones.
            </p>
         </div>
         <div class="col-lg-12 col-md-6 col-xs-4">
            <div class="row" id="contentPrincipal">
               <div class="col-lg-6 col-sm-6 col-xs-6 box-item" >
                  <a class="page-scroll" href="#objetivos">
                     <span class="icon">
                     <i class="fa fa-newspaper-o icon-contenedor"></i>
                     </span>
                     <div class="text">
                        <p class="titulo-contenedor text-center h6">Misión, Visión y Valores</p>
                     </div>
                  </a>
               </div>
               <div class="col-lg-6 col-sm-6 col-xs-6 box-item" >
                  <a class="page-scroll" href="#estructura-organizativa">
                     <span class="icon">
                     <i class="fa fa-newspaper-o icon-contenedor"></i>
                     </span>
                     <div class="text">
                        <p class="titulo-contenedor text-center h6">Estructura Organizativa</p>
                     </div>
                  </a>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- Fin Principal-->

   <div style="height: 50px" id="objetivos"></div>

   <!-- Objetivos -->
   <section class="section">
      <div class="container">
         <div class="section-header">
            <h2 class="section-title wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">Misión, Visión y Valores</h2>
            <hr class="lines wow zoomIn" data-wow-delay="0.3s">
            <p class="section-subtitle wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">ProExcelencia busca no sólo proveer de ayuda financiera sino, sobre todo, preparar a los estudiantes para que tengan una visión más amplia de la vida, apoyando y potenciando sus competencias para que sean futuros líderes en Venezuela.</p>
         </div>
         <div class="row letrasResponsive">
            <div class="col-md-4 col-sm-6">
               <div data-mh="nosotros-cuadros" class="item-boxes wow fadeInDown" data-wow-delay="0.2s">
                  <div class="icon icon-contenedor-nosotros">
                     <i class="fa fa-flag icon-nosotros"></i>
                  </div>
                  <h4>Misión</h4>
                  <p>Promover y apoyar, la educación integral y la formación de jóvenes venezolanos con sentido de superación y elevados valores sociales y morales, que contribuyan al desarrollo armónico del país, en un clima de convivencia y amistad internacional, en alianza con personas y organizaciones comprometidas con Venezuela.</p>
               </div>
            </div>
            <div class="col-md-4 col-sm-6">
               <div data-mh="nosotros-cuadros" class="item-boxes wow fadeInDown" data-wow-delay="0.8s">
                  <div class="icon icon-contenedor-nosotros">
                     <i class="fa fa-eye icon-nosotros"></i>
                  </div>
                  <h4>Visión</h4>
                  <p>Ser reconocidos como líderes en la ejecución de  iniciativas de formación de jóvenes profesionales comprometidos con el país, con valores asociados al progreso.</p>
               </div>
            </div>
            <div class="col-md-4 col-sm-6">
               <div data-mh="nosotros-cuadros" class="item-boxes wow fadeInDown" data-wow-delay="1.2s">
                  <div class="icon icon-contenedor-nosotros">
                     <i class="fa fa-balance-scale icon-nosotros"></i>
                  </div>
                  <h4>Valores</h4>
                  <p align="center">Vocación social.<br/>
                     Pasión por la excelencia.<br/>
                     Compromiso con nuestra misión.<br/>
                     Visión multicultural.<br/>
                     Imparcialidad y tolerancia.<br/>
                     Responsabilidad por las acciones y resultados.<br/>
                     Ética.<br/>
                  </p>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- Fin  Objetivos -->

   <div class="linea-sobra" id="estructura-organizativa"></div>

   <!-- Estructura Organizativa -->
   <section class="section">
      <div class="container">
         <div class="section-header">
            <h2 class="section-title wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">Estructura Organizativa </h2>
            <hr class="lines wow zoomIn" data-wow-delay="0.3s">
            <p class="section-subtitle wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">En esta seccion se listan las autoridades directores y demas miembros del STAF de AVAA</p>
         </div>
         <div id="portfolio" class="row">
            <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mix development print">&nbsp;</div>
            <div class="col-sm-6 col-md-4 col-lg-4 col-xl-4 mix design print">
               <div class="portfolio-item">
                  <div class="shot-item">
                     <img src="{{asset('info_sitio/img/team/estructuraorganizativa.png')}}" alt="Estructura Organizativa" />
                     <a class="overlay lightbox" href="{{asset('info_sitio/img/team/estructuraorganizativa.png')}}">
                     <i class="lnr lnr-eye item-icon"></i>
                     </a>
                  </div>
               </div>
            </div>
         </div>
         <br/><br/>
         <section class="welcome-section section-padding section-dark">
            <div class="container">
               <div class="row letrasResponsive">
                  <div class="col-md-12 col-lg-12 col-xs-12">
                     <div class="Material-tab">
                        <!-- Nav tabs -->
                        <ul class="nav nav-tabs justify-content-left" id="myTab" role="tablist">
                           <li class="nav-item">
                              <a class="nav-link active" data-toggle="tab" href="#autoridades" role="tab"><i class="mdi mdi-account-multiple-outline"></i><br/><strong>Autoridades</strong></a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" data-toggle="tab" href="#directores1" role="tab"><i class="mdi mdi-account-multiple-outline"></i><br/><strong>Directores(2015-2017)</strong></a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" data-toggle="tab" href="#directores2" role="tab"><i class="mdi mdi-account-multiple-outline"></i><br/><strong>Directores(2017-2019)</strong></a>
                           </li>
                           <li class="nav-item">
                              <a class="nav-link" data-toggle="tab" href="#staff" role="tab"><i class="mdi mdi-account-multiple-outline"></i><br/><strong>Staff</strong></a>
                           </li>
                        </ul>
                        <!-- Tab panes -->
                        <div class="tab-content">
                           <div  align="justify" class="tab-pane fade show active" id="autoridades" role="tabpanel">
                              <br/>
                              <!-- Autoridades-->
                              <div class="container">
                                 <div class="row">
                                    <div class="col-md-6 nosotros-team">
                                       <div class="blockquote-box blockquote-info animated wow fadeInLeft clearfix animated" style="visibility: visible; animation-name: fadeInLeft;">
                                          <div class="square pull-left">
                                             <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60">
                                          </div>
                                          <h6>
                                             <Strong>Gustavo Roosen</Strong>
                                          </h6>
                                          <p>
                                             Presidente
                                          </p>
                                       </div>
                                       <div class="blockquote-box blockquote-primary animated wow fadeInLeft clearfix animated" style="visibility: visible; animation-name: fadeInLeft;">
                                          <div class="square pull-left">
                                             <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60">
                                          </div>
                                          <h6>
                                             <Strong>
                                             Karhil Canelones</Strong>
                                          </h6>
                                          <p>
                                             Vice Presidente
                                          </p>
                                       </div>
                                       <div class="blockquote-box blockquote-success animated wow fadeInLeft clearfix animated" style="visibility: visible; animation-name: fadeInLeft;">
                                          <div class="square pull-left">
                                             <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="60" width="80">
                                          </div>
                                          <h6>
                                             <Strong>
                                             Ronald Monahan</Strong>
                                          </h6>
                                          <p>
                                             Vice Presidente
                                          </p>
                                       </div>
                                    </div>
                                    <div class="col-md-6 nosotros-team">
                                       <div class="blockquote-box blockquote-danger animated wow fadeInRight clearfix animated" style="visibility: visible; animation-name: fadeInRight;">
                                          <div class="square pull-left">
                                             <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60">
                                          </div>
                                          <h6>
                                             <Strong>
                                             Antonio Solorzano
                                             </Strong>
                                          </h6>
                                          <p>
                                             Vice Presidente
                                          </p>
                                       </div>
                                       <div class="blockquote-box blockquote-warning animated wow fadeInRight clearfix animated" style="visibility: visible; animation-name: fadeInRight;">
                                          <div class="square pull-left">
                                             <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60">
                                          </div>
                                          <h6>
                                             <Strong>
                                             Miguel Yanes
                                             </Strong>
                                          </h6>
                                          <p>
                                             Tesorero
                                          </p>
                                       </div>
                                       <div class="blockquote-box animated wow fadeInRight clearfix animated" style="visibility: visible; animation-name: fadeInRight;">
                                          <div class="square pull-left">
                                             <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60">
                                          </div>
                                          <h6>
                                             <Strong>
                                             Luis Andueza</Strong>
                                          </h6>
                                          <p>
                                             Secretario y Representante Legal
                                          </p>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="tab-pane fade" id="directores1" role="tabpanel" >
                              <br/>
                              <div class="container">
                                 <div class="row">
                                    <div class="col-md-6 nosotros-team">
                                       <div class="blockquote-box blockquote-info animated  fadeInLeft clearfix animated" style="visibility: visible; animation-name: fadeInLeft;">
                                          <div class="square pull-left">
                                             <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60">
                                          </div>
                                          <h6>
                                             <Strong>
                                             Susana Brugada
                                             </Strong>
                                          </h6>
                                       </div>
                                       <div class="blockquote-box blockquote-primary animated fadeInLeft clearfix animated" style="visibility: visible; animation-name: fadeInLeft;">
                                          <div class="square pull-left">
                                             <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60">
                                          </div>
                                          <h6>
                                             <Strong>
                                             Eric Machum
                                             </Strong>
                                          </h6>
                                       </div>
                                       <div class="blockquote-box blockquote-success animated fadeInLeft clearfix animated" style="visibility: visible; animation-name: fadeInLeft;">
                                          <div class="square pull-left">
                                             <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="60" width="80">
                                          </div>
                                          <h6>
                                             <Strong>
                                             Nelson Rincón
                                             </Strong>
                                          </h6>
                                       </div>
                                       <div class="blockquote-box blockquote-green animated fadeInLeft clearfix animated" style="visibility: visible; animation-name: fadeInLeft;">
                                          <div class="square pull-left">
                                             <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60">
                                          </div>
                                          <h6>
                                             <Strong>
                                             Erika Mendoza Orellanes
                                             </Strong>
                                          </h6>
                                       </div>
                                    </div>
                                    <div class="col-md-6 nosotros-team">
                                       <div class="blockquote-box blockquote-danger animated fadeInRight clearfix animated" style="visibility: visible; animation-name: fadeInRight;">
                                          <div class="square pull-left">
                                             <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60">
                                          </div>
                                          <h6>
                                             <Strong>
                                             Víctor Guédez
                                             </Strong>
                                          </h6>
                                       </div>
                                       <div class="blockquote-box blockquote-warning animated fadeInRight clearfix animated" style="visibility: visible; animation-name: fadeInRight;">
                                          <div class="square pull-left">
                                             <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60">
                                          </div>
                                          <h6>
                                             <Strong>
                                             Juan Carlos Garanton
                                             </Strong>
                                          </h6>
                                       </div>
                                       <div class="blockquote-box animated fadeInRight clearfix animated" style="visibility: visible; animation-name: fadeInRight;">
                                          <div class="square pull-left">
                                             <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60">
                                          </div>
                                          <h6>
                                             <Strong>
                                             Carmen Cecilia Torres
                                             </Strong>
                                          </h6>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div  class="tab-pane fade" id="directores2" role="tabpanel">
                              <br/>
                              <div class="container">
                                 <div class="row">
                                    <div class="col-md-6 nosotros-team">
                                       <div class="blockquote-box blockquote-info animated fadeInLeft clearfix animated" style="visibility: visible; animation-name: fadeInLeft;">
                                          <div class="square pull-left">
                                             <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60">
                                          </div>
                                          <h6>
                                             <Strong>
                                             Ernesto Blohm
                                             </Strong>
                                          </h6>
                                       </div>
                                       <div class="blockquote-box blockquote-primary animated fadeInLeft clearfix animated" style="visibility: visible; animation-name: fadeInLeft;">
                                          <div class="square pull-left">
                                             <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60">
                                          </div>
                                          <h6>
                                             <Strong>
                                             Marisa Guinand
                                             </Strong>
                                          </h6>
                                       </div>
                                       <div class="blockquote-box blockquote-success animated fadeInLeft clearfix animated" style="visibility: visible; animation-name: fadeInLeft;">
                                          <div class="square pull-left">
                                             <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="60" width="80">
                                          </div>
                                          <h6>
                                             <Strong>
                                             Farzad Javamardian
                                             </Strong>
                                          </h6>
                                       </div>
                                    </div>
                                    <div class="col-md-6 nosotros-team">
                                       <div class="blockquote-box blockquote-danger animated fadeInRight clearfix animated" style="visibility: visible; animation-name: fadeInRight;">
                                          <div class="square pull-left">
                                             <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60">
                                          </div>
                                          <h6>
                                             <strong>                                                Patricia Dressler</strong>
                                          </h6>
                                       </div>
                                       <div class="blockquote-box blockquote-warning animated fadeInRight clearfix animated" style="visibility: visible; animation-name: fadeInRight;">
                                          <div class="square pull-left">
                                             <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60">
                                          </div>
                                          <h6>
                                             <Strong>
                                             Arturo Guevara
                                             </Strong>
                                          </h6>
                                       </div>
                                       <div class="blockquote-box animated fadeInRight clearfix animated" style="visibility: visible; animation-name: fadeInRight;">
                                          <div class="square pull-left">
                                             <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60">
                                          </div>
                                          <h6>
                                             <Strong>
                                             Karen Rojas
                                             </Strong>
                                          </h6>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div  align="justify" class="tab-pane fade show" id="staff" role="tabpanel">
                              <br/>
                              <div class="container">
                                 <div class="row">
                                    <div class="col-md-6 nosotros-team">
                                       <div class="blockquote-box animated fadeInLeft clearfix animated" style="visibility: visible; animation-name: fadeInLeft;">
                                          <div class="square pull-left">
                                             <a href="mailto:claudia.gonzalez@avaa.org">  <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60"></a>
                                          </div>
                                          <h6>
                                             <strong>Claudia González,</strong> <span>Directora Ejecutiva</span> 
                                          </h6>
                                          <p>Email: <a  style="color:#3d91d6;" href="mailto:claudia.gonzalez@avaa.org"><strong>claudia.gonzalez@avaa.org</strong></a></p>
                                       </div>
                                       <div class="blockquote-box animated fadeInLeft clearfix animated" style="visibility: visible; animation-name: fadeInLeft;">
                                          <div class="square pull-left">
                                             <a href="mailto:gerencia.proexcelencia@avaa.org">  <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60"></a>
                                          </div>
                                          <h6>
                                             <strong>Bapssy Meneses,</strong> <span>Gerente de Programas Educativos</span> 
                                          </h6>
                                          <p>Email: <a  style="color:#3d91d6;" href="mailto:gerencia.proexcelencia@avaa.org"><strong>gerencia.proexcelencia@avaa.org</strong></a></p>
                                       </div>
                                       <div class="blockquote-box animated fadeInLeft clearfix animated" style="visibility: visible; animation-name: fadeInLeft;">
                                          <div class="square pull-left">
                                             <a href="mailto:coordinadora.proexcelencia@avaa.org">  <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60"></a>
                                          </div>
                                          <h6>
                                             <strong>Coordinación de Programas Educativos</strong> 
                                          </h6>
                                          <p>Email: <a  style="color:#3d91d6;" href="mailto:coordinadora.proexcelencia@avaa.org"><strong>coordinadora.proexcelencia@avaa.org</strong></a></p>
                                       </div>
                                       <div class="blockquote-box animated fadeInLeft clearfix animated" style="visibility: visible; animation-name: fadeInLeft;">
                                          <div class="square pull-left">
                                             <a href="mailto:programa.proexcelencia@gmail.com">  <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60"></a>
                                          </div>
                                          <h6>
                                             <strong>Bárbara Narbona,</strong> <span>Asistente de Programas Educativos</span> 
                                          </h6>
                                          <p>Email: <a style="color:#3d91d6;" href="mailto:programa.proexcelencia@gmail.com"><strong> programa.proexcelencia@gmail.com</strong></a></p>
                                       </div>
                                       <div class="blockquote-box animated fadeInLeft clearfix animated" style="visibility: visible; animation-name: fadeInLeft;">
                                          <div class="square pull-left">
                                             <a href="mailto:yvonne.abogado@avaa.org">  <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60"></a>
                                          </div>
                                          <h6>
                                             <strong>Yvonne Abogado,</strong> <span>Gerente de Administración y Finanzas</span> 
                                          </h6>
                                          <p>Email: <a style="color:#3d91d6;" href="mailto:yvonne.abogado@avaa.org.com"><strong>yvonne.abogado@avaa.org</strong></a></p>
                                       </div>
                                       <div class="blockquote-box animated fadeInLeft clearfix animated" style="visibility: visible; animation-name: fadeInLeft;">
                                          <div class="square pull-left">
                                             <a href="mailto:martha.aguilar@avaa.org">  <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60"></a>
                                          </div>
                                          <h6>
                                             <strong>Martha Aguilar,</strong> <span>Coordinadora de Administración</span> 
                                          </h6>
                                          <p>Email: <a style="color:#3d91d6;" href="mailto:martha.aguilar@avaa.org"><strong>martha.aguilar@avaa.org</strong></a></p>
                                       </div>
                                       <div class="blockquote-box animated fadeInLeft clearfix animated" style="visibility: visible; animation-name: fadeInLeft;">
                                          <div class="square pull-left">
                                             <a href="mailto:cbt@avaa.org">  <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60"></a>
                                          </div>
                                          <h6>
                                             <strong>Miguel Caraballo,</strong> <span>Coordinador de Servicios Generales</span> 
                                          </h6>
                                          <p>Email: <a style="color:#3d91d6;" href="mailto:cbt@avaa.org"><strong>cbt@avaa.org</strong></a></p>
                                       </div>
                                       <div class="blockquote-box animated fadeInLeft clearfix animated" style="visibility: visible; animation-name: fadeInLeft;">
                                          <div class="square pull-left">
                                             <a href="mailto:mariag.mustiola@avaa.org">  <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60"></a>
                                          </div>
                                          <h6>
                                             <strong>María Gabriela Mustiola,</strong> <span>Gerente de Mercadeo y Comunicaciones</span> 
                                          </h6>
                                          <p>Email: <a style="color:#3d91d6;" href="mailto:mariag.mustiola@avaa.org"><strong>mariag.mustiola@avaa.org</strong></a></p>
                                       </div>
                                    </div>
                                    <div class="col-md-6 nosotros-team">
                                       <div class="blockquote-box animated fadeInRight clearfix animated" style="visibility: visible; animation-name: fadeInRight;">
                                          <div class="square pull-left">
                                             <a href="mailto:comunicaciones@avaa.org">  <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60"></a>
                                          </div>
                                          <h6>
                                             <strong>Diana Aponte,</strong> <span>Asistente de Mercadeo y Comunicaciones</span> 
                                          </h6>
                                          <p>Email: <a style="color:#3d91d6;" href="mailto:comunicaciones@avaa.org"><strong>comunicaciones@avaa.org</strong></a></p>
                                       </div>
                                       <div class="blockquote-box animated fadeInRight clearfix animated" style="visibility: visible; animation-name: fadeInRight;">
                                          <div class="square pull-left">
                                             <a href="mailto:mercadeo.avaa@avaa.org">  <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60"></a>
                                          </div>
                                          <h6>
                                             <strong>Asistente de Mercadeo y Comunicaciones</strong> 
                                          </h6>
                                          <p>Email: <a style="color:#3d91d6;" href="mailto:mercadeo.avaa@avaa.org"><strong>mercadeo.avaa@avaa.org</strong></a></p>
                                       </div>
                                       <div class="blockquote-box animated fadeInRight clearfix animated" style="visibility: visible; animation-name: fadeInRight;">
                                          <div class="square pull-left">
                                             <a href="mailto:Recaudacionavaa@gmail.com">  <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60"></a>
                                          </div>
                                          <h6>
                                             <strong>Gerente de Recaudación</strong> 
                                          </h6>
                                          <p>Email: <a style="color:#3d91d6;" href="mailto:Recaudacionavaa@gmail.com"><strong>recaudacionavaa@gmail.com</strong></a></p>
                                       </div>
                                       <div class="blockquote-box animated fadeInRight clearfix animated" style="visibility: visible; animation-name: fadeInRight;">
                                          <div class="square pull-left">
                                             <a href="mailto:edu.usa@avaa.org">  <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60"></a>
                                          </div>
                                          <h6>
                                             <strong>Irina Vazquez,</strong> <span>Asesor Educativo USA</span> 
                                          </h6>
                                          <p>Email: <a style="color:#3d91d6;" href="mailto:edu.usa@avaa.org"><strong>edu.usa@avaa.org</strong></a></p>
                                       </div>
                                       <div class="blockquote-box animated fadeInRight clearfix animated" style="visibility: visible; animation-name: fadeInRight;">
                                          <div class="square pull-left">
                                             <a href="mailto:asesoria.canada@avaa.org">  <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60"></a>
                                          </div>
                                          <h6>
                                             <strong>Sofía Colina,</strong> <span>Asesor Educativo Canadá</span> 
                                          </h6>
                                          <p>Email: <a style="color:#3d91d6;" href="mailto:asesoria.canada@avaa.org"><strong>asesoria.canada@avaa.org</strong></a></p>
                                       </div>
                                       <div class="blockquote-box animated fadeInRight clearfix animated" style="visibility: visible; animation-name: fadeInRight;">
                                          <div class="square pull-left">  <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60">
                                          </div>
                                          <h6>
                                             <strong>Irene Díaz,</strong> <span>Operador de Limpieza</span> 
                                          </h6>
                                       </div>
                                       <div class="blockquote-box animated fadeInRight clearfix animated" style="visibility: visible; animation-name: fadeInRight;">
                                          <div class="square pull-left">  <img src="{{asset('info_sitio/img/team/default.png')}}" alt="user" height="50" width="60">
                                          </div>
                                          <h6>
                                             <strong>Richard Márquez,</strong> <span>Mensajero</span> 
                                          </h6>
                                       </div>
                                    </div>
                                 </div>
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
   <!-- Fin Estructura Organizativa-->
@endsection

<!-- Footer Section Start -->
      
   