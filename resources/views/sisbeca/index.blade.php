

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


	<h3 class="subencabezado">!Hola, {{ Auth::user()->name}}!</h3>

	<div class="container">
		<div class="row">
			<div class='col-sm-12' align="center">
				@if((Auth::user()->rol==='postulante_becario')||(Auth::user()->rol==='postulante_mentor'))
					<p> Pasos a Seguir </p>
					@if(Auth::user()->rol==='postulante_becario')
						<img src="{{asset('images/postulacion-becario.png')}}">
					@else
						<img src="{{asset('images/postulacion-mentor.png')}}">
					@endif
					@else
					<p> Bienvenido al Sistema de Becarios AVAA </p>
					<img src="{{asset('images/becarios.jpg')}}">
				@endif
			</div>
		</div>
	</div>

	<!-- End PAge Content -->
@endsection
@endif

          