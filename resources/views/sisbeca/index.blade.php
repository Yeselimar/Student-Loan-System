

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

	<!-- End PAge Content -->
@endsection
@endif

          