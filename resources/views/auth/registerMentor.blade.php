
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
    <title>Avaa - Registrarse</title>

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

    <div class="container">
        <div class="row">
            @include('flash::message')
            <div class="col-lg-12 col-md-9 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading"  align="center"><h2 style="color: white">Postalarse como Mentor</h2></div>
                    
                    <div class="panel-body">

                        <form role="form" class="f1 formMultiple" method="post" action="{{ route('registerMentor') }}" enctype="multipart/form-data">
                            {{ csrf_field() }}


                            <div class="f1-steps">
                                <div class="f1-progress">
                                    <div class="f1-progress-line" data-now-value="50" data-number-of-steps="2" style="width: 50%;"></div>
                                </div>
                                <div class="f1-step active" style="width: 50% !important">
                                    <div class="f1-step-icon"><i class="fa fa-key"></i></div>
                                    <p>Cuenta</p>
                                </div>

                                <div class="f1-step" style="width: 50% !important">
                                    <div class="f1-step-icon"><i class="fa fa-user"></i></div>
                                    <p>Personal</p>
                                </div>
                            </div>
                            {{-------------------------------- Datos de Cuenta --------------------------}}

                            <fieldset>
                                <h4>Creacion de Cuenta:</h4>


                                <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                    <label class="sr-only" for="email">Email</label>
                                    <input type="text" name="email" placeholder="Email..." class="f1-email form-control" id="f1-email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                                    <label class="sr-only" for="password">Contraseña</label>
                                    <input type="password" name="password" placeholder="Contraseña..." class="f1-password form-control" id="f1-password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="f1-repeat-password">Repetir Contraseña</label>
                                    <input type="password" placeholder="Repetir Contraseña..."
                                           class="f1-repeat-password form-control" id="f1-repeat-password" name="password_confirmation" required>
                                </div>
                                <div class="form-group">
                                    <label for="image">Imagen Perfil</label>
                                    <input name="image_perfil" accept="image/*"  type="file" id="image">
                                    @if ($errors->has('image_perfil'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('image_perfil') }}</strong>
                                    </span>
                                    @endif
                                </div>
                                <div class="f1-buttons">

                                    <button type="button" class="btn btn-next">Siguiente</button>
                                </div>
                            </fieldset>
                            {{-------------------------------- Datos Personales --------------------------}}
                            <fieldset>
                                <h4>Complete sus Datos Personales:</h4>
                                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label class="sr-only" for="name">Nombre</label>
                                    <input type="text" name="name" placeholder="Nombre..." class="f1-first-name form-control" id="f1-first-name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group {{ $errors->has('last_name') ? ' has-error' : '' }}">
                                    <label class="sr-only" for="last_name">Apellido</label>
                                    <input type="text" name="last_name" placeholder="Apellido..." class="form-control" id="last_name" value="{{ old('last_name') }}" required autofocus>

                                    @if ($errors->has('last_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label class="sr-only" for="cedula">Cedula</label>
                                    <input type="text" value="{{ old('cedula') }}" name="cedula" placeholder="Cedula..." class="form-control" id="cedula">
                                    @if ($errors->has('cedula'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('cedula') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <div class="form-group">
                                    <label class="sr-only" for="datepicker">Fecha de Nacimiento</label>
                                    <input  name="fecha_nacimiento" type="text" id="datepicker" required placeholder="Fecha de Nacimiento..." class="form-control">
                                    @if ($errors->has('fecha_nacimiento'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('fecha_nacimiento') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="edad">Edad:</label>
                                    <div>
                                        <input required name="edad" readonly="true" type="number" id="edad">
                                    </div>
                                    @if ($errors->has('edad'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('edad') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                    <label for="url_pdf">Sexo:</label>
                                    <div>
                                        <select class="form-control " required id="sexo" name="sexo">
                                            <option value=''>Seleccione</option>
                                            <option value='masculino'>Masculino</option>
                                            <option value='femenino'>Femenino</option>
                                        </select>
                                    </div>
                                    @if ($errors->has('sexo'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('sexo') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="form-group">
                                     <label for="url_pdf">Cargue su Hoja de Vida:</label>
                                      <div>
                                          <input required name="url_pdf" accept="application/pdf" type="file" id="url_pdf">
                                      </div>
                                    @if ($errors->has('url_pdf'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('url_pdf') }}</strong>
                                    </span>
                                    @endif
                                </div>

                                <div class="f1-buttons">
                                    <button type="button" class="btn btn-previous">Anterior</button>
                                    <button type="submit" class="btn btn-primary">Postularse</button>
                                </div>


                            </fieldset>

                        </form>

                    </div>
                    


                
                </div>
            </div>
        </div>
    </div>
<!-- Modal -->
<div class="modal fade" id="modal" role="dialog">
       <div class="modal-dialog">
           <div class="modal-content-ment">
               

               <p align="center"> <img src="images/postulacion-mentor.png"></p>

           </div>


       </div>

       
   </div>
   <!-- /.modal-content -->

</div>
<!-- End Wrapper -->
<!-- All Jquery -->

@include('sisbeca.layouts.partials.filesjs')
<script>
    $( function() {
        $( "#datepicker" ).datepicker({maxDate: "-192M +0D",orientation: "bottom" });
    } );

    $(document).ready(function(){

        var mivalor= $("#datepicker").val();


        $("#datepicker").change(function() {
            mivalor =   $("#datepicker").val();

            var valor=mivalor.split("/");

            var ano = valor[2];
            var mes = valor[1];
            var dia = valor[0];

            // cogemos los valores actuales
            var fecha_hoy = new Date();
            var ahora_ano = fecha_hoy.getFullYear();
            var ahora_mes = fecha_hoy.getMonth()+1;
            var ahora_dia = fecha_hoy.getDate();

            // realizamos el calculo
            var edad = ahora_ano  - ano;
            if ( ahora_mes < mes )
            {
                edad--;
            }
            if ((mes == ahora_mes) && (ahora_dia < dia))
            {
                edad--;
            }


            if(!isNaN(edad))
            {
                document.getElementById("edad").value=edad;
            }
            else
            {
                document.getElementById("edad").value=null;

            }


        });





    });


   $(document).ready(function()
   {
      $("#modal").modal("show");
   });

</script>
</body>

</html>
