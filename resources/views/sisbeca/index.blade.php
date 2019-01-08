

@if(Auth::user()->rol==='becario'&& Auth::user()->becario->status==='activo' &&  Auth::user()->becario->acepto_terminos== 0 )
	@section('title','Inicio')
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
	@if(Auth::user()->esBecario() or Auth::user()->esDirectivo() or Auth::user()->esCoordinador() or Auth::user()->esEntrevistador())
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
				<div class="col" style="border: 1px solid #dedede;border-radius: 10px;padding-top: 10px;">
					<p class="h6 text-center"><strong>No hay actividades próximas</strong></p>
				</div>
			@endif
		</div>
	</div>
	@endif
@endsection
@endif

          