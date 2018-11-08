@extends('sisbeca.layouts.main')
@section('title','Reporte de Solicitudes')
@section('content')
<div class="col-lg-12">
    <p class="text-left">Reporte de Solicitud</p>
    <div class="col sisbeca-container-formulario">
        <div class="form-validation">
            <form class="form-horizontal" method="get" action ="{{ route('reporteSolicitudes.pdf') }}">

                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <label class="control-label" for="datepicker">Fecha Desde *</label>
                            <input  name="fechaDesde" value="{{old('fechaDesde')}}" type="text" id="datepicker" placeholder="DD/MM/AAA" class="sisbeca-input" required>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <label class="control-label" for="datepicker2">Fecha Hasta*</label>
                            <input  name="fechaHasta" type="text" value="{{old('fechaHasta')}}"  id="datepicker2" placeholder="DD/MM/AAA" class="sisbeca-input" required>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-6">
                            <label class="control-label" for="user_id">Usuario</label>
                            <select class="sisbeca-input sisbeca-select" id="user_id" name="user_id">
                                <option value=0 >Todos</option>
                                @foreach($users as $user)
                                    <option value={{$user->id}}>
                                        {{$user->name.' '.$user->last_name}}- Email: {{$user->email}} - Rol: {{$user->rol}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group">
                    <div class="row">
                        <div class="col-lg-12 text-right" >
                            <button type="submit" class="btn sisbeca-btn-primary">Cargar Datos</button>
                        </div>
                    </div>
                </div>
            </form>

            @if(isset($user_id) && isset($fechaDesde) && isset($fechaHasta))
                <a href="{{ route('solicitudes.pdf',array('fechaDesde'=>$fechaDesde,'fechaHasta'=>$fechaHasta,'user_id'=>$user_id)) }}" class="btn btn-xs btn-danger pull-right" target="_blank">Generar PDF</a>

            @endif
        </div>
    </div>
</div>
@endsection

@section('personaljs')
<script>
    $('#datepicker').datepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        orientation: 'bottom',
        autoclose: true,
    });
    $('#datepicker2').datepicker({
        format: 'dd/mm/yyyy',
        language: 'es',
        orientation: 'bottom',
        autoclose: true,
    });
    $('#user_id').chosen({

        placeholder_text_single:'Seleccione un usuario',
        no_results_text: 'No se encontraron resultados'

    });
</script>
@endsection