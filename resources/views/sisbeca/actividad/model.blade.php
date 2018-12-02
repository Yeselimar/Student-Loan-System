@extends('sisbeca.layouts.main')
@section('title',$model=='crear' ? 'Crear Taller o Chat Club' : 'Editar '.$actividad->tipo.': '.$actividad->nombre)
@section('content')
<div class="col-lg-12" id="app">
    <div class="text-right">
        @if($model=="editar")
            <a href="{{route('actividad.detalles',$actividad->id)}}" class="btn btn-sm sisbeca-btn-primary">Atrás</a>
        @else
             <a href="{{route('actividad.listar')}}" class="btn btn-sm sisbeca-btn-primary">Atrás</a>
        @endif
    </div>
	<br>
	<div class="col sisbeca-container-formulario">

        @if($model=="crear")
		    <form method="POST" @submit.prevent="guardaractividad()" class="form-horizontal">
            {{ csrf_field() }}
        @else
             <form method="POST" @submit.prevent="actualizaractividad()" class="form-horizontal">
            {{ csrf_field() }}
        @endif
		
		<div class="form-group">
			<div class="row">
                
                <template v-for="(input, index) in inputs">
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <label class="control-label">*Tipo Facilitador @{{index+1}}</label>
                        <select v-model="input.becario" class="sisbeca-input" name="">
                            <option value="no">No es Becario</option>
                            <option value="si">Si es Becario</option>
                        </select>   
                        <!-- @{{ input.becario }} -->
                    </div>
                    <div class="col-lg-8 col-md-8 col-sm-6">
                        <div v-if="input.becario==='no'">
                            <label class="control-label">*Nombre y Apellido @{{index+1}}</label>
                        </div>
                        <div v-if="input.becario!='no'">
                            <label class="control-label">*Seleccione becario @{{index+1}}</label>
                        </div>
                        <div class="input-group">
                            <template v-if="input.becario==='no'">
                                <input type="text" v-model="input.nombre" class="sisbeca-input form-control" placeholder="John Doe">
                            </template>
                            <template v-if="input.becario!='no'">
                                <select v-model="input.id" class="custom-select sisbeca-select-especial sisbeca-input">
                                    <option v-for="becario in becarios" :value="becario.user.id">
                                        @{{ becario.user.name }} @{{ becario.user.last_name }}
                                    </option>
                                </select>
                                <!-- @{{ input.id}} -->
                            </template>
                            <!-- @{{ input.nombre }}-->
                            <div class="input-group-append">
                                <template v-if="inputs.length!=1">
                                    <button @click="eliminar(index)" class="btn sisbeca-btn-default-especial" type="button"><i class="fa fa-trash"></i></button>
                                </template>
                                <template v-else>
                                    <button @click="eliminar(index)" class="btn sisbeca-btn-default-especial" type="button" disabled="disabled"><i class="fa fa-trash"></i></button>
                                </template>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-if="inputs.length==0" >
                    <div class="col-lg-12" style="padding-top: 15px!important;">
                        <div class="alert alert-danger">El @{{actividad.tipo}} no tiene facilitador(es).</div>
                    </div><br>
                </template>
                <div class="col-lg-12">
                    <div class="text-right">
                        <button @click="anadir" type="button" class="btn sisbeca-btn-primary-especial">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <label class="control-label">*Nombre</label>
                    {{ Form::text('nombre', null, ['class' => 'sisbeca-input', 'placeholder'=>'EJ: The Last Game','v-model'=>'nombre'])}}
                    <span v-if="errores.nombre" :class="['label label-danger']">@{{ errores.nombre[0] }}</span>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <label class="control-label">*Tipo</label>
                    {{ Form::select('tipo', array('taller'=>'Taller','chat club'=>'Chat Club'),null,['class' =>'sisbeca-input','v-model'=>'tipo']) }}
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <label class="control-label">*Modalidad</label>
                    {{ Form::select('modalidad', array('presencial'=>'Presencial','virtual'=>'Virtual'),null,['class' =>'sisbeca-input','v-model'=>'modalidad']) }}
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <label class="control-label">*Nivel</label>
                    {{ Form::select('nivel', array('inicio'=>'Inicio','intermedio'=>'Intermedio','avanzado'=>'Avanzado','cualquier nivel'=>'Cualquier nivel'),null,['class' =>'sisbeca-input','v-model'=>'nivel']) }}
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <label class="control-label">Año académico</label>
                    {{ Form::text('anho_academico', null, ['class' => 'sisbeca-input', 'placeholder'=>'EJ: 3er Año','v-model'=>'anho_academico'])}}
                    <span v-if="errores.anho_academico" :class="['label label-danger']">@{{ errores.anho_academico[0] }}</span>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <label class="control-label">*Límite participantes</label>
                    {{ Form::text('limite_participantes', null, ['class' => 'sisbeca-input', 'placeholder'=>'EJ: 2','v-model'=>'limite_participantes'])}}
                    <span v-if="errores.limite" :class="['label label-danger']">@{{ errores.limite[0] }}</span>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <label class="control-label">*Horas voluntariados</label>
                    {{ Form::text('horas_voluntariados', null, ['class' => 'sisbeca-input', 'placeholder'=>'EJ: 2','v-model'=>'horas_voluntariados'])}}
                    <span v-if="errores.horas" :class="['label label-danger']">@{{ errores.horas[0] }}</span>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <label class="control-label">*Fecha</label>
                    {{ Form::text('fecha', ($model=='crear') ? null : date("d/m/Y", strtotime($actividad->fecha)) , ['class' => 'sisbeca-input', 'placeholder'=>'DD/MM/AAAA', 'id'=>"fecha",'v-model'=>'fecha'])}}
                    <span v-if="errores.fecha" :class="['label label-danger']">@{{ errores.fecha[0] }}</span>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <label class="control-label">*Hora inicio</label>
                    {{ Form::text('hora_inicio', ($model=='crear') ? null : null, ['class' => 'sisbeca-input', 'placeholder'=>'HH:MM AA', 'id'=>"hora_inicio",'v-model'=>'hora_inicio'])}}
                    <span v-if="errores.hora_inicio" :class="['label label-danger']">@{{ errores.hora_inicio[0] }}</span>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-6">
                    <label class="control-label">*Hora fin</label>
                    {{ Form::text('hora_fin', ($model=='crear') ? null : null, ['class' => 'sisbeca-input', 'placeholder'=>'HH:MM AA', 'id'=>"hora_fin",'v-model'=>'hora_fin'])}}
                    <span v-if="errores.hora_fin" :class="['label label-danger']">@{{ errores.hora_fin[0] }}</span>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <label class="control-label">Descripción</label>
                    {{ Form::text('descripcion', ($model=='crear') ? null : $actividad->descripcion , ['class' => 'sisbeca-input', 'placeholder'=>'Ingrese descripción','v-model'=>'descripcion'])}}
                    <span v-if="errores.descripcion" :class="['label label-danger']">@{{ errores.descripcion[0] }}</span>
                </div>
                
                
                
			</div>
		</div>

		<hr>	

		<div class="form-group">
			<div class="row">
				<div class="col-lg-12 text-right" >
                    @if($model=="editar")
					   <a href="{{route('actividad.detalles',$actividad->id)}}" class="btn sisbeca-btn-default">Cancelar</a>
					@else
                        <a href="{{route('actividad.listar')}}" class="btn sisbeca-btn-default">Cancelar</a>
                    @endif

                    <input class="btn sisbeca-btn-primary" type="submit" value="Guardar">
				</div>
			</div>
		</div>		

		{{ Form::close() }}
	</div>
</div>
@endsection

@section('personaljs')

<script>
const app = new Vue({

    el: '#app',
    data:
    {
        model:'',
        actividad:[],
        id_actividad:'',
        nombre:'',
        tipo:'taller',
        modalidad:'presencial',
        nivel:'inicio',
        anho_academico:'',
        limite_participantes:'',
        horas_voluntariados:'',
        fecha:'',
        hora_inicio:'',
        hora_fin:'',
        descripcion:'',
        becarios:[],
        inputs: [{
            "becario": 'no',
            "nombre": '',
            "id": ''}
        ],
        errores:[],
    },
    created: function()
    {
        this.obtenerbecarios();
    },
    mounted()
    {
        $('#fecha').datepicker({
            format: 'dd/mm/yyyy',
            language: 'es',
            orientation: 'bottom',
            autoclose: true
        }).on(
            'changeDate', () => { this.fecha = $('#fecha').val();
        });

        $('#hora_inicio').datetimepicker({
            format: 'hh:mm A',
        }).on('dp.change', function(e) {
            this.hora_inicio = $('#hora_inicio').val();
        });

        $('#hora_fin').datetimepicker({
            format: 'hh:mm A',
        }).on('dp.change', function(e) {
            this.hora_fin = $('#hora_fin').val();
        });
    },
    methods: 
    {
        obtenerbecarios: function()
        {
            this.model = '{{$model}}';
            if(this.model==='editar')
            {
                var id = '{{ (empty($actividad->id)) ? 'null': $actividad->id}}';
                var url = '{{route('actividad.obtener',':id')}}';
                url = url.replace(':id', id);
                axios.get(url).then(response => 
                {
                    this.actividad = response.data.actividad;
                    this.inputs = [];
                    var esbecario = '';
                    var id_becario;
                    var nombre;
                    for (var i = 0; i < this.actividad.facilitadores.length; i++)
                    {
                        if(this.actividad.facilitadores[i].becario_id!=null)
                        {
                            esbecario = "si";
                            id_becario = this.actividad.facilitadores[i].becario_id;
                            nombre = '';
                        }
                        else
                        {
                            esbecario = "no";
                            id_becario = '';
                            nombre = this.actividad.facilitadores[i].nombreyapellido;
                        }
                        this.inputs.push({
                            "becario": esbecario,
                            "nombre": nombre,
                            "id": id_becario,
                        });
                    }
                    this.nombre = this.actividad.nombre;
                    this.tipo = this.actividad.tipo;
                    this.modalidad =  this.actividad.modalidad;
                    this.nivel = this.actividad.nivel;
                    this.anho_academico = this.actividad.anho_academico;
                    this.limite_participantes = this.actividad.limite_participantes;
                    this.horas_voluntariados = this.actividad.horas_voluntariado;
                    this.descripcion = this.actividad.descripcion;
                    var dia = new Date (this.actividad.fecha);
                    this.fecha = moment(dia).format('DD/MM/YYYY');
                    $('#fecha').datepicker('setDate', new Date (this.actividad.fecha));
                    $('#fecha').datepicker('update');
                    var dia = new Date ("2018-11-11 "+this.actividad.hora_inicio);
                    this.hora_inicio = moment(dia).format('hh:mm A');
                    var dia = new Date ("2018-11-11 "+this.actividad.hora_fin);
                    this.hora_fin = moment(dia).format('hh:mm A');
                   
                });
            }
            var url = '{{route('actividad.obtenerbecarios')}}';
            axios.get(url).then(response => 
            {
                this.becarios = response.data.becarios;
            });
        },
        anadir() 
        {
            if(this.inputs.length<3)
            {
                this.inputs.push({
                    "becario": 'no',
                    "nombre": '',
                    "id": ''
                })
            }
            
        },
        eliminar(index)
        {
            this.inputs.splice(index,1)
        },
        guardaractividad()
        {
            //------------------Guardar actividad
            this.hora_inicio = $('#hora_inicio').val();
            this.hora_fin = $('#hora_fin').val();
            var url = '{{route('actividad.guardar')}}';
            let data = JSON.stringify({
                facilitadores: this.inputs,
                nombre: this.nombre,
                tipo: this.tipo,
                modalidad:this.modalidad,
                nivel:this.nivel,
                anho_academico:this.anho_academico,
                limite:this.limite_participantes,
                horas:this.horas_voluntariados,
                fecha:this.fecha,
                hora_inicio:this.hora_inicio,
                hora_fin:this.hora_fin,
                descripcion:this.descripcion
            });
            axios.post(url,data,{
            headers:
            {
                'Content-Type': 'application/json',
            } 
            }).then(response => 
            {
                this.errores=[];this.nombre='';this.tipo='taller'; this.modalidad='presencial';
                this.nivel='inicio';this.anho_academico='';this.limite_participantes='';
                this.horas_voluntariados='';this.fecha='';this.hora_inicio='';this.hora_fin='';
                this.descripcion='';this.inputs=[];
                this.inputs.push({
                    "becario": 'no',
                    "nombre": '',
                    "id": ''
                });
                toastr.success(response.data.success);
            }).catch( error =>
            {
                toastr.error("Disculpe, verifique el formulario");
                this.errores = error.response.data.errors;
            });
            //------------------Guardar actividad
        },
        actualizaractividad: function()
        {
            //------------------Actualizar actividad
            var id = '{{ (empty($actividad->id)) ? 'null': $actividad->id}}';
            var url = "{{ route('actividad.actualizar',':id' ) }}";
            url = url.replace(':id', id);
            this.hora_inicio = $('#hora_inicio').val();
            this.hora_fin = $('#hora_fin').val();
            let data = JSON.stringify({
                facilitadores: this.inputs,
                nombre: this.nombre,
                tipo: this.tipo,
                modalidad:this.modalidad,
                nivel:this.nivel,
                anho_academico:this.anho_academico,
                limite:this.limite_participantes,
                horas:this.horas_voluntariados,
                fecha:this.fecha,
                hora_inicio:this.hora_inicio,
                hora_fin:this.hora_fin,
                descripcion:this.descripcion
            });
            this.errores=[];
            axios.post(url,data,{
            headers:
            {
                'Content-Type': 'application/json',
            } 
            }).then(response => 
            {
                this.errores=[];
                toastr.success(response.data.success);
                this.obtenerbecarios();
            }).catch( error =>
            {
                toastr.error("Disculpe, verifique el formulario");
                this.errores = error.response.data.errors;
            });
            //------------------Actualizar actividad
        }
    }
});    
</script>

<script>

    
	
</script>
@endsection
