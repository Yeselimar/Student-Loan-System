@extends('sisbeca.layouts.main')
@section('title','Seleccione los Postulante que seran elegidos como Becario')
@section('subtitle',' Elegir Becario')
@section('content')

<div class="col-12" id="app">
    <div clas="table-responsive">
        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th class="text-center">Nombre y Apellido</th>
                    <th class="text-center">Cédula</th>
                    <th class="text-center">Entrevistadores</th>
                    <th class="text-center">Fecha de Entrevista</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>                        
                <tr v-for="postulante in postulantes">                           
                    <td class="text-center"> @{{postulante.user.name}} @{{postulante.user.last_name}}</td>
                    <td class="text-center">@{{postulante.user.cedula}}</td>
                    <td class="text-center">
                        <template v-if="postulante.entrevistadores.length!=0">
                            <template v-for="entrevistador in postulante.entrevistadores">
                                    <span class="label label-default">@{{ entrevistador.name}} @{{ entrevistador.last_name}}</span>&nbsp;
                            </template>
                             <template>
                                    <span>No hay Entrevistador</span>&nbsp;
                            </template>
                        </template>
                    </td>
                    <td class="text-center">
                        <span class="label label-success">
                            <strong> @{{postulante.fecha_entrevista}}</strong>
                        </span>
                    </td>
                    <td>
                        <a href="#" class="btn sisbeca-btn-primary">
                            <i class="fa fa-eye"></i>
                        </a>
                        <a href="#" class="btn sisbeca-btn-primary">
                            <i class="fa fa-trash"></i>
                        </a>
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
           
        },
        methods:{

            obtenerpostulantes:function(){
            var url = '{{route('postulantes.entrevistados')}}';
			axios.get(url).then(response => 
			{
				this.postulantes = response.data.postulantes;
			});

            }
        }
    });
</script>

 @endsection



