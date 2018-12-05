@extends('sisbeca.layouts.main')
@section('title','Editar Solicitud/Reclamo')
@section('content')
<div class="col-lg-12">
    <div class="text-right">
        @if($solicitud->status==='enviada' && !is_null(avaa\Alerta::query()->where('solicitud','=',$solicitud->id)->where('leido','=',false)->first()))
            <button class='btn btn-sm sisbeca-btn-default' data-toggle='modal' data-target='#modal-default' >
                Cancelar Solicitud
            </button>
        @endif

        <a href="{{ route('solicitud.listar')}}" class="btn btn-sm sisbeca-btn-primary">Atrás</a>
       
    </div>
    <br>
    @if($solicitud->status ==='enviada')
    <div class="alert  alert-info alert-important" role="alert">
        Actualmente su solicitud se encuentra enviada y pendiente por procesar.
    </div>
    @else
        @if($solicitud->status==='aceptada')
        <div class="alert  alert-success alert-important" role="alert">
            Su solicitud fue aceptada exitosamente.!
        </div>
        @else
        <div class="alert  alert-danger alert-important" role="alert">
            Su solicitud ha sido rechazada.
        </div>
        @endif
    @endif

    <div class="col sisbeca-container-formulario">
        
        @if($solicitud->status==='enviada' && !is_null(avaa\Alerta::query()->where('solicitud','=',$solicitud->id)->where('leido','=',false)->first()))


            <form class="form-horizontal"   accept-charset="UTF-8" method="POST" action="{{route('solicitud.update',$solicitud->id)}}">

                {{csrf_field()}}
                {{method_field('PUT')}}

                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12 col-md-12 col-sm-6">
                            <label class="control-label" for="titulo" align="right">Tipo</label>
                            <select class="sisbeca-input" id="titulo" name="titulo" required>
                                @if($solicitud->titulo==='desincorporacion temporal')
                                    @if(Auth::user()->rol==='becario')
                                        @if(Auth::user()->becario->status==='activo' || Auth::user()->becario->status==='probatorio1' ||Auth::user()->becario->status==='probatorio2' )
                                            <option value='desincorporacion temporal' selected>Desincorporacion Temporal</option>

                                        @endif
                                    @else
                                        @if(Auth::user()->mentor->status==='activo')
                                            <option value='desincorporacion temporal' selected>Desincorporacion Temporal</option>
                                        @endif
                                    @endif
                                    <option value='desincorporacion definitiva'>Desincorporacion Definitiva</option>
                                    <option value='reincorporacion'>Reincorporacion</option>
                                    <option value="otros">Otros</option>
                                @else
                                    @if($solicitud->titulo==='desincorporacion definitiva')
                                        @if(Auth::user()->rol==='becario')
                                            @if(Auth::user()->becario->status==='activo' || Auth::user()->becario->status==='probatorio1' ||Auth::user()->becario->status==='probatorio2' )
                                            
                                                <option value='desincorporacion temporal'>Desincorporacion Temporal</option>

                                            @endif
                                        @else
                                            @if(Auth::user()->mentor->status==='activo')
                                                <option value='desincorporacion temporal'>Desincorporacion Temporal</option>
                                            @endif
                                        @endif
                                        <option value='desincorporacion definitiva' selected>Desincorporacion Definitiva</option>
                                        <option value='reincorporacion'>Reincorporacion</option>
                                        <option value="otros">Otros</option>
                                    @else
                                        @if($solicitud->titulo==='reincorporacion')
                                            @if(Auth::user()->rol==='becario')
                                                @if(Auth::user()->becario->status==='activo' || Auth::user()->becario->status==='probatorio1' ||Auth::user()->becario->status==='probatorio2' )
                                                
                                                    <option value='desincorporacion temporal'>Desincorporacion Temporal</option>

                                                @endif
                                            @else
                                                @if(Auth::user()->mentor->status==='activo')
                                                    <option value='desincorporacion temporal'>Desincorporacion Temporal</option>
                                                @endif
                                            @endif
                                            <option value='desincorporacion definitiva'>Desincorporacion Definitiva</option>
                                            <option value='reincorporacion' selected>Reincorporacion</option>
                                            <option value="otros">Otros</option>
                                        @else
                                                @if(Auth::user()->rol==='becario')
                                                    @if(Auth::user()->becario->status==='activo' || Auth::user()->becario->status==='probatorio1' ||Auth::user()->becario->status==='probatorio2' )
                                                
                                                        <option value='desincorporacion temporal'>Desincorporacion Temporal</option>

                                                    @endif
                                                @else
                                                    @if(Auth::user()->mentor->status==='activo')
                                                        <option value='desincorporacion temporal'>Desincorporacion Temporal</option>
                                                    @endif
                                                @endif
                                                <option value='desincorporacion definitiva'>Desincorporacion Definitiva</option>
                                                <option value='reincorporacion'>Reincorporacion</option>
                                                <option value="otros" selected>Otros</option>
                                        @endif
                                    @endif

                                @endif

                            </select>
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-6 rendered1">
                            <label class="control-label" for="datepicker1" align="right">Fecha de Inactividad</label>
                            @if(is_null($solicitud->fecha_inactividad))
                                <input type="text" class="sisbeca-input" id="datepicker1" name="fecha_inactividad" required>

                            @else
                                <input type="text" class="sisbeca-input" id="datepicker1" value="{{date('d/m/Y', strtotime($solicitud->fecha_inactividad))}}" name="fecha_inactividad" required>
                            @endif
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-6 rendered2">
                            <label class="control-label" for="datepicker2" align="right">Fecha de Desincorporación</label>
                            @if(is_null($solicitud->fecha_desincorporacion))
                                <input type="text" class="sisbeca-input" id="datepicker2" name="fecha_desincorporacion" required>
                            @else
                                <input type="text" class="sisbeca-input" id="datepicker2" value="{{date('d/m/Y', strtotime($solicitud->fecha_desincorporacion))}}" name="fecha_desincorporacion" required>
                            @endif
                        </div>

                        <div class="col-lg-12 col-md-12 col-sm-6">
                            <label class="control-label" align="right" for="descripcion">Descripción</label>
                            <textarea class="sisbeca-input sisbeca-textarea" name="descripcion" id="descripcion" rows="15" placeholder="Ingrese la descripción de su solicitud"  required>{{$solicitud->descripcion}}</textarea>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12 text-right" >
                    
                            <a href="{{route('solicitud.listar')}}" class="btn sisbeca-btn-default">
                                Atras
                            </a>

                            <button type="submit" class="btn sisbeca-btn-primary">
                                Actualizar solicitud
                            </button>
                        </div>
                    </div>
                </div>

            </form>
            
        @else
        <!--
            <div class="container section-ourTeam">
                <div class="row">

                    <div class="col-lg-12 col-md-4 col-sm-4 col-xs-12">
                        <div class="row section-info ourTeam-box ">
                            <div class="text-right col-12" align="right">

                                <strong>Status: </strong>
                                @if($solicitud->status==='aceptada')
                                    <span class="label label-light-success">
                                        <strong>{{strtoupper( $solicitud->status )}}</strong>
                                    </span>
                                @else
                                    @if($solicitud->status==='enviada')
                                        <span class="label label-light-warning">
                                            <strong>POR PROCESAR</strong>
                                        </span>
                                    @else
                                        <span class="label label-light-danger">
                                            <strong>{{strtoupper( $solicitud->status )}}</strong>
                                        </span>
                                    @endif
                                @endif

                            </div>

                            <div class="col-md-12 ">
                                <div class="row">

                                    <div class="col-md-1" ></div>
                                    <div class="col-md-2" >
                                        <img src="{{asset('images/perfil/solicitud.jpg')}}"  width="200" class="image-responsive">

                                    </div>


                                    <div class="col-md-7" >
                                        <strong style="font-size: 18px">
                                            Informacion de la Solicitud:
                                        </strong>

                                        <br/>

                                        <p style="color: black;font-size: 18px">
                                            <strong>Tipo:</strong>
                                            {{strtoupper($solicitud->titulo)}}
                                            <br/>

                                            <strong>Descripcion:</strong>
                                            {{$solicitud->descripcion}}
                                            <br/>

                                            @if($solicitud->status!=='enviada')
                                                <strong>Fecha Procesada:</strong>

                                                {{$solicitud->updated_at}}
                                                <br/>
                                            @endif

                                            <strong>#Solicitud: </strong>
                                            00{{$solicitud->id}}
                                        </p>
                                       
                                    </div>

                                </div>

                                <div class="col-lg-8" align="center">
                                    <a href="{{route('solicitud.showlist')}}" type="button" title="Atras" class='btn btn-xl btn-default text-center ' >Atras</a>

                                </div>

                            </div>

                            <div class="col-md-12 section3">

                            </div>
                        </div>
                    </div>

                </div>
            </div>
        -->
       @endif

        
    </div>

</div>


<!-- Modal para eliminar -->
<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Confirmación</h4>
            </div>

            <p align="center">¿Esta seguro que desea Eliminar la Siguiente Solicitud?</p>

            <div class="form-group form-modal-none">
                <strong> Titulo:</strong> {{strtoupper( $solicitud->titulo)}}</div>
            <div class="form-group form-modal-none">
                <strong> Status:</strong> {{strtoupper( $solicitud->status)}}</div>



            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cerrar</button>
                <button type="button" onclick="eliminar()" class="btn btn-danger pull-left" data-dismiss="modal">Eliminar</button>
            </div>

        </div>
    </div>
</div>
<!-- Modal para eliminar -->

@endsection
@if($solicitud->status==='enviada' && !is_null(avaa\Alerta::query()->where('solicitud','=',$solicitud->id)->where('leido','=',false)->first()))

    @section('personaljs')
        <script>

            function eliminar()
            {

                var route= "#";

                $.ajax({
                    url: route,
                    beforeSend: function() {
                        $('.preloader').show();
                    },
                    complete: function(){
                        location.assign("{{route('solicitud.destroy',$solicitud->id)}}");
                    }
                });

            }

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
                        @if(!is_null($solicitud->fecha_inactividad))
                           document.getElementById("datepicker1").value = "{{date('d/m/Y', strtotime($solicitud->fecha_inactividad))}}";
                                @endif
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
                            @if(!is_null($solicitud->fecha_desincorporacion))
                                document.getElementById("datepicker2").value = "{{date('d/m/Y', strtotime($solicitud->fecha_desincorporacion))}}";
                            @endif
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
                    @if(!is_null($solicitud->fecha_inactividad))
                    document.getElementById("datepicker1").value = "{{date('d/m/Y', strtotime($solicitud->fecha_inactividad))}}";
                    @endif
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
                        @if(!is_null($solicitud->fecha_desincorporacion))
                        document.getElementById("datepicker2").value = "{{date('d/m/Y', strtotime($solicitud->fecha_desincorporacion))}}";
                        @endif
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
@endif
