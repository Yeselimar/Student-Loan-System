{{Auth::check()}}
{{-- aqui en este extends esta  la funcion Auth::check() que autentifica si el usuario ya inicio sesion y lo redirige a la pagina principal del sistema --}}
<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="utf-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <!-- Tell the browser to be responsive to screen width -->
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="description" content="">
   <meta name="author" content="">
   <meta name="csrf-token" content="{{ csrf_token() }}">


   <link rel="icon" type="image/png" sizes="16x16" href="{{asset('info_sitio/img/favicon.png')}}" >
   <title>AVAA - Iniciar Sesión</title>

   @include('sisbeca.layouts.partials.filescss')
</head>

<body class="fix-header fix-sidebar">
   <!-- Preloader - style you can find in spinners.css -->
   <div class="preloader">
       <svg class="circular" viewBox="25 25 50 50">
           <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
   </div>
   <!-- Main wrapper  -->
   <div id="main-wrapper">
        <div class="header">
           @include('sisbeca.layouts.partials.navtop')
        </div>
        <br>
        <div class="unix-login">
          <div class="container-fluid" > 
            <div class="row justify-content-center">
              <div class="col-lg-5 col-md-6 col-sm-7" style="padding-left: 0px;padding-right: 0px;">
                  <div class="login-content panel panel-default">
                    <div class="panel-heading" align="center">
                      <h2 style="color:white"> Iniciar Sesión</h2>
                    </div>
                    <div class="login-form panel-body" style="padding-top: 0px!important">
                      @include('flash::message')
                      <!-- Antes estaba la ruta 'login', Att. Rafael -->
                      <form class="" method="POST" action="{{ route('post.login') }}" >
                        {{ csrf_field() }}
                          <!--<div class=" {{ $errors->has('email') ? ' has-error' : '' }}">-->
                             <label for="email" class="control-label">Correo Electrónico</label>
                                <input id="email" type="email" class="sisbeca-input" required name="email" value="{{ old('email') }}" >

                                @if ($errors->has('email'))
                                  <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                                @endif
                          <!--</div>-->
                          <!--<div class="{{ $errors->has('password') ? ' has-error' : '' }}">-->
                              <label for="password" class="control-label">Contraseña</label>
                              <input id="password" required type="password" class="sisbeca-input" name="password">

                                @if ($errors->has('password'))
                                  <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                  </span>
                                @endif
                          <!--</div>-->
                          
                          <div class="row">
                            <div class="col-lg-6">
                              <label class="pull-left">
                              <a href="{{ route('recuperar.contrasena') }}" style="color:#424242" >¿Olvidaste tu contraseña?</a>
                              </label>
                            </div>
                            
                            <div class="col-lg-6">
                              <button type="submit" class="btn sisbeca-btn-default btn-block pull-right">Ingresar</button>
                            </div>
                          </div>
                          <hr>
                          <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <!--<a href="{{ route('register') }}" class="btn sisbeca-btn-primary btn-block">Postularse a ProExcelencia</a>-->
                              <a href="{{ route('registro.postulante.becario') }}" class="btn sisbeca-btn-primary btn-block">Postularse a ProExcelencia</a>
                            </div>
                            <div class="col-lg-12 col-md-12 col-sm-12">
                              <!--<a href="{{route('registerMentor')}}" class="btn sisbeca-btn-primary btn-block">Postularse como Mentor</a>-->
                              <a href="{{route('registro.postulante.mentor')}}" class="btn sisbeca-btn-primary btn-block">Postularse como Mentor</a>
                            </div>
                          </div>
                          
                            
                          <!--  route('registerMentor') -->
                          
                          

                          @include('flash::message')
                          {{--  <p>¿No estas Registrado? <a href="{{ route('register') }}"> Registrate Aqui!</a></p> --}}

                      </form>
                    </div>
                  </div>
              </div>
            </div>
          </div>
       </div>

   </div>
   <!-- End Wrapper -->
   <!-- All Jquery -->

   @include('sisbeca.layouts.partials.filesjs')

</body>

</html>