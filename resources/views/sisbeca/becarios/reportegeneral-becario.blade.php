@extends('sisbeca.layouts.main')
@section('title','Reporte General: '.$becario->user->nombreyapellido())
@section('personalcss')
<style>
	.reporte-contenedor
	{
		margin-bottom: 10px;
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
@section('content')
<div class="col-lg-12" id="app">
	<div class="row" style="border:1px solid #fff">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<select class="form-control sisbeca-input" v-model="mes">
			  	<option disabled value="">Mes</option>
			  	<option value="00">Todos</option>
			  	<option value="01">Enero</option>
			  	<option value="02">Febrero</option>
			  	<option value="03">Marzo</option>
			  	<option value="04">Abril</option>
			  	<option value="05">Mayo</option>
			  	<option value="06">Junio</option>
			  	<option value="07">Julio</option>
			  	<option value="08">Agosto</option>
			  	<option value="09">Septiembre</option>
			  	<option value="10">Octubre</option>
			  	<option value="11">Noviembre</option>
			  	<option value="12">Diciembre</option>
			</select>
			<!--<span>Año: @{{ mes }}</span>-->
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<select class="form-control sisbeca-input" v-model="anho">
			  	<option disabled value="">Año</option>
			  	<option>2019</option>
			  	<option>2018</option>
			  	<option>2017</option>
			</select>
			<!--<span>Año: @{{ anho }}</span>-->
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
			<button @click="consultabecariosreportegeneral(anho,mes)" class="btn btn-md sisbeca-btn-primary btn-block" style="line-height: 1.70 !important">Consultar</button>
		</div>
	</div>
	<br>
	<div class="">
		<div class="row">
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 reporte-contenedor">
				<div class="col-lg-12 reporte-caja">
					<div data-mh="reporte-contenido">
						<p class="h1 text-center">@{{becario.horas_voluntariados}}</p>
					</div>
					<hr class="reporte-linea">
					<div class="caja-subtitulo" data-mh="reporte-titulo">
						<p class="h6 text-center reporte-subtitulo">
						<strong>Horas Voluntariados</strong>
						</p>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 reporte-contenedor">
				<div class="col-lg-12 reporte-caja">
					<div data-mh="reporte-contenido">
						<p class="h1 text-center">@{{becario.asistio_t}}</p>
					</div>
					<hr class="reporte-linea">
					<div class="caja-subtitulo" data-mh="reporte-titulo">
						<p class="h6 text-center reporte-subtitulo">
						<strong># Talleres</strong>
						</p>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 reporte-contenedor">
				<div class="col-lg-12 reporte-caja">
					<div data-mh="reporte-contenido">
						<p class="h1 text-center">@{{becario.asistio_cc}}</p>
					</div>
					<hr class="reporte-linea">
					<div class="caja-subtitulo" data-mh="reporte-titulo">
						<p class="h6 text-center reporte-subtitulo">
						<strong># Chat Club</strong>
						</p>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 reporte-contenedor">
				<div class="col-lg-12 reporte-caja">
					<div data-mh="reporte-contenido">
						<p class="h1 text-center">@{{becario.avg_cva}}</p>
					</div>
					<hr class="reporte-linea">
					<div class="caja-subtitulo" data-mh="reporte-titulo">
						<p class="h6 text-center reporte-subtitulo">
						<strong>AVG CVA</strong>
						</p>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 reporte-contenedor">
				<div class="col-lg-12 reporte-caja">
					<div data-mh="reporte-contenido">
						<p class="h1 text-center">@{{becario.avg_academico}}</p>
					</div>
					<hr class="reporte-linea">
					<div class="caja-subtitulo" data-mh="reporte-titulo">
						<p class="h6 text-center reporte-subtitulo">
						<strong>AVG Académico</strong>
						</p>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 reporte-contenedor">
				<div class="col-lg-12 reporte-caja">
					<div data-mh="reporte-contenido">
						<p class="h1 text-center">0</p>
					</div>
					<hr class="reporte-linea">
					<div class="caja-subtitulo" data-mh="reporte-titulo">
						<p class="h6 text-center reporte-subtitulo">
						<strong>AVG Desempeño</strong>
						</p>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 reporte-contenedor">
				<div class="col-lg-12 reporte-caja">
					<div data-mh="reporte-contenido" style="padding-top: 10px;">
						<p class="h5 text-center">@{{becario.nivel_cva}}</p>
					</div>
					<hr class="reporte-linea">
					<div class="caja-subtitulo" data-mh="reporte-titulo">
						<p class="h6 text-center reporte-subtitulo">
						<strong>Nivel CVA</strong>
						</p>
					</div>
				</div>
			</div>
			<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 reporte-contenedor">
				<div class="col-lg-12 reporte-caja">
					<div data-mh="reporte-contenido" style="padding-top: 10px;">
						<p class="h5 text-center">@{{becario.nivel_carrera}}</p>
					</div>
					<hr class="reporte-linea">
					<div class="caja-subtitulo" data-mh="reporte-titulo">
						<p class="h6 text-center reporte-subtitulo">
						<strong>Carrera</strong>
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Cargando.. -->
	<section class="loading" id="preloader">
		<div>
			<svg class="circular" viewBox="25 25 50 50">
				<circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
		</div>
	</section>
	<!-- Cargando.. -->
</div>
@endsection

@section('personaljs')
<script>
	const app = new Vue({

	el: '#app',
	data:
	{
		anho:'',
		mes:'',
		becario:[],
	},
	created: function()
	{
		this.obtenerbecariosreporte();
	},
	methods:
	{
		obtenerbecariosreporte()
		{
			var url = '{{route('seguimiento.becarioreportegeneral.api',array('id'=>':id','anho'=>':anho','mes'=>':mes'))}}';
			var id = '{{$becario->user->id}}';
			var anho = '{{date('Y')}}';
			var mes = '00';
			this.anho=anho;
			this.mes=mes;
			url = url.replace(':id', id);
			url = url.replace(':anho', anho);
			url = url.replace(':mes', mes);
			axios.get(url).then(response => 
			{
				this.becario = response.data.becario;
				$("#preloader").hide();
			}).catch( error => {
				console.log(error);
				$("#preloader").hide();
			});
		},
		consultabecariosreportegeneral(anho,mes)
		{
			var url = '{{route('seguimiento.becarioreportegeneral.api',array('id'=>':id','anho'=>':anho','mes'=>':mes'))}}';
			var id = '{{$becario->user->id}}';
			url = url.replace(':id', id);
			url = url.replace(':anho', anho);
			url = url.replace(':mes', mes);
			$("#preloader").show();
			axios.get(url).then(response => 
			{
				this.becario = response.data.becario;
				$("#preloader").hide();
			}).catch( error => {
				console.log(error);
				$("#preloader").hide();
			});
		}
	}
});
</script>
@endsection