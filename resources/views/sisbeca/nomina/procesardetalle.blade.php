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
                    <td > @{{nomina.user.name }} @{{nomina.user.last_name }}</td>
                    <td > @{{nomina.cva }} </td>
                    <td > @{{nomina.retroactivo }} </td>
                    <td > @{{nomina.libros_cva }} </td>
                    <td > @{{nomina.id }} </td>

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
        getNomina: function()
        {
            var url = '{{route('nomina.procesar.detalle.servicio',array('mes'=>$mes, 'anho'=>$anho))}}';
            console.log(url);
            axios.get(url).then(response => 
            {
                this.nominas = response.data.nominas;
                console.log(this.nominas);
            });
        }
    }
});
</script>
@endsection
