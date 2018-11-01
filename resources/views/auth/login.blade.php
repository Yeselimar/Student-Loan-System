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
   <title>Avaa - Iniciar Sesión</title>

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

       <div class="unix-login">
          <div class="container-fluid">

            <div class="row justify-content-center">
              <div class="col-lg-5">
                  <div class="login-content panel panel-default">
                    <div class="panel-heading" align="center">
                      <h2 style="color:white"> Iniciar Sesión</h2>
                    </div>
                    <div class="login-form panel-body">
                      <form class="" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}
                          <!--<div class=" {{ $errors->has('email') ? ' has-error' : '' }}">-->
                             <label for="email" class="control-label">Correo Electronico</label>
                                <input id="email" type="email" class="sisbeca-input" name="email" value="{{ old('email') }}" >

                                @if ($errors->has('email'))
                                  <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                  </span>
                                @endif
                          <!--</div>-->
                          <!--<div class="{{ $errors->has('password') ? ' has-error' : '' }}">-->
                              <label for="password" class="control-label">Contraseña</label>
                                <input id="password" type="password" class="sisbeca-input" name="password">

                                @if ($errors->has('password'))
                                  <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                  </span>
                                @endif
                          <!--</div>-->
                           
                          <label class="pull-right">
                            <a href="{{ route('password.request') }}" style="color:#424242">¿Olvidaste tu contraseña?</a>
                          </label>
                          
                          
                          <button type="submit" class="btn sisbeca-btn-default btn-block">Ingresar</button>

                          <a href="{{ route('register') }}" class="btn sisbeca-btn-primary btn-block">
                            Postularse a ProExcelencia
                          </a>
                            
                          <!--  route('registerMentor') -->
                          <a href="{{route('registerMentor')}}" class="btn sisbeca-btn-primary btn-block">Postularse como Mentor
                          </a>
                          

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