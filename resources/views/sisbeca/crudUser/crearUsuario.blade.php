@extends('sisbeca.layouts.main')
@section('title','Crear Usuario')
@section('content')

<div class="col-lg-12">
    <div class="text-right">
        <a href="{{route('mantenimientoUser.index')}}" class="btn btn-sm sisbeca-btn-primary">Atrás</a>
    </div>
    <br>
    <div class="col sisbeca-container-formulario">
        <form class="form-horizontal" action="{{route('mantenimientoUser.store')}}" accept-charset="UTF-8" method="POST">
            {{csrf_field()}}
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <label for="name" class="control-label">Nombre y Apellido</label>
                        <input class="sisbeca-input" placeholder="Ingrese Nombre y Apellido..." value="{{old('name')}}"
                            required name="name" type="text" id="name">
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <label for="cedula" class="control-label">Cedula</label>
                        <input class="sisbeca-input" placeholder=" Ingrese Cedula..." value="{{old('cedula')}}"
                                name="cedula" type="text" id="cedula">
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <label for="rol" class="control-label">Rol</label>
                        <select class="sisbeca-input" required id="rol" name="rol">
                            <option value=''>Seleccione Rol</option>
                            <option value='directivo'>Directivo</option>
                            <option value='editor'>Editor (Pasante)</option>
                            <option value='coordinador'>Coordinador</option>
                            <option value='entrevistador'>Entrevistador</option>
                        </select>
                    </div>
                
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <label for="cedula" class="control-label">Correo Electronico</label>
                        <input class="sisbeca-input" placeholder="Ingrese Email..." value="{{old('email')}}"
                                name="email" type="email" id="email" required>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <label for="password" class="control-label">Contraseña</label>
                        <input class="sisbeca-input" placeholder="Ingrese Contraseña..." name="password"
                                type="password" id="password" required>
                    </div>

                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <label for="password-repeat"  class="control-label">Repetir Contraseña</label>
                        <input class="sisbeca-input" placeholder="Repita Contraseña..." name="password-repeat"
                                type="password" id="password-repeat" required>
                    </div>
                </div>
            </div>
            <hr>
            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12 text-right" >
                        <button onclick="Regresar()" class="btn sisbeca-btn-default" type="button">Cancelar</button>

                        <input class="btn sisbeca-btn-primary" type="submit" value="Guardar">
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@section('personaljs')
<script type="text/javascript">

    function Regresar() {

        var route = "{{route('mantenimientoUser.index')}}";


        location.assign(route);

    }
</script>
@endsection