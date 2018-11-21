@extends('sisbeca.layouts.main')
@section('title','Seleccione los Postulante que seran elegidos como Becario')
@section('subtitle',' Elegir Becario')
@section('content')

<div class="col-12" id="app">
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
                                    <strong> Aprobado</strong>
                                </span>
                    </template>
                    <template v-else-if="postulante.status=='entrevistado'">
                        <span class="label label-inverse">
                            <strong> Pendiente</strong>
                        </span>
                    </template>
                    <template v-else-if="postulante.status=='rechazado'">
                        <span class="label label-warning">
                            <strong> Rechazado</strong>
                        </span>
                    </template>
                </td>
                    <td class="text-center"> @{{postulante.user.name}} @{{postulante.user.last_name}} @{{postulante.user_id}}</td>
                    <td class="text-center">@{{postulante.user.cedula}}</td>
                    <td class="text-center">
                        <template v-if="postulante.entrevistadores.length!=0">
                            <template v-for="entrevistador in postulante.entrevistadores">
                                    <span class="label label-default">@{{ entrevistador.name}} @{{ entrevistador.last_name}}</span>&nbsp;
                            </template>
                             
                        </template>
                        <template v-else>
                                    <span class="label label-inverse">Sin Entrevistadores</span>&nbsp;
                        </template>
                    </td>
                    <td class="text-center">
                        <template v-if="postulante.fecha_entrevista">
                            <span class="label label-success">
                                <strong> @{{postulante.fecha_entrevista}}</strong>
                            </span>
                        </template>
                        <template v-else>
                            <span class="label label-inverse">
                                <strong> Sin fecha</strong>
                            </span>
                        </template>
                    </td>
                    <td>
                       <button class="btn btn-xs sisbeca-btn-primary">
                           <i class="fa fa-eye"></i>
                        </button>
                       
                        <button class="btn btn-xs sisbeca-btn-success" @click.prevent="mostrarModal(postulante,postulante.imagenes,1)">
                            <i class="fa fa-gavel" data-target="modal-asignar"></i>
                         </button>
                         <button class="btn btn-xs sisbeca-btn-default" @click.prevent="mostrarModal(postulante,postulante.imagenes,0)">
                            <i class="fa fa-gavel" data-target="modal-asignar"></i>
                         </button>
                    </td>
                </tr>
                <tr v-if="postulantes.length==0">
                    <td colspan="5" class="text-center">  
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
                console.log('FUNCION:');
                console.log(this.funcion);
                var url = '{{route('veredicto.postulantes.becarios',':id')}}';
                //var url = route('veredictoPostulantesBecarios','['id' => $id, 'funcion' => $funcion]);
                url = url.replace(':id', id);
                
                axios.post(url).then(response => 
                {
                    
                    $('#modal-asignar').modal('hide');
                    this.obtenerpostulantes();
                    toastr.success(response.data.success);
                });
           
               /* axios.get(url).then(response => 
                {
                    this.postulantes = response.data.postulantes;
                });*/
            },

            mostrarModal:function(postulante,imagenes,funcion)
		    {
                console.log('Hola aqui empiezo:');
              
                console.log(imagenes);
               
                if(funcion=='1'){
                    this.funcion='Aprobar';
                }else if(funcion=='0'){
                    this.funcion='Rechazar';
                }
                this.id = postulante.user_id;
                this.nombreyapellido = postulante.user.name+' '+postulante.user.last_name;
                for (var i = 0; i < imagenes.length; i++)
                {
                    console.log('AQUI:');
                    console.log(imagenes[i].titulo);
                    if(imagenes[i].titulo=='img_perfil'){
                        this.imagen_postulante=imagenes[i].titulo;
                        console.log(this.imagen_postulante);
                    }
                }
                    $('#modal-asignar').modal('show');
		    }
        }
    });
</script>
  
 @endsection



