@extends('sisbeca.layouts.main')
@section('title','Gestion de Solicitudes')
@section('subtitle','Revisar Solicitud')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="fa fa-male fa-fw"></span> Solicitud de {{$solicitud->user->name.' '.$solicitud->user->last_name}}</div>


                <div class="container section-ourTeam">
                    <div class="row">

                        <div class="col-lg-12 col-md-4 col-sm-4 col-xs-12">
                            <div class="row section-info ourTeam-box text-center">
                                <div class="text-right col-12" align="right">
                                    <strong>Status: </strong>
                                        @if($solicitud->status==='aceptada')
                                            <span class="label label-light-success"><strong>{{strtoupper( $solicitud->status )}}</strong></span>
                                        @else
                                            @if($solicitud->status==='enviada')
                                            <span class="label label-light-warning"><strong>POR PROCESAR</strong></span>
                                                @else
                                            <span class="label label-light-danger"><strong>{{strtoupper( $solicitud->status )}}</strong></span>
                                                @endif
                                        @endif

                                </div>

                                <div class="col-md-12 section1">
                                    @if($img_perfil_postulante->count()>0)
                                        <img src="{{asset($img_perfil_postulante[0]->url)}}" class="image-responsive img-circle img-fluid img-rounded img-thumbnail perfil-img">

                                    @else

                                        @if($solicitud->user->sexo==='femenino')
                                            <img src="{{asset('images/perfil/femenino.png')}}" class="image-responsive img-circle img-fluid img-rounded img-thumbnail perfil-img">
                                        @else
                                            <img src="{{asset('images/perfil/masculino.png')}}" class="image-responsive img-circle img-fluid img-rounded img-thumbnail perfil-img">

                                        @endif

                                    @endif
                                </div>
                                <div class="col-md-12 section2">
                                    <div class="row">

                                        <div class="col-md-2" >

                                        </div>




                                    <div class="col-md-8" >
                                        <strong>  Datos del Solicitante:</strong> <br/>
                                        <p>
                                            <i class="icon fa fa-caret-right"></i><span class="label label-light-info">{{$solicitud->user->name.' '.$solicitud->user->last_name}}</span>
                                            <br/><i class="icon fa fa-caret-right"></i>Rol: {{ucwords($solicitud->user->rol)}}
                                            <br/><i class="icon fa fa-caret-right"></i>CI: {{$solicitud->user->cedula}}
                                            <br/><i class="icon fa fa-envelope"></i> {{$solicitud->user->email}}
                                            <br/><span class=" fa fa-venus-mars"> {{ucwords($solicitud->user->sexo)}}</span><br/>
                                            <span class="fa fa-birthday-cake"> {{ date("d/m/Y", strtotime($solicitud->user->fecha_nacimiento)) }}</span>
                                    <p style="color: black !important;border-style: groove;"> <strong>Tipo:</strong> {{strtoupper($solicitud->titulo)}}<br/>
                                        <strong>Descripcion:</strong> {{$solicitud->descripcion}}</span><br/>
                                        <strong>Fecha de Solicitud:</strong> {{date("d/m/Y h:i:s A", strtotime($solicitud->updated_at))}}</p>

                                        @if(!is_null($solicitud->fecha_inactividad))
                                            <p style="font-size: 20px">
                                            <span class="label label-light-warning"><strong>Esta Solicitud puede ser aprobada desde el {{ date("d/m/Y", strtotime($solicitud->fecha_inactividad))}}</strong></span>
                                            </p>
                                        @else
                                                @if(!is_null($solicitud->fecha_desincorporacion))
                                                <p style="font-size: 20px">
                                                <span class="label label-light-warning"><strong>Esta Solicitud puede ser aprobada desde el {{ date("d/m/Y", strtotime($solicitud->fecha_desincorporacion))}}</strong></span>
                                                    </p>
                                            @endif
                                            @endif
                                    </div>


                                    </div>




                                    <button onclick="Regresar()" class="btn btn-default" type="button" >Atras</button>&nbsp;
                                    @if($solicitud->status==='enviada')

                                        @if(!is_null($solicitud->fecha_inactividad))
                                            @if(strtotime(date("Y-m-d", strtotime($solicitud->fecha_inactividad)))<=strtotime(date("Y-m-d",time())))

                                                <button type='button' title="Aprobar" class='btn btn-primary' data-toggle='modal' data-target='#modal' >Aprobar</button>

                                            @endif
                                            @else
                                            @if(!is_null($solicitud->fecha_desincorporacion))
                                                @if(strtotime(date("Y-m-d", strtotime($solicitud->fecha_desincorporacion)))<=strtotime(date("Y-m-d",time())))

                                                    <button type='button' title="Aprobar" class='btn btn-primary' data-toggle='modal' data-target='#modal' >Aprobar</button>

                                                @endif
                                                @else
                                                <button type='button' title="Aprobar" class='btn btn-primary' data-toggle='modal' data-target='#modal' >Aprobar</button>
                                                @endif
                                            @endif


                                    <button type='button' title="Rechazar" class='btn btn-danger' data-toggle='modal' data-target='#modal-default' >Rechazar</button>

                                    @endif

                                </div>

                                <div class="col-md-12 section3">

                                </div>
                            </div>
                        </div>

                    </div>
                </div>


            </div>

        </div>
    </div>
    </div>


    <div class="modal fade" id="modal">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmación</h4>
                </div>

                <p align="center">¿Esta seguro que desea Aprobar la solicitud de {{$solicitud->user->name}}?</p>

                <form method="POST" action={{route('gestionSolicitud.update',$solicitud->id)}} accept-charset="UTF-8">

                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <input type="hidden" id='valor' name="valor" value="1">
                    @if($solicitud->titulo==='retroactivo')
                        <label>Indique Retroactivo: </label>
                        <input type="text" onkeypress="handleNumber(event, '{20,2}')" placeholder="Indique Retroactivo" size=23 id='retroactivo' value="{{number_format(old('retroactivo'), 2, ',', '.')}}" name="retroactivo" required >
                    @endif
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-info pull-left">Si</button>
                    </div>

                </form>

            </div>


        </div>

        <!-- /.modal-content -->
    </div>


    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Confirmación</h4>
                </div>

                <p align="center">¿Esta seguro que desea Rechazar la solicitud de {{$solicitud->user->name}}?</p>

                <form method="POST" action={{route('gestionSolicitud.update',$solicitud->id)}} accept-charset="UTF-8">

                    {{csrf_field()}}
                    {{method_field('PUT')}}
                    <input type="hidden" id='valor2' name="valor"  value="0">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                        <button type="submit" class="btn btn-info pull-left" >Si</button>
                    </div>

                </form>

            </div>


        </div>

        <!-- /.modal-content -->
    </div>


@endsection


@section('personaljs')
    <script type="text/javascript">

        function Regresar() {

            var route= "{{route('gestionSolicitudes.listar')}}";


            location.assign(route);

        }

        function handleNumber(event, mask) {
            /* numeric mask with pre, post, minus sign, dots and comma as decimal separator
                {}: positive integer
                {10}: positive integer max 10 digit
                {,3}: positive float max 3 decimal
                {10,3}: positive float max 7 digit and 3 decimal
                {null,null}: positive integer
                {10,null}: positive integer max 10 digit
                {null,3}: positive float max 3 decimal
                {-}: positive or negative integer
                {-10}: positive or negative integer max 10 digit
                {-,3}: positive or negative float max 3 decimal
                {-10,3}: positive or negative float max 7 digit and 3 decimal
            */
            with (event) {
                stopPropagation()
                preventDefault()
                if (!charCode) return
                var c = String.fromCharCode(charCode)
                if (c.match(/[^-\d,]/)) return
                with (target) {
                    var txt = value.substring(0, selectionStart) + c + value.substr(selectionEnd)
                    var pos = selectionStart + 1
                }
            }
            var dot = count(txt, /\./, pos)
            txt = txt.replace(/[^-\d,]/g,'')

            var mask = mask.match(/^(\D*)\{(-)?(\d*|null)?(?:,(\d+|null))?\}(\D*)$/); if (!mask) return // meglio exception?
            var sign = !!mask[2], decimals = +mask[4], integers = Math.max(0, +mask[3] - (decimals || 0))
            if (!txt.match('^' + (!sign?'':'-?') + '\\d*' + (!decimals?'':'(,\\d*)?') + '$')) return

            txt = txt.split(',')
            if (integers && txt[0] && count(txt[0],/\d/) > integers) return
            if (decimals && txt[1] && txt[1].length > decimals) return
            txt[0] = txt[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.')

            with (event.target) {
                value = mask[1] + txt.join(',') + mask[5]
                selectionStart = selectionEnd = pos + (pos==1 ? mask[1].length : count(value, /\./, pos) - dot)
            }

            function count(str, c, e) {
                e = e || str.length
                for (var n=0, i=0; i<e; i+=1) if (str.charAt(i).match(c)) n+=1
                return n
            }
        }
    </script>
@endsection
