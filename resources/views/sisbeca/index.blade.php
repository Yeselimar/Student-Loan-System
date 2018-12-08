

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
	<div class="container" style="border:1px solid #dedede;padding: 10px;border-radius: 10px;">
		<h3 class="text-center">
			Próximas Actividades
		</h3>
	</div>
	<br>
	<div class="container">
		<div class="row">
			
			@if(Auth::user()->esBecario())
				@foreach($actividades as $actividad)

				
				<div class="col-lg-3 col-md-4 col-sm-6 col-xs-12" style="border: 1px solid #eee" >
					<h4>{{$actividad->getDia()}} {{$actividad->getMes()}} </h4> 
					<h5 style="color:#424242">{{$actividad->getHoraInicio()}} a {{$actividad->getHoraFin()}}</h5>
					{{ucwords($actividad->tipo)}}: {{$actividad->nombre}}
					<br>
					@if($actividad->modalidad=='virtual')
			            <i class="fa fa-laptop"></i>
			        @else
			            <i class='fa fa-male'></i>
			        @endif
			        {{$actividad->getModalidad()}}
			        <br>
			        <a href="{{route('actividad.detalles',$actividad->id)}}" class="btn btn-xs btn-block sisbeca-btn-primary">Detalles</a>
				</div>
				@endforeach
			@endif
		</div>
	</div>
@endsection
@endif

          