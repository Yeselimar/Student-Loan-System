@extends('sisbeca.layouts.main')
@section('title','Reporte')
@section('subtitle','Solicitudes')
@section('content')

    <div class="row">
        <!-- Column -->
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><span class="fa  fa-clone fa-fw"></span>
                        Reporte de Solicitudes
                    </div>

                    <div class="row justify-content-center">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-validation">
                                        <form class="form-horizontal" method="get" action ="{{ route('reporteSolicitudes.pdf') }}">

                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="datepicker">Fecha Desde <span class="text-danger">*</span></label>
                                                <div class="col-lg-6">
                                                    <input  name="fechaDesde" value="{{old('fechaDesde')}}" type="text" id="datepicker" required placeholder="Ingrese Fecha Desde..." class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="datepicker2">Fecha Hasta <span class="text-danger">*</span></label>
                                                <div class="col-lg-6">
                                                    <input  name="fechaHasta" type="text" value="{{old('fechaHasta')}}"  id="datepicker2" required placeholder="Ingrese Fecha Hasta..." class="form-control">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-lg-4 col-form-label" for="user_id">Usuario</label>
                                                <div class="col-lg-6">
                                                    <select class="form-control select-user" style="height: 400px !important;" id="user_id" name="user_id">
                                                        <option value=0 >Todos</option>

                                                    @foreach($users as $user)
                                                            <option value={{$user->id}}>{{$user->name.' '.$user->last_name}}- Email: {{$user->email}} - Rol: {{$user->rol}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <div class="col-lg-8 ml-auto">
                                                    <button type="submit" class="btn btn-primary">Cargar Datos</button>
                                                </div>
                                            </div>
                                        </form>
                                        @if(isset($user_id) && isset($fechaDesde) && isset($fechaHasta))
                                            <a href="{{ route('solicitudes.pdf',array('fechaDesde'=>$fechaDesde,'fechaHasta'=>$fechaHasta,'user_id'=>$user_id)) }}" class="btn btn-xs btn-danger pull-right" target="_blank">Generar PDF</a>

                                            @endif
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <!-- Column -->
    </div>
@endsection

@section('personaljs')
    <script>
        $( function() {
            $( "#datepicker" ).datepicker({maxDate: "+1M +0D",orientation: "bottom" });
            $( "#datepicker2" ).datepicker({maxDate: "+1M +0D",orientation: "bottom" });

        } );
        $('.select-user').chosen({

            placeholder_text_single:'Seleccione un Usuario',
            no_results_text: 'No se encontraron resultados'

        });
    </script>

@endsection