@extends('sisbeca.layouts.main')
@section('title','Seleccione los Postulante que seran elegidos como Becario')
@section('content')

<div class="col-12" id="app">
    <button v-b-popover.hover="'Asignar Fecha de Bienvenida a Todos por Igual'" class="btn btn-sm sisbeca-btn-primary pull-right mb-3" @click.prevent="mostrarModalBienvenidaTodos()">
        <i class="fa fa-calendar"></i> Asignar Fecha de Bienvenida
    </button>
    <br>
    <div clas="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">Estatus</th>
                    <th class="text-center">Nombre y Apellido</th>
                    <th class="text-center">Cédula</th>
                    <th class="text-center">Entrevistadores</th>
                    <th class="text-center">Fecha Entrevista</th>
                    <th class="text-center">Reunión Bienvenida</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="postulante in postulantes">
                    <td class="text-center">
                        <template v-if="postulante.status=='activo'">
                            <span class="label label-success">Aprobado</span>
                        </template>
                        <template v-else-if="postulante.status=='entrevistado'">
                            <span class="label label-warning">Pendiente</span>
                        </template>
                        <template v-else-if="postulante.status=='rechazado'">
                            <span class="label label-danger">Rechazado</span>
                        </template>
                    </td>
                    <td class="text-center"> @{{postulante.user.name}} @{{postulante.user.last_name}} </td>
                    <td class="text-center">@{{postulante.user.cedula}}</td>
                    <td class="text-center">
                        <template v-if="postulante.entrevistadores.length!=0">
                            <div v-for="(entrevistador,index) in postulante.entrevistadores" :key="index">
                                @{{ entrevistador.name}} @{{ entrevistador.last_name}}<span v-show="index<postulante.entrevistadores.length-1">,</span>
                                <br>
                            </div>
                        </template>
                        <template v-else>
                            <span class="label label-default">Sin Entrevistadores</span>&nbsp;
                        </template>
                    </td>
                    <td class="text-center">
                        <template v-if="postulante.fecha_entrevista">
                            @{{fechaformatear(postulante.fecha_entrevista)}}
                        </template>
                        <template v-else>
                            <span class="label label-default">Sin fecha</span>
                        </template>
                    </td>
                    <td class="text-center">
                        <template v-if="postulante.fecha_bienvenida">
                            @{{fechaformatear(postulante.fecha_bienvenida)}}
                        </template>
                        <template v-else>
                            <button v-b-popover.hover="'Asignar Fecha de Bienvenida'" class="btn btn-xs sisbeca-btn-primary" @click.prevent="mostrarModalBienvenida(postulantes)" data-target="modal-fecha-bienvenida" >
                                <i class="fa fa-calendar"></i> Asignar Fecha
                            </button>
                        </template>
                    </td>
                    <td>
                    <template v-if="(postulante.status==='activo')||(postulante.status==='rechazado')">
                        <button class="btn btn-xs sisbeca-btn-success disabled">
                        <i class="fa fa-check" data-target="modal-asignar"></i>
                        </button>
                        <button class="btn btn-xs sisbeca-btn-default disabled">
                        <i class="fa fa-times" data-target="modal-asignar"></i>
                        </button>
                    </template>
                    <template v-else>
                        <button class="btn btn-xs sisbeca-btn-success" @click.prevent="mostrarModal(postulante,postulante.imagenes,1)">
                        <i class="fa fa-check" data-target="modal-asignar"></i>
                        </button>
                        <button class="btn btn-xs sisbeca-btn-default" @click.prevent="mostrarModal(postulante,postulante.imagenes,0)">
                        <i class="fa fa-times" data-target="modal-asignar"></i>
                        </button>
                    </template>
                    <template>
                        <a :href="getRutaVerPerfil(postulante.user.id)" class="btn btn-xs sisbeca-btn-primary"> <i class="fa fa-eye"></i></a>
                    </template>
                    </td>
                </tr>
                <tr v-if="postulantes.length==0">
                    <td colspan="6" class="text-center">
                        No hay <strong>postulantes a entrevistados</strong>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal para aprobar becario -->
    <form method="POST" @submit.prevent="veredictopostulantesbecarios(id)">
        {{ csrf_field() }}
        <div class="modal fade" id="modal-asignar">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title pull-left"><strong>Decisión de la Postulación</strong></h5>
                        <a class="pull-right mr-1" href="javascript(0)" data-dismiss="modal" >X</a>
                    </div>
                    <div class="modal-body text-center">
                        <br>
                    <template v-if="funcion==='Aprobar'">
                    <h5>¿Esta Seguro que desea <strong class="letras-verdes">@{{funcion}}</strong> a @{{nombreyapellido}} como Becario de ProExcelencia?</h5>
                    </template>
                    <template v-else>
                    <h5>¿Esta Seguro que desea <strong class="letras-rojas">@{{funcion}}</strong> a @{{nombreyapellido}} Becario de ProExcelencia?</h5>
                    </template>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm sisbeca-btn-default pull-right" data-dismiss="modal" >Cancelar</button>
                        <button type="submit" class="btn btn-sm sisbeca-btn-primary pull-right">Aceptar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <!-- Modal para fecha de Bienvenida -->
    <form method="POST" @submit.prevent="fechadebienvenida(id)">
        {{ csrf_field() }}
        <div class="modal fade" id="modal-fecha-bienvenida">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title pull-left"><strong>Datos de la Reunión de Bienvenida</strong></h5>
                        <a class="pull-right mr-1" href="javascript(0)" data-dismiss="modal" >X</a>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="alert  alert-warning alert-important" role="alert">
                                    Actualmente no hay Postulantes aprobados para entrevistas...
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 0px !important">
                                <label class="control-label " style="margin-bottom: 0px !important">Fecha</label>
                                <date-picker data-trigger="focus" class="sisbeca-input input-sm" name="fecha" v-model="fecha" placeholder="Seleccione la Fecha" :config="{ enableTime: false , dateFormat: 'd/m/Y'}"></date-picker>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 0px !important">
                                <label class="control-label " for="lugar" style="margin-bottom: 0px !important">Lugar</label>
                                    <input type="text" name="lugar" v-model="lugar" class="sisbeca-input input-sm" placeholder="Los Ruices">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 0px !important">
                            <label class="control-label " style="margin-bottom: 0px !important">Hora</label>
                            <date-picker class="sisbeca-input input-sm" v-model="hora" placeholder="HH:MM AA" placeholder="Seleccione la Hora" :config="{ enableTime: true, enableSeconds: false, noCalendar: true,  dateFormat: 'h:i K'}"></date-picker>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 0px">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm sisbeca-btn-default pull-right" data-dismiss="modal" >Cancelar</button>
                            <button type="submit" class="btn btn-sm sisbeca-btn-primary pull-right">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- Modal para fecha de Bienvenida Todos -->
    <form method="POST" @submit.prevent="fechadebienvenidaparatodos()">
        {{ csrf_field() }}
        <div class="modal fade" id="modal-fecha-bienvenida-todos">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title pull-left"><strong>Datos de la Reunión de Bienvenida</strong></h5>
                        <a class="pull-right mr-1" href="javascript(0)" data-dismiss="modal" >X</a>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="alert  alert-warning alert-important" role="alert">
                                    Estos cambios se aplicarán a todos los postulantes listados en la vista anterior
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 0px !important">
                                <label class="control-label " style="margin-bottom: 0px !important">Fecha</label>
                                <date-picker data-trigger="focus" class="sisbeca-input input-sm" name="fecha" v-model="fecha" placeholder="Seleccione la Fecha" :config="{ enableTime: false , dateFormat: 'd/m/Y'}"></date-picker>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 0px !important">
                                <label class="control-label " for="lugar" style="margin-bottom: 0px !important">Lugar</label>
                                    <input type="text" name="lugar" v-model="lugar" class="sisbeca-input input-sm" placeholder="Los Ruices">
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 0px !important">
                            <label class="control-label " style="margin-bottom: 0px !important">Hora</label>
                            <date-picker class="sisbeca-input input-sm" v-model="hora" placeholder="HH:MM AA" placeholder="Seleccione la Hora" :config="{ enableTime: true, enableSeconds: false, noCalendar: true,  dateFormat: 'h:i K'}"></date-picker>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 0px">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-sm sisbeca-btn-default pull-right" data-dismiss="modal" >Cancelar</button>
                            <button type="submit" class="btn btn-sm sisbeca-btn-primary pull-right">Guardar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('personaljs')
<script>
    const app = new Vue({
        components:{DatePicker},
        el: '#app',
        created: function()
        {
            this.obtenerpostulantes();

        },
        data:
        {
            postulante:'',
            imagenes:[],
            imagen_postulante:'',
            id:'0',
            funcion:'',
            nombreyapellido:'',
            fecha:'',
            hora:'',
            lugar:'',
            postulantes:[],
            contador:0,

        },
        methods:{
            getRutaVerPerfil: function(id)
            {
                //var url = "{{route('entrevistador.documentoconjunto',array('id'=>':id'))}}";
                var url ="{{route('perfilPostulanteBecario', array('id'=>':id'))}}"
                url = url.replace(':id', id);
                return url;
            },
            obtenerpostulantes:function()
            {
                var url = '{{route('postulantes.entrevistados')}}';
                axios.get(url).then(response =>
                {
                    this.postulantes = response.data.postulantes;
                });
            },
            veredictopostulantesbecarios:function(id)
            {
                var url = '{{route('veredicto.postulantes.becarios')}}';
                axios.post(url,{
                   id:this.id,
                    funcion:this.funcion
                    }).then(response=>{
                    $('#modal-asignar').modal('hide');
                    this.obtenerpostulantes();
                    toastr.success(response.data.success);
                });
            },
            mostrarModal:function(postulante,imagenes,funcion)
		    {
                if(funcion=='1'){
                    this.funcion='Aprobar';
                }else if(funcion=='0'){
                    this.funcion='Rechazar';
                }
              //  this.id = postulante.user_id;
                this.nombreyapellido = postulante.user.name+' '+postulante.user.last_name;
                for (var i = 0; i < imagenes.length; i++)
                {
                    if(imagenes[i].titulo=='img_perfil')
                    {
                        this.imagen_postulante=imagenes[i].titulo;
                    }
                }
                $('#modal-asignar').modal('show');
		    },
            mostrarModalBienvenida:function(postulante)
            {
                this.id = postulante.user_id;
               // console.log('ID:' , postulante.user_id);
                $('#modal-fecha-bienvenida').modal('show');
            },
            fechadebienvenida: function(id)
            {
                var url ='{{route('asignar.fecha.bienvenida')}}';
                axios.post(url,{
                   id:this.id,
                   fecha:this.fecha,
                   lugar:this.lugar,
                   hora:this.hora,
                }).then(response =>
                {
                    $('#modal-fecha-bienvenida').modal('hide');
                    this.obtenerpostulantes();
                    toastr.success(response.data.success);
                });
         /*       this.hora = $('#hora').val();
               this.id= id,
    			this.fecha = $('#fecha').val();
                var url = '{{route('asignar.fecha.bienvenida')}}';
                let data = JSON.stringify({
                    postulante: this.postulante,
                    lugar: this.lugar,
                    fecha: this.fecha,
                });
                axios.post(url,data,{
                    headers:
                    {
                        'Content-Type': 'application/json',
                    }
                }).then(response =>
                {
                    $('#modal-fecha-bienvenida').modal('hide');
                    this.obtenerpostulantes();
                    toastr.success(response.data.success);
                });*/
            },
            mostrarModalBienvenidaTodos:function(postulantes)
            {
                //this.id = postulante.user_id;
              //  this.postulantes=postulantes;
            // console.log('ID:' , postulante.user_id);
                $('#modal-fecha-bienvenida-todos').modal('show');
            },
            fechadebienvenidaparatodos: function()
            {
               /* this.hora = $('#hora').val();
                this.fecha = $('#fecha').val();*/
                var url = '{{route('asignar.fecha.bienvenida.todos')}}';
                let data = JSON.stringify({
                    //postulantes: this.postulantes,
                    lugar: this.lugar,
                    fecha: this.fecha,
                });
                axios.post(url,data,{
                    headers:
                    {
                        'Content-Type': 'application/json',
                    }
                }).then(response =>
                {
                    $('#modal-fecha-bienvenida-todos').modal('hide');
                    this.obtenerpostulantes();
                    toastr.success(response.data.success);
                });
            },
            zfill: function(number, width)
            {
                var numberOutput = Math.abs(number); /* Valor absoluto del número */
                var length = number.toString().length; /* Largo del número */
                var zero = "0"; /* String de cero */

                if (width <= length)
                {
                    if (number < 0)
                    {
                        return ("-" + numberOutput.toString());
                    }
                    else
                    {
                        return numberOutput.toString();
                    }
                }
                else
                {
                    if (number < 0)
                    {
                        return ("-" + (zero.repeat(width - length)) + numberOutput.toString());
                    }
                    else
                    {
                        return ((zero.repeat(width - length)) + numberOutput.toString());
                    }
                }
            },
            fechaformatear: function (fecha)
            {
                var d = new Date(fecha);
                var dia = d.getDate();
                var mes = d.getMonth() + 1;
                var anho = d.getFullYear();
                var fecha = this.zfill(dia,2) + "/" + this.zfill(mes,2) + "/" + anho;
                return fecha;
            },
        }
    });
</script>


 @endsection



