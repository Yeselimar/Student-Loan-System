@extends('sisbeca.layouts.main')
@section('title','Mantenimiento Usuario')
@section('subtitle','Editar Usuario')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="panel panel-default">
            <div class="panel-heading"><span class="fa fa-user fa-fw"></span> Editar</div>

            <div class="panel-body">
                <form method="POST" action={{route('mantenimientoUser.update',$user->id)}} accept-charset="UTF-8">


                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="name"  class="control-label">Nombre y Apellido</label>
                                <input class="sisbeca-input" placeholder="Ingrese Nombre y Apellido..." value="{{$user->name}}"
                                    required name="name" type="text" id="name">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="cedula"  class="control-label">Cedula</label>
                                <input class="sisbeca-input" placeholder="Ingrese Cedula..." value="{{$user->cedula}}"
                                    name="cedula" type="text" id="cedula">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="rol"  class="control-label">Rol</label>
                                <select class="sisbeca-input" required id="rol" name="rol">
                                    <option value=''>Seleccione Rol</option>
                                    @if($user->rol=='directivo')
                                    <option selected value='directivo'>Directivo</option>
                                    @else
                                    <option value='directivo'>Directivo</option>
                                    @endif

                                    @if($user->rol=='editor')
                                    <option selected value='editor'>Editor (Pasante)</option>
                                    @else
                                    <option value='editor'>Editor (Pasante)</option>
                                    @endif

                                    @if($user->rol=='coordinador')
                                    <option selected value='coordinador'>Coordinador</option>
                                    @else
                                    <option value='coordinador'>Coordinador</option>
                                    @endif

                                    @if($user->rol=='entrevistador')
                                    <option selected value='entrevistador'>Entrevistador</option>
                                    @else
                                    <option value='entrevistador'>Entrevistador</option>
                                    @endif



                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="cedula"  class="control-label">Correo Electronico</label>
                                <input class="sisbeca-input" placeholder="Ingrese Email..." value="{{$user->email}}"
                                    required name="email" type="email" id="email">
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="password"  class="control-label">Contraseña</label>
                                <input class="sisbeca-input" placeholder="Ingrese Contraseña..." required name="password"
                                    type="password" id="password">
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <div class="form-group">
                                <label for="password-repeat"  class="control-label">Repetir Contraseña</label>
                                <input class="sisbeca-input" placeholder="Repita Contraseña..." required name="password-repeat"
                                    type="password" id="password-repeat">
                            </div>
                        </div>


                    </div>

                    <div class="form-group" align="center">
                        <button onclick="Regresar()" class="btn sisbeca-btn-default" type="button">Cancelar</button>&nbsp;&nbsp;

                        <input class="btn sisbeca-btn-primary" type="submit" value="Guardar">
                    </div>
                </form>
            </div>
        </div>
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