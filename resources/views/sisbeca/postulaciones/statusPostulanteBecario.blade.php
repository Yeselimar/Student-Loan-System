@extends('sisbeca.layouts.main')
@section('title','Inicio')
@section('content')
<div class="col-12">
    <div class="panel panel-default">
        <div class="col-md-12">
            <br>
            <strong>
                <span class="fa fa-users fa-fw"></span> Postulación 
            </strong>
            <hr>
                <div class="offset-md-4 col-md-4 offset-lg-4 col-lg-4">
                    <div class="panel panel-default">
                        <div align="center">
                            <div class="panel-heading"> {{$postulante->user->name}} {{$postulante->user->last_name}}</div>
                            <div class="panel-body">              
                                @if($postulante->status==='entrevista')
                                <div class="alert  alert alert-info" role="alert">
                                        Su postulación ha sido revisada y usted ha sido seleccionado para ir a Entrevista
                                </div>
                                    <p> <b>Estatus: </b> <span class="label label-warning">Aprobado para Entrevista</span></p>
                                    <p> <b>Datos para la Entrevista:</b></p>
                                    <p> <b>Fecha: </b> {{$postulante->fechaEntrevista()}}</p>
                                    <p> <b>Hora: </b>{{$postulante->horaEntrevista()}}</p>
                                    <p> <b>Lugar: </b>{{$postulante->lugar_entrevista}}</p>
                                    <p> <b>Entrevistadores:</b></p>
                                    @foreach($entrevistadores as $entrevistador)
                                    <p>{{$entrevistador->name}} {{$entrevistador->last_name}}</p>
                                    @endforeach
                                @elseif($postulante->status==='entrevistado')
                                <p> <b>Estatus: </b> <span class="label label-inverse">Entrevistado</span></p>
                                <p> <b>Fecha: </b> {{$postulante->fechaEntrevista()}}</p>
                                <p> <b>Hora: </b>{{$postulante->horaEntrevista()}}</p>
                                <p> <b>Lugar: </b>{{$postulante->lugar_entrevista}}</p>
                                <p> <b>Entrevistadores:</b></p>
                                @foreach($entrevistadores as $entrevistador)
                                <p>{{$entrevistador->name}} {{$entrevistador->last_name}}</p>
                                @endforeach
                                @elseif($postulante->status==='rechazado')
                                <div class="alert alert-danger" role="alert">
                                        Su postulación ha sido revisada y usted no ha quedo asignado en el proceso de selección. Agradecemos por su participación.
                                </div>
                                    <p>Estatus: <span class="label label-danger">No Aprobado</span></p>
                                @elseif($postulante->status==='activo')    
                                <div class="alert  alert alert-success" role="alert">
                                        ¡Felicidades! {{$postulante->user->name}} {{$postulante->user->last_name}} has sido asignad@ como Becario al programa ProExcelencia. Esta atent@ para la fecha de inicio de actividades.
                                </div>
                                    <p>Estatus: <span class="label label-success"> Aprobado</span></p>
                                @else
                                    <div class="alert  alert-info alert-important" role="alert">
                                            Su postulación fue enviada exitosamente, actualmente se encuentra en proceso de ser revisada por nuestro equipo técnico.
                                    </div>
                                    <p><b>Estatus: </b>
                                        <span class="label label-default">Pendiente</span>   <i class="fa fa-refresh fa-spin"></i></p>
                                @endif
                            </div>
                        </div>
                </div>
                </div>
        </div>
    </div>
</div>
@endsection


