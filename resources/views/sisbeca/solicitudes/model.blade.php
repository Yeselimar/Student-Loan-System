@extends('sisbeca.layouts.main')
@section('title',$model=='crear' ? 'Crear Solicitud' : 'Editar Solicitud ')
@section('content')
<div class="col-lg-12">
    <div class="text-right">
        <a href="{{ route('solicitud.listar')}}" class="btn btn-sm sisbeca-btn-primary">Atrás</a>
    </div>
    <br>
    <div class="col sisbeca-container-formulario">
        <form class="form-horizontal"  accept-charset="UTF-8" method="POST" action="{{route('solicitud.store')}}">

            {{csrf_field()}}

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-6">
                        <label class="control-label" for="titulo">Tipo</label>
                        <select class="sisbeca-input" id="titulo" name="titulo" required>
                            <option value="">Seleccione</option>
                            @if(Auth::user()->rol==='becario')
                               @if(Auth::user()->becario->status==='activo' || Auth::user()->becario->status==='probatorio1' ||Auth::user()->becario->status==='probatorio2' )
                                    <option value='retroactivo'>Retroactivo</option>
                                    <option value='desincorporacion temporal'>Desincorporación Temporal</option>

                                @endif
                            @else
                                    @if(Auth::user()->mentor->status==='activo')
                                    <option value='desincorporacion temporal'>Desincorporación Temporal</option>
                                        @endif
                            @endif
                            <option value='desincorporacion definitiva'>Desincorporación Definitiva</option>
                            <option value='reincorporacion'>Reincorporación</option>
                            <option value="otros">Otros</option>
                        </select>
                    </div>
           
                    <div class="col-lg-12 col-md-12 col-sm-6 rendered1">
                        <label class="control-label" for="datepicker1">Fecha de Inactividad</label>
                        <input type="text" class="sisbeca-input" id="datepicker1" name="fecha_inactividad" required>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-6 rendered2">
                        <label class="control-label" for="datepicker2">Fecha de Desincorporación</label>
                        <input type="text" class="sisbeca-input" id="datepicker2" name="fecha_desincorporacion" required>
                    </div>

                    <div class="col-lg-12 col-md-12 col-sm-6 ">
                        <label class="control-label">Descripción</label>
                        <textarea class="sisbeca-input sisbeca-textarea" name="descripcion" id="descripcion" placeholder="Ingrese la descripción de su solicitud">{{old('descripcion')}}</textarea required>
                    </div>

                </div>
            </div>

            <hr>    

            <div class="form-group">
                <div class="row">
                    <div class="col-lg-12 text-right" >
                        <a href="#" class="btn sisbeca-btn-default">Atrás</a>
                        <button type="submit" class="btn sisbeca-btn-primary">
                            Registrar solicitud
                        </button>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>

@endsection

@section('personaljs')
<script>
$(document).ready(function()
{

    var mivalor= $("#titulo").val();


    $("#titulo").change(function()
    {
        mivalor =   $("#titulo").val();
        if(mivalor=='desincorporacion temporal')
        {

            $(".rendered1").show();
            $(".rendered2").hide();
            document.getElementById("datepicker2").value = null;
            $("#datepicker2").removeAttr('required');
            $("#datepicker1").attr("required", "required")


        }
        else
        {
            if(mivalor=='desincorporacion definitiva')
            {
                $(".rendered2").show();
                $(".rendered1").hide();
                document.getElementById("datepicker1").value = null;
                $("#datepicker1").removeAttr('required');
                $("#datepicker2").attr("required", "required")
            }
            else {
                $("#datepicker1").removeAttr('required');
                $("#datepicker2").removeAttr('required');
                document.getElementById("datepicker1").value = null;
                document.getElementById("datepicker2").value = null;
                $(".rendered1").hide();
                $(".rendered2").hide();
            }



        }
    });


    if(mivalor=='desincorporacion temporal')
    {
        $(".rendered1").show();
        $(".rendered2").hide();
        $("#datepicker2").removeAttr('required');
        document.getElementById("datepicker2").value = null;
        $("#datepicker1").attr("required", "required")
    }
    else
    {
        if(mivalor=='desincorporacion definitiva')
        {
            $(".rendered2").show();
            $(".rendered1").hide();
            $("#datepicker1").removeAttr('required');
            document.getElementById("datepicker1").value = null;
            $("#datepicker2").attr("required", "required")
        }
        else {
            $("#datepicker1").removeAttr('required');
            $("#datepicker2").removeAttr('required');
            document.getElementById("datepicker1").value = null;
            document.getElementById("datepicker2").value = null;
            $(".rendered1").hide();
            $(".rendered2").hide();
        }

    }

});

$('#datepicker1').datepicker({
    format: 'dd/mm/yyyy',
    language: 'es',
    orientation: 'bottom',
    autoclose: true,
    minDate: 0,
    maxDate: "+1M +0D",
    orientation: "bottom"
});

$('#datepicker2').datepicker({
    format: 'dd/mm/yyyy',
    language: 'es',
    orientation: 'bottom',
    autoclose: true,
    minDate: 0,
    maxDate: "+1M +0D",
});

</script>
@endsection