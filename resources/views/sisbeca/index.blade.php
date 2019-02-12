

@if(Auth::user()->rol==='postulante_becario'&& Auth::user()->becario->status==='activo' &&  Auth::user()->becario->acepto_terminos== 0 && Auth::user()->becario->getfechabienvenida()=='true')
	@section('title','Terminos y Condiciones ProExcelencia')
	@section('subtitle','Terminos y Condiciones')
	@section('content')
		@include('sisbeca.becarios.terminosCondiciones')
	@endsection
@else
@extends('sisbeca.layouts.main')
@section('title','Inicio')
	@if((Auth::user()->rol==='postulante_becario')||(Auth::user()->rol==='postulante_mentor'))
		@section('subtitle','Pasos')
	@else
			@section('subtitle','Bienvenido')
	@endif

@section('content')

	<div class="container" style="border:1px solid #dedede;padding: 10px;border-radius: 10px;">
		<h3 class="text-center" >
			<strong>!Hola, {{ Auth::user()->nombreyapellido()}}!</strong>
		</h3>
	</div>
	<br>
	<div class="container">
		<div class="row">
			<div class='col-sm-12' align="center" >
				@if((Auth::user()->rol==='postulante_becario')||(Auth::user()->rol==='postulante_mentor'))
					<p> Pasos a Seguir </p>
					@if(Auth::user()->rol==='postulante_becario')
						<div class="col-lg-4"></div>
						<div class="col-lg-4">
							<img src="{{asset('images/postulacion-becario.png')}}" class="img-responsive">
						</div>
						<div class="col-lg-4"></div>
					@else
						<div class="col-lg-4"></div>
						<div class="col-lg-4">
							<img src="{{asset('images/postulacion-mentor.png')}}" class="img-responsive">
						</div>
						<div class="col-lg-4"></div>
					@endif
				@else
					@if(Auth::user()->esEditor())
						<p class="text-center" style="color:#1b1b1b"> Bienvenido al Panel de Administración Web </p>
						<div class="col-lg-4"></div>
						<div class="col-lg-4">
							<img src="{{asset('info_sitio/logo3.png')}}" class="img-responsive">
						</div>
						<div class="col-lg-4"></div>
					@else
						<p class="text-center" style="color:#1b1b1b"> Bienvenido al Sistema de Becarios AVAA </p>
						<div class="col-lg-4"></div>
						<div class="col-lg-4">
							<img src="{{asset('images/becarios.jpg')}}" class="img-responsive">
						</div>
						<div class="col-lg-4"></div>
					@endif
				@endif
			</div>
		</div>
	</div>
	<br>
	@if(Auth::user()->esBecario() or Auth::user()->esDirectivo() or Auth::user()->esCoordinador() )
	<div class="container" style="border:1px solid #dedede;padding: 10px;border-radius: 10px;">
		<div class="row">
			<div class='col-sm-12'>
				<h3 class="text-center">
					Próximas Actividades
				</h3>
			</div>
		</div>
	</div>
	<br>
	<div class="container">
		<div class="row">
			@if($actividades->count()!=0)
				@foreach($actividades as $actividad)
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="border: 1px solid #eee;padding-top: 10px;padding-bottom: 5px" >
					<div data-mh="actividad">
						<h4>{{$actividad->getDia()}} {{$actividad->getMes()}} {{$actividad->getAnho()}}</h4>
						<h5 style="color:#424242">{{$actividad->getHoraInicio()}} a {{$actividad->getHoraFin()}}</h5>
						<div>
							@if($actividad->modalidad=='virtual')
					            <i class="fa fa-laptop"></i>
					        @else
					            <i class='fa fa-male'></i>
					        @endif
					        {{$actividad->getModalidad()}}
						</div>
						{{ucwords($actividad->tipo)}}: {{$actividad->nombre}} 
						@if($actividad->status=='disponible')
						<span class="label label-success">
							Disponible</span>
						@elseif($actividad->status=='suspendido')
						<span class="label label-danger">
							Suspendido</span>
						@elseif($actividad->status=='oculto')
						<span class="label label-warning">
							Oculto</span>
						@elseif($actividad->status=='cerrado')
						<span class="label label-danger">
							Cerrado</span>
						@endif
					</div>
			        <a href="{{route('actividad.detalles',$actividad->id)}}" class="btn btn-xs btn-block sisbeca-btn-primary">
			        	<i class="fa fa-info"> </i> Detalles
			    	</a>
			        @if(Auth::user()->esDirectivo() or Auth::user()->esCoordinador() or Auth::user()->esEntrevistador())
			         <a href="{{route('actividad.editar',$actividad->id)}}" class="btn btn-xs btn-block sisbeca-btn-primary">
			         	<i class="fa fa-pencil"> </i> Editar
			         </a>
			        @endif
				</div>
				@endforeach
			@else
				<div class="col-lg-12" style="border: 1px solid #dedede;border-radius: 10px;padding-top: 10px;">
					<p class="h6 text-center"><strong>No hay actividades próximas</strong></p>
				</div>
			@endif
		</div>
	</div>
	<br>
	<div class="container">
		<div class="row">
			<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 reporte-contenedor">
				<div class="col-lg-12 reporte-caja">
					<div data-mh="reporte-contenido" class="repote-contenido">
						<p class="h1 text-center">{{$cva_pendiente}}</p>
					</div>
					<hr class="reporte-linea">
					<div class="caja-subtitulo" data-mh="reporte-titulo">
						<p class="h6 text-center reporte-subtitulo">
						<strong>CVA pendiente</strong>
						</p>
					</div>
				</div>
			</div>
			<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 reporte-contenedor">
				<div class="col-lg-12 reporte-caja">
					<div data-mh="reporte-contenido" class="repote-contenido">
						<p class="h1 text-center">{{$voluntariados_pendiente}}</p>
					</div>
					<hr class="reporte-linea">
					<div class="caja-subtitulo" data-mh="reporte-titulo">
						<p class="h6 text-center reporte-subtitulo">
						<strong>Volutariados pendientes</strong>
						</p>
					</div>
				</div>
			</div>
			<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 reporte-contenedor">
				<div class="col-lg-12 reporte-caja">
					<div data-mh="reporte-contenido" class="repote-contenido">
						<p class="h1 text-center">{{$periodos_pendiente}}</p>
					</div>
					<hr class="reporte-linea">
					<div class="caja-subtitulo" data-mh="reporte-titulo">
						<p class="h6 text-center reporte-subtitulo">
						<strong>Notas Académicas pendientes</strong>
						</p>
					</div>
				</div>
			</div>
			<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 reporte-contenedor">
				<div class="col-lg-12 reporte-caja">
					<div data-mh="reporte-contenido" class="repote-contenido">
						<p class="h1 text-center">{{$justificativos_pendiente }}</p>
					</div>
					<hr class="reporte-linea">
					<div class="caja-subtitulo" data-mh="reporte-titulo">
						<p class="h6 text-center reporte-subtitulo">
						<strong>Justificativos pendientess</strong>
						</p>
					</div>
				</div>
			</div>
			<div class="col-lg-2 col-md-3 col-sm-4 col-xs-12 reporte-contenedor">
				<div class="col-lg-12 reporte-caja">
					<div data-mh="reporte-contenido" class="repote-contenido">
						<p class="h1 text-center">{{$solicitudes_pendiente }}</p>
					</div>
					<hr class="reporte-linea">
					<div class="caja-subtitulo" data-mh="reporte-titulo">
						<p class="h6 text-center reporte-subtitulo">
						<strong>Solicitudes pendientess</strong>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endif

@endsection
@endif

@section('personalcss')
<style>
    .repote-contenido
    {
    	padding-top:15px; 
    	height: 55px;
    }
	.reporte-contenedor
	{
		margin-bottom: 10px;
		padding-right: 5px!important;
		padding-left: 5px!important;
	}
	.reporte-linea
	{
		display: block;
	    height: 1px;
	    border: 0;
	    border-top: 1px solid #dc3545 !important;
	    margin: 1em 0;
	    padding: 0; 
	}
	.reporte-caja
	{
		border:1px solid #003865;
		border-radius: 5px;
		background-color: #fff;
		color:#212121 !important;

	}
	
	.reporte-subtitulo,.h5
	{
		color:#212121 !important;
	}
	
	.caja-subtitulo
	{
		padding-bottom: 5px;
	}
</style>
@endsection
