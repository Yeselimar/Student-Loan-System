@extends('sisbeca.layouts.main')
@section('title','Seleccione los Postulante que seran elegidos como Becario')
@section('subtitle',' Elegir Becario')
@section('content')

<div class="col-12" id="app">
        <button class="btn btn-sm sisbeca-btn-primary pull-right" @click.prevent="mostrarModalBienvenida(postulantes)" data-target="modal-fecha-bienvenida" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Asignar Fecha de Bienvenida"> 
                
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
                    <th class="text-center">Fecha de Entrevista</th>
                    <th class="text-center">Acciones</th>
                    
                </tr>
            </thead>
            <tbody>
                               
                <tr v-for="postulante in postulantes">                           
                <td class="text-center"> 
                    <template v-if="postulante.status=='activo'">
                                <span class="label label-success">
                                     Aprobado
                                </span>
                    </template>
                    <template v-else-if="postulante.status=='entrevistado'">
                        <span class="label label-inverse">
                            Pendiente
                        </span>
                    </template>
                    <template v-else-if="postulante.status=='rechazado'">
                        <span class="label label-danger">
                            Rechazado
                        </span>
                    </template>
                </td>
                    <td class="text-center"> @{{postulante.user.name}} @{{postulante.user.last_name}} </td>
                    <td class="text-center">@{{postulante.user.cedula}}</td>
                    <td class="text-center">
                        <template v-if="postulante.entrevistadores.length!=0">
                            <template v-for="entrevistador in postulante.entrevistadores">
                                    <span class="label label-default">@{{ entrevistador.name}} @{{ entrevistador.last_name}}</span>
                                    <br>
                            </template>
                             
                        </template>
                        <template v-else>
                                    <span class="label label-inverse">Sin Entrevistadores</span>&nbsp;
                        </template>
                    </td>
                    <td class="text-center">
                        <template v-if="postulante.fecha_entrevista">
                    
                           @{{fechaformartear(postulante.fecha_entrevista)}}
                        </template>
                        <template v-else>
                            <span class="label label-inverse">
                                Sin fecha
                            </span>
                        </template>
                    </td>
                    <td>                       
                        <button class="btn btn-xs sisbeca-btn-success" @click.prevent="mostrarModal(postulante,postulante.imagenes,1)">
                            <i class="fa fa-check" data-target="modal-asignar"></i>
                         </button>
                         <button class="btn btn-xs sisbeca-btn-default" @click.prevent="mostrarModal(postulante,postulante.imagenes,0)">
                            <i class="fa fa-times" data-target="modal-asignar"></i>
                         </button>
                         <button class="btn btn-xs sisbeca-btn-primary">
                          
                           <i class="fa fa-eye"></i>
                        </button>
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
                            <button class="close" data-dimiss="modal" type="button" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <h5 class="modal-title pull-left"><strong>¿Esta Seguro que desea @{{funcion}} a @{{nombreyapellido}}</strong></h5>
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
    <form method="POST" @submit.prevent="fechadebienvenida()">
        {{ csrf_field() }}
            <div class="modal fade" id="modal-fecha-bienvenida">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title pull-left"><strong>Fecha de Reunión de Bienvenida</strong></h5>
                            <button class="close" data-dimiss="modal" type="button" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                        <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 0px !important">
                                    <label class="control-label " style="margin-bottom: 0px !important">Fecha</label>
                                        <input type="text" name="fecha" class="sisbeca-input input-sm" placeholder="DD/MM/AAAA" id="fecha" v-model="fecha" @change="cambiofecha($event)">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 0px !important">
                                    <label class="control-label " for="lugar" style="margin-bottom: 0px !important">Lugar</label>
                                        <input type="text" name="lugar" v-model="lugar" class="sisbeca-input input-sm" placeholder="Los Ruices">
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6" style="margin-bottom: 0px !important">
                                <label class="control-label " style="margin-bottom: 0px !important">Hora</label>
                                <input type="text" name="hora" class="sisbeca-input input-sm" v-model="hora" placeholder="HH:MM AA" id="hora">
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
        </form>
</div>
 
@endsection

@section('personaljs')
<script>
    const app = new Vue({
    
        el: '#app',
        created: function()
        {
            this.obtenerpostulantes();
                      
        },
        data:
        {
            postulantes:[],
            imagenes:[],
            imagen_postulante:'',
            id:'0',
            funcion:'',
            nombreyapellido:'',
           
        },
        methods:{
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
                this.id = postulante.user_id;
                this.nombreyapellido = postulante.user.name+' '+postulante.user.last_name;
                for (var i = 0; i < imagenes.length; i++)
                {                    
                    if(imagenes[i].titulo=='img_perfil'){
                        this.imagen_postulante=imagenes[i].titulo;
                        console.log(this.imagen_postulante);
                    }
                }
                    $('#modal-asignar').modal('show');
		    },
            mostrarModalBienvenida:function(postulantes){
                this.postulantes=postulantes;
                $('#modal-fecha-bienvenida').modal('show');
            },
            fechadebienvenida: function(){
                var url = '{{route('veredicto.postulantes.becarios')}}';
                axios.post(url,{
                   id:this.id,
                    funcion:this.funcion
                    }).then(response=>{
                    $('#modal-fecha-bienvenida').modal('hide');
                    this.obtenerpostulantes();
                    toastr.success(response.data.success);
                });
            },
            zfill: function(number, width)
            {
                var numberOutput = Math.abs(number); /* Valor absoluto del número */
                var length = number.toString().length; /* Largo del número */ 
                var zero = "0"; /* String de cero */  
                
                if (width <= length) {
                    if (number < 0) {
                        return ("-" + numberOutput.toString()); 
                    } else {
                        return numberOutput.toString(); 
                    }
                } else {
                    if (number < 0) {
                        return ("-" + (zero.repeat(width - length)) + numberOutput.toString()); 
                    } else {
                        return ((zero.repeat(width - length)) + numberOutput.toString()); 
                    }
                }
            },
            fechaformartear: function (fecha)
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



