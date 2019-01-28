@extends('sisbeca.layouts.main')
@section('title','Editar Becario: '.$becario->user->nombreyapellido())
@section('content')
<div class="col-lg-12" id="app">
	
	<ul class="nav nav-tabs" role="tablist">
	  	<li class="nav-item">
	    	<a class="nav-link active" href="#datos" role="tab" data-toggle="tab">Datos Personales</a>
	  	</li>
	  	<li class="nav-item">
	    	<a class="nav-link" href="#buzz" role="tab" data-toggle="tab">Estudios Secundarios</a>
	  	</li>
	  	<li class="nav-item">
	    	<a class="nav-link" href="#references" role="tab" data-toggle="tab">Estudios Universitarios</a>
	  	</li>
	  	<li class="nav-item">
	    	<a class="nav-link" href="#references" role="tab" data-toggle="tab">Información Adicional</a>
	  	</li>
	</ul>
	
	<div class="tab-content">
	  	<div class="tab-pane active containe" id="datos">

			<br>

			<div class="form-group" style="border: 1px solid #eee; padding: 10px; border-radius: 5px;">
				<div class="row" >
					<div class="col-lg-4 col-md-4 col-sm-6">
                        <label class="control-label">Nombres</label>
                       	<input type="text" name="name" class="sisbeca-input" :value="name">
                       	<span v-if="errores.name" :class="['label label-danger']">@{{ errores.name[0] }}</span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <label class="control-label">Apellidos</label>
                       	<input type="text" name="last_name" class="sisbeca-input" :value="last_name">
                       	<span v-if="errores.last_name" :class="['label label-danger']">@{{ errores.last_name[0] }}</span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <label class="control-label">Cédula</label>
                       	<input type="text" name="nombreyapellido" class="sisbeca-input" :value="cedula">
                       	<span v-if="errores.cedula" :class="['label label-danger']">@{{ errores.cedula[0] }}</span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <label class="control-label">Sexo</label>
                       	<input type="text" name="sexo" class="sisbeca-input" :value="sexo">
                       	<span v-if="errores.sexo" :class="['label label-danger']">@{{ errores.sexo[0] }}</span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <label class="control-label">Fecha Nacimiento</label>
	                    <date-picker class="sisbeca-input" name="fecha_nacimiento" v-model="fecha_nacimiento" placeholder="DD/MM/AAAA" :config="{ enableTime: false , dateFormat: 'd/m/Y'}"></date-picker>
	                    <span v-if="errores.fecha_nacimiento" :class="['label label-danger']">@{{ errores.fecha_nacimiento[0] }}</span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <label class="control-label">Correo Electrónico</label>
                       	<input type="text" name="email" class="sisbeca-input" :value="email">
                       	<span v-if="errores.email" :class="['label label-danger']">@{{ errores.email[0] }}</span>
                    </div>
				</div>
			</div>

			<div class="form-group ">
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
						  <input class="btn sisbeca-btn-primary pull-right" type="button" value="Guardar" @click="guardar()">
					</div>
				</div>
			</div>		
			
		</div>

	  	<div class="tab-pane container" id="buzz">
	  		
	  	</div>

	  	<div class="tab-pane container" id="references">
	  		
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
	components:{DatePicker},
    el: '#app',
    data:
    {
    	errores:[],
    	becario:'',
    	usuario:'',
    	name:'',
    	last_name:'',
    	cedula:'',
    	sexo:'',
    	fecha_nacimiento:'',
    	email:''
    },
    beforeCreate:function()
	{
		$("#preloader").show();
	},
    created: function()
    {
        this.obtenerdatosbecario();
    },
    methods: 
    {
    	obtenerdatosbecario()
    	{
    		var id = "{{$becario->user_id}}";
    		var url = '{{route('becarios.obtener.datos',':id')}}';
    		url = url.replace(':id', id);
            axios.get(url).then(response => 
            {
               	this.becario = response.data.becario;
               	this.usuario = response.data.usuario;
               	this.name = this.usuario.name;
               	this.last_name = this.usuario.last_name;
               	this.cedula = this.usuario.cedula;
               	this.sexo = this.usuario.sexo;
               	this.email = this.usuario.email;
               	var dia = new Date (this.usuario.fecha_nacimiento);
                this.fecha_nacimiento = moment(dia).format('DD/MM/YYYY');
                console.log(this.fecha_nacimiento);
               	//var dia = new Date (this.usuario.fecha_nacimiento);
               // this.fecha_nacimiento = moment(dia).format('DD/MM/YYYY');
            	$("#preloader").hide();
			}).catch( error => {
				console.log(error);
				$("#preloader").hide();
			});
    	},
    	guardar()
    	{
    		var id = '{{$becario->user_id}}';
            var url = "{{ route('becarios.actualizar.datos',':id' ) }}";
            url = url.replace(':id', id);
    		let data = JSON.stringify({
                name: this.name,
                last_name: this.last_name,
                cedula: this.cedula,
                sexo: this.sexo,
                fecha_nacimiento: this.fecha_nacimiento,
                email: this.email,

            });
            console.log(this.email);
            axios.post(url,data,{
            headers:
            {
                'Content-Type': 'application/json',
            } 
            }).then(response => 
            {
            	this.errores=[];
            	toastr.success(response.data.success);
            }).catch( error =>
            {
            	this.errores = error.response.data.errors;
                toastr.error("Disculpe, verifique el formulario");
                
            });
    	}

    }

	});
</script>
@endsection