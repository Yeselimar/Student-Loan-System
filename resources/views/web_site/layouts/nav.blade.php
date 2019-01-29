<nav class="navbar navbar-expand-lg fixed-top scrolling-navbar indigo">
            <div class="container">
               <!-- Brand and toggle get grouped for better mobile display -->
               <div class="navbar-header">
                  <span class="navbar-brand"><a href="{{asset('/')}}"><img class="img-fulid" src="{{asset('info_sitio/img/logo2.png')}}" alt=""></a></span>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#main-navbar" aria-controls="main-navbar" aria-expanded="false" aria-label="Toggle navigation">
                  <i class="lnr lnr-menu"></i>
                  </button>
               </div>
               <div class="menu collapse navbar-collapse" id="main-navbar">
                  <ul class="navbar-nav mr-auto w-100 justify-content-end" >
                     <li class="nav-item nivel1">
                     @if($route=='home')
                        <a class="nav-link page-scroll active" href="#hero-area">Inicio</a>
                     @else
                      <a class="nav-link" href="{{asset('/')}}">Inicio</a>
                     @endif

                     </li>
                     <li class="nav-item dropdown nivel1">
                     @if($route=="nosotros")
                        <a class="nav-link dropdown-toggle nivel1 page-scroll active " target="_self" href="#hero-area" aria-haspopup="true" aria-expanded="false">
                        Nosotros
                        </a>
                        <ul class="dropdown-menu nivel2">
                           <li class="nav-item">
                              <a class="dropdown-item page-scroll" href="#objetivos">Misión, Visión y Valores</a>
                           </li>
                           <li class="nav-item">
                              <a class="dropdown-item page-scroll" href="#estructura-organizativa">Estructura Organizativa</a>
                           </li>
                        </ul>
                     @else
                         <a class="nav-link dropdown-toggle nivel1 " target="_self" href="{{asset('nosotros')}}" aria-haspopup="true" aria-expanded="false">
                        Nosotros
                        </a>
                        <ul class="dropdown-menu nivel2">
                           <li class="nav-item">
                              <a class="dropdown-item " href="{{asset('nosotros')}}#objetivos">Misión, Visión y Valores</a>
                           </li>
                           <li class="nav-item">
                              <a class="dropdown-item " href="{{asset('nosotros')}}#estructura-organizativa">Estructura Organizativa</a>
                           </li>
                        </ul>

                        @endif


                     </li>
                     <li class="nav-item dropdown nivel1">

                     @if($route=="programas")
                        <a class="nav-link dropdown-toggle nivel1 page-scroll active" target="_self" href="#hero-area" aria-haspopup="true" aria-expanded="false">
                        Programas
                        </a>
                        <ul class="dropdown-menu nivel2">
                           <li class="nav-item">
                              <a class="dropdown-item page-scroll" href="#proexcelencia">ProExelencia AVAA</a>
                           </li>
                           <li class="nav-item">
                              <a class="dropdown-item page-scroll" href="#asesoria-educativa">Asesorías Educativas</a>
                           </li>
                        </ul>

                     @else

                     <a class="nav-link dropdown-toggle nivel1" target="_self" href="{{asset('programas')}}" aria-haspopup="true" aria-expanded="false">
                        Programas
                        </a>
                        <ul class="dropdown-menu nivel2">
                           <li class="nav-item">
                              <a class="dropdown-item" href="{{asset('programas')}}#proexcelencia">ProExelencia AVAA</a>
                           </li>
                           <li class="nav-item">
                              <a class="dropdown-item" href="{{asset('programas')}}#asesoria-educativa">Asesorías Educativas</a>
                           </li>
                        </ul>

                        @endif



                     </li>
                     <li class="nav-item dropdown nivel1">

                     @if($route=="membresias")
                        <a class="nav-link dropdown-toggle nivel1 page-scroll active" target="_self" href="#hero-area" aria-haspopup="true" aria-expanded="false">
                        Membresías
                        </a>
                        <ul class="dropdown-menu nivel2">
                           <li class="nav-item">
                              <a class="dropdown-item page-scroll" href="#membresias-corporativas">Membresía Corporativa</a>
                           </li>
                           <li class="nav-item">
                              <a class="dropdown-item page-scroll" href="#membresia-institucional">Membresía Institucional</a>
                           </li>
                        </ul>

                        @else

                        <a class="nav-link dropdown-toggle nivel1 " target="_self" href="{{asset('membresias')}}" aria-haspopup="true" aria-expanded="false">
                        Membresías
                        </a>
                        <ul class="dropdown-menu nivel2">
                           <li class="nav-item">
                              <a class="dropdown-item " href="{{asset('membresias')}}#membresias-corporativas">Membresía Corporativa</a>
                           </li>
                           <li class="nav-item">
                              <a class="dropdown-item " href="{{asset('membresias')}}#membresia-institucional">Membresía Institucional</a>
                           </li>
                        </ul>

                        @endif
                     </li>
                     <li class="nivel1 nav-item">
                     @if($route=="noticias")
                        <a class="nav-link page-scroll active" target="_self" href="{{asset('noticias')}}" style="border:1px solid #fff;background-color: #003865;color:#fff!important;border-radius: 50px">Noticias</a>
                        @else
                             @if($route=="articulos")
                                 <a class="nav-link page-scroll active" target="_self" href="{{asset('noticias')}}">Noticias</a>
                             @else
                                  <a class="nav-link" target="_self" href="{{asset('noticias')}}">Noticias</a>
                             @endif
                     @endif


                     </li>
                     <li class="nivel1 nav-item">
                     @if($route=="contactenos")
                        <a class="nav-link page-scroll active" target="_self" href="#hero-area">Contáctenos</a>
                        @else
                        <a class="nav-link " target="_self" href="{{asset('contactenos')}}">Contáctenos</a>
                     @endif
                     </li>
                     <li class="nivel1 nav-item">

                       <a class="nav-link" target="_blank" href="{{asset(route('sisbeca'))}}">SISBECA</a>

                     </li>
                  </ul>
               </div>
            </div>
            <!-- Mobile Menu Start -->
            <ul class="mobile-menu">
               <li>
                 @if($route=="home")
                  <a class="page-scroll active" href="#hero-area">Inicio</a>
                  @else
                  <a href="{{asset('/')}}">Inicio</a>
                  @endif
               </li>
               <li class="dropdown">
               @if($route=="nosotros")
                  <a class="nav-link dropdown-toggle page-scroll active" href="#hero-area" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Nosotros
                  </a>
                  <ul class="dropdown-menu">
                     <li class="dropdown-item">
                        <a class="page-scroll" href="#objetivos">Misión, Visión y Valores</a>
                     </li>
                     <li class="dropdown-item">
                        <a class="page-scroll" href="#estructura-organizativa">Estructura Organizativa</a>
                     </li>
                  </ul>
                  @else
                  <a class="nav-link dropdown-toggle" target="_self" href="{{asset('nosotros')}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Nosotros
                  </a>
                  <ul class="dropdown-menu">
                     <li class="dropdown-item">
                        <a  href="{{asset('nosotros')}}#objetivos">Misión, Visión y Valores</a>
                     </li>
                     <li class="dropdown-item">
                        <a  href="{{asset('nosotros')}}#estructura-organizativa">Estructura Organizativa</a>
                     </li>
                  </ul>
                  @endif

               </li>
               <li class="dropdown">
               @if($route=="programas")
                  <a class="nav-link dropdown-toggle page-scroll active" href="#hero-area" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Programas
                  </a>
                  <ul class="dropdown-menu">
                     <li class="dropdown-item">
                        <a class="page-scroll" href="#proexcelencia">ProExcelencia AVAA</a>
                     </li>
                     <li class="dropdown-item">
                        <a class="page-scroll" href="#asesoria-educativa">Asesorías Educativas</a>
                     </li>
                  </ul>
                  @else
                  <a class="nav-link dropdown-toggle" target="_self" href="{{asset('programas')}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Programas
                  </a>
                  <ul class="dropdown-menu">
                     <li class="dropdown-item">
                        <a href="{{asset('programas')}}#proexcelencia">ProExcelencia AVAA</a>
                     </li>
                     <li class="dropdown-item">
                        <a  href="{{asset('programas')}}#asesoria-educativa">Asesorías Educativas</a>
                     </li>
                  </ul>

                  @endif


               </li>
               <li class="dropdown">

                  @if($route=="membresia")
                  <a class="nav-link dropdown-toggle page-scroll active" target="_self" href="#hero-area" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Membresías
                  </a>
                  <ul class="dropdown-menu">
                     <li class="dropdown-item">
                        <a class="page-scroll" href="#membresias-corporativas">Membresía Corporativa</a>
                     </li>
                     <li class="dropdown-item">
                        <a class="page-scroll" href="#membresia-institucional">Membresía Institucional</a>
                     </li>
                  </ul>
                  @else

                  <a class="nav-link dropdown-toggle" target="_self" href="{{asset('membresias')}}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Membresías
                  </a>
                  <ul class="dropdown-menu">
                     <li class="dropdown-item">
                        <a href="{{asset('membresias')}}#membresias-corporativas">Membresía Corporativa</a>
                     </li>
                     <li class="dropdown-item">
                        <a  href="{{asset('membresias')}}#membresia-institucional">Membresía Institucional</a>
                     </li>
                  </ul>

                  @endif
               </li>
               <li>
               @if($route=="noticias")
                  <a class="page-scroll active" target="_self" href="#hero-area">Noticias</a>
                  @else
                       @if($route=="articulos")
                           <a  class="active" target="_self" href="{{asset('noticias')}}">Noticias</a>
                       @else
                              <a  target="_self" href="{{asset('noticias')}}">Noticias</a>
                       @endif
                  @endif

               </li>
               <li>
               @if($route=="contactenos")
                  <a class="page-scroll active" target="_self" href="#hero-area">Contáctenos</a>
                  @else
                  <a  target="_self" href="{{asset('contactenos')}}">Contáctenos</a>
                  @endif
               </li>
               <li>
               
                  <a target="_blank" href="{{asset(route('sisbeca'))}}">SISBECA</a>
                  
               </li>

            </ul>
            <!-- Mobile Menu End -->
         </nav>
         <!-- Navbar End -->   