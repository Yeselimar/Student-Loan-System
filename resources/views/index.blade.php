@extends('web_site.layouts.main')
@section('title','Inicio')
@section('content')
   <!-- Principal -->
   <section id="x" class="x" data-stellar-background-ratio="0.2">
      <br/><br/><br/>
   </section>

   <div class="linea-sobra"></div>
   <div class="container-cabecera">
      <img src="{{asset("info_sitio/img/cabeceras/inicio.png")}}" alt="AVAA - AVAA" class="cabecera-imagen">
      <div class="cabecera-titulo">
         <p class="h1"> AVAA-<br> Asociación Venezolano Americana de Amistad</p>
      </div>
   </div>

   <div style="height: 50px" id="noticias"></div>
   <!-- Noticias -->
   <div class="container">
    	<div class="row">
         <div class="col-lg-7 col-md-7 col-sm-6 col-xs-12" style="border:1px solid #fff">
            <section class="section" >
               <div class="section-header" style="margin-bottom: 0px !important">
                  <h1 class="section-title wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">Noticias
                  </h1>
                  <hr class="lines wow zoomIn" data-wow-delay="0.3s">
               </div>

               <br><br>

               <div class="carousel-noticias owl-carousel owl-theme">
                  @foreach($noticias as $noticia)
                  <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid #fff;border-top:1px solid #eee;border:1px solid #E0E0E0" data-mh="">
                     <div class="row">
                     <div class="col-lg-5 col-md-6 col-sm-12 col-xs-12" style="padding-left: 0px; padding-right: 0px;">
                        <a href="{{route('showNoticia',$noticia->slug)}}">
                        <img class="img-fluid img-responsive"   src="{{url($noticia->url_imagen)}}" alt="{{$noticia->titulo}}" />
                        </a>
                     </div>
                     <div class="col-lg-7 col-md-6 col-sm-12 col-xs-12">
                        <div data-mh="titulo-noticia">
                           <br>
                           <a href="{{route('showNoticia',$noticia->slug)}}" style="color:#424242">
                              <p class="h5"><strong>{{ $noticia->titulo }}</strong></p>
                           </a>
                        </div>
                        <hr>
                        <p class="h6" style="color:#9E9E9E">{{$noticia->informacion_contacto}} - {{$noticia->fechaActualizacionCorta()}}</p>
                        <!--<a href="{{route('showNoticia',$noticia->slug)}}" title="Mas Información" class="btn btn-common btn-sm"><i class="fa fa-plus"></i> <span class="mas-informacion">Ver más</span></a>-->
                     </div>
                     </div>
                   </div>
                   @endforeach
               </div>
            </section>
         </div>

         <div class="col-lg-5 col-md-5 col-sm-6 col-xs-12" style="padding-top: 30px;border:1px solid #fff ">
            <a href="https://twitter.com/avaa_org" class="h4 btn-twitter"><strong>Seguir @Avaa_org</strong></a>
            <hr>
            <div style="border: 1px solid #E0E0E0;">

            <a class="twitter-timeline" data-mh="iguales" data-theme="light" height="200" data-chrome="nofooter noheader" href="https://twitter.com/avaa_org" data-widget-id="369868188328017922" ></a>
            <script>
               !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
            </script>

            </div>

         </div>

      </div>
   </div>
   <!-- Fin Noticias -->

   <div class="linea-sobra" id="programasAVAA"></div>

    <!-- Programas-->
   <section class="section">
      <div class="container">
         <div class="section-header">
            <h2 class="section-title wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">Programas AVAA </h2>
            <hr class="lines wow zoomIn" data-wow-delay="0.3s">
            <p class="section-subtitle wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">La Asociación Venezolano Americana de Amistad desarrolla tres programas sociales en el área educativa.</p>
         </div>
         <div class="row programa-tables letrasResponsive">
            <div class="col-md-4 col-sm-6 col-xs-12">
               <div class="programa-table" data-mh="programa">
                  <div class="programa-details">

                     <h2 class="title-miembros-institucionales" data-mh="programa-titulo">PROEXCELENCIA AVAA</h2>

                     <img src="{{asset('info_sitio/img/testimonial/proexcelencia.jpg')}}" alt="ProExcelencia AVAA" / style="min-width: 100%;height: auto">

                     <div class="col-lg-12">
                        <br>
                        <p class="h" align="justify">Propuesta educativa que promueve la formación integral de jóvenes venezolanos de medianos o bajos recursos económicos durante los cinco años de carrera universitaria.</p>
                     </div>

                  </div>
                  <hr>
                  <div class="xxxx-button">
                     <a href="{{asset(route('programas'))}}#ProExcelencia" title="Mas Información" class="btn btn-common"><i class="fa fa-plus"></i> <span class="mas-informacion">Mas Información</span></a>
                  </div>
               </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
               <div class="programa-table" data-mh="programa">
                  <div class="programa-details">
                     <h2 class="title-miembros-institucionales" data-mh="programa-titulo">AVAA US</h2>

                     <img src="{{asset('info_sitio/img/testimonial/avaainc.jpg')}}" alt="Avaa Internacional" / style="min-width: 100%;height: auto">

                     <div class="col-lg-12">
                        <br>
                        <p class="h" align="justify">En AVAA buscamos promover y fomentar el intercambio educativo y cultural entre Venezuela, Estados Unidos y Canadá. Para ello, con la certificación y apoyo de las embajadas de estos países.</p>
                     </div>
                  </div>
                  <div class="plan-button">
                  </div>
               </div>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">
               <div class="programa-table" data-mh="programa">
                  <div class="programa-details">
                     <h2 class="title-miembros-institucionales" data-mh="programa-titulo">ASESORÍAS EDUCATIVAS</h2>

                     <img src="{{asset('info_sitio/img/testimonial/asesorias.jpg')}}" alt="Asesorias educativas" style="min-width: 100%;height: auto"  />

                     <div class="col-lg-12">
                        <br>
                        <p class="h" align="justify">El servicio de atención a interesados en cursar estudios en Estados Unidos o Canadá, prestado como centro oficial de asesorías de las embajadas de estos países.</p>
                     </div>

                  </div>
                  <hr>
                  <div class="plan-button">
                     <a href="{{asset(route('programas'))}}#asesoriaEducativa" title="Mas Información" class="btn btn-common"><i class="fa fa-plus"></i> <span class="mas-informacion">Mas Información</span></a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- Fin Programas -->


   <div class="linea-sobra" id="miembros-institucionales"></div>


   <!-- Miembros Institucionales -->
   @if($miembros->count()!=0)
   <section class="section">
      <div class="container">
         <div class="section-header">
            <h2 class="section-title wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">Miembros Institucionales </h2>
            <hr class="lines wow zoomIn" data-wow-delay="0.3s">
            <p class="section-subtitle wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">Los miembros institucionales contribuyen con el desarrollo de nuestros programas de inversión social.</p>
         </div>

         @if($miembros->count()!=0)
         <div class="" style="border:1px solid #fff">
            <div class="carousel-miembros owl-carousel owl-theme">
               @foreach($miembros as $miembro)
                  <div class="col-lg-12" >
                     <a class="miembro-enlace" href="{{route('showNoticia',$miembro->slug)}}">
                        <img class="img-fluid img-responsive"   src="{{asset($miembro->url_imagen)}}" alt="{{$miembro->titulo}}" style="border:1px solid #eee "/>
                        <p class="title-miembros-institucionales">{{$miembro->titulo}}</p>
                     </a>
                  </div>
               @endforeach

            </div>
            <div class="text-center">
            <a class="anterior" ><i class="fa fa-angle-left fa-2x" style="color:#021f3a"></i></a>
            &nbsp;&nbsp;&nbsp;<a class="siguiente"><i class="fa fa-angle-right fa-2x" style="color:#021f3a"></i></a>
            </div>
         </div>
         @endif
      </div>
   </section>

   <div class="linea-sobra"></div>
   @endif
   <!-- Fin Miembros Institucionales -->


   <!-- Organizaciones -->
   <div class="container" style="padding-top: 50px;padding-bottom: 50px">
      <div class="section-header">
         <h2 class="section-title wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">Organizaciones</h2>
         <hr class="lines wow zoomIn" data-wow-delay="0.3s">
         <p class="section-subtitle wow fadeIn" data-wow-duration="1000ms" data-wow-delay="0.3s">Institutos Internacionales relacionadas con el programa AVAA</p>
      </div>
      <div class="row">
         <div class="col-lg-6 col-md-6 col-xs-6 organizaciones">
            <div class="item-boxes wow fadeInDown" data-wow-delay="0.4s">
               <a  target="_blank" href="https://educationusa.state.gov/">
                     <img src="{{asset('info_sitio/img/educationusa.jpg')}}" alt="Educación USA" style="border:1px solid #eee;max-width: 100%; height:auto;" data-mh="org" >
               </a>
            </div>
         </div>
         <div class="col-lg-6 col-md-6 col-xs-6 organizaciones">
            <div class="item-boxes wow fadeInDown" data-wow-delay="0.6s" >
               <a target="_blank" href="http://www.educanada.ca/">
                  <img src="{{asset('info_sitio/img/canada.jpg')}}"  alt="Educación Canadá" style="border:1px solid #eee;max-width: 100%;height: auto" data-mh="org">
               </a>
            </div>
         </div>
      </div>
   </div>
   <!-- Fin Organizaciones -->



   @if($banners->count()!=0)
   <div class="linea-sobra"></div>
   <div class="container" style="padding-top: 50px;">
      <div class="carousel-banner owl-carousel owl-theme">
         @foreach($banners as $banner)
         <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="border:1px solid #fff;border-top:1px solid #eee;border:1px solid #E0E0E0" data-mh="">
            <div class="row">
               <div class="col-lg-12" style="padding-left: 0px; padding-right: 0px;">
                  <a href="{{$banner->url}}" target_="_blank">
                  <img class="img-fluid img-responsive"   src="{{url($banner->imagen)}}" alt="{{$banner->titulo}}" />
                  </a>
               </div>

            </div>
          </div>
          @endforeach
      </div>
   </div>
   @endif

@endsection

@section('personaljs')
<script>
   $(document).ready(function()
   {

      $('.carousel-banner').owlCarousel({
      items: 1,
      loop: true,
      margin: 0,
      autoplay: true,
      autoplayTimeout: 8000,
      autoplayHoverPause: true,

      });

      $('.carousel-noticias').owlCarousel({
      items: 1,
      loop: false,
      margin: 0,
      autoplay: true,
      autoplayTimeout: 4000,
      autoplayHoverPause: true,

      });

      $('.carousel-miembros').owlCarousel({
      loop:true,
      margin:10,
      autoplay: true,
      responsive:
      {
         0:
         {
            items:1,
            nav:false,
            dots:true,
         },
         600:
         {
            items:3,
            nav:false,
            dots:true,
         },
         1000:
         {
            items:5,
            nav:false,
            dots:true,
         }
      },
      autoplayTimeout: 9000,
      autoplayHoverPause: true,
      });

      var owl = $('.owl-carousel');
      owl.owlCarousel();
      $('.siguiente').click(function() {
          owl.trigger('next.owl.carousel', [1000]);
      })
      $('.anterior').click(function() {
          owl.trigger('prev.owl.carousel', [500]);
      })

   });
</script>


@endsection