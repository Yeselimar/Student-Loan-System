@extends('sisbeca.layouts.main')
@section('title','Procesar Nómina')
@section('content')
<div class="col-lg-12" id="app">
    <strong>Procesar Nómina: {{ $mes.'/'.$anho }}</strong>
    <a href="{{route('nomina.procesar')}}" class="btn btn-sm sisbeca-btn-primary pull-right ">Atrás</a>
    

    <div class="table-responsive">

        <!-- data-order='[[ 5, "asc" ],[2,"desc"],[0,"asc"]]'-->
        <table id="nomina"  class="table table-bordered table-hover" >
            <thead>
                <tr>
                    <th class="text-center">Nombre y Apellido</th>
                    <th class="text-center">CVA</th>
                    <th class="text-right">Retroactivo</th>
                    <th class="text-right">Libros</th>
                    <th class="text-right">Sueldo</th>
                    <th class="text-right" style="background-color: #eee;">Total a Pagar</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="nomina in nominas">
                    <td> @{{nomina.user.name }} @{{nomina.user.last_name }}</td>
                    <td>
                        <span >
                        <button type="button" class=" btn btn-xs sisbeca-btn-primary" @click.prevent="mostrarModalCVAa(nomina.user.id)"> @{{nomina.cva }}
                        </button>
                        </span>
                    </td>
                    <td> @{{nomina.retroactivo }} </td>
                    <td> @{{nomina.monto_libros }} </td>
                    <td> @{{nomina.sueldo_base }} </td>
                    <td> 
                        @{{nomina.total }}
                     </td>
                    <td> 
                        
                        <a href="@{{ getRuta(nomina.user.id)}}" class="btn btn-xs sisbeca-btn-primary">Aprobar Facturas</a>
                        <span v-model="getRuta(nomina.user.id)"></span>
                    </td>

                </tr>
            </tbody>

        </table>
    </div>

    <br>
    <br>
    <a class="btn btn-md sisbeca-btn-primary pull-right"  style="margin-left: 5px;" href="{{ route('nomina.generar', array('mes'=>$mes, 'anho'=>$anho) ) }}" >Generar o Procesar</a>
   
   
</div>
@endsection
@section('personaljs')


<script>
    const app = new Vue({

    el: '#app',
    created: function()
    {
        this.getNomina();

    },
    data:
    {
        
        nominas:[],
    },
    methods:
    {
        getFacturasenNomina: function(id)
        {
            var url = '{{route('factlibros.contar',array('id'=>':id','mes'=>$mes, 'anho'=>$anho))}}';
            url = url.replace(':id', id);
            var total = -1;
            axios.get(url).then(response => 
            {
                total = response.data.total;
                console.log(total);
            });
            return total;
        },
        getRuta: function(id)
        {
            var url = '{{ route('factlibros.verfacturas',array('id'=>':id', 'mes'=>$mes, 'anho'=>$anho) ) }}';
            url = url.replace(':id', id);
            return url;
        },
        getNomina: function()
        {
            var url = '{{route('nomina.procesar.detalle.servicio',array('mes'=>$mes, 'anho'=>$anho))}}';
            console.log(url);
            axios.get(url).then(response => 
            {
                this.nominas = response.data.nominas;
            });
        }
    }
});
</script>
@endsection
