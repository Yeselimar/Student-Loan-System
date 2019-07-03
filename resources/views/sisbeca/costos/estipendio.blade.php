@extends('sisbeca.layouts.main')
@section('title','Estipendio')
@section('content')

<div class="col-lg-12" id="app">
<div class="alert  alert-info alert-important" role="alert">
    Nota: El estipendio se define una sola vez por mes y este puede ser editado siempre y cuando no haya sido utilizado en una nómina.
</div>
        <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 offset-lg-4 offset-md-2 offset-sm-0 offset-xs-0">
            <div class="info-box costos-border">
                <span class="info-box-icon costos-icon">
                    <img src="{{asset('images/bs_white.png')}}" style="height: 50px !important;">
                </span>
                <div class="info-cost-box-text">
                    <b><span class="info-cost-box-text">Estipendio Actual:  @{{mesdefinido}}/@{{aniodefinido}}</span></b>
                    <span class="info-cost-box-number">
                        <template v-if="estipendioVue">
                            <div v-if="actualizar">
                            <br/>
                                <input type="text" onkeypress="handleNumber(event, '{20,2}')" placeholder="Ingrese Estipendio" size=23 v-model="estipendioVue" name="estipendio" id="estipendio" class="sisbeca-input mt-2" required>
                            </div>
                            <span v-else>
                                <span v-if="isUpdate">@{{valueE}}</span>
                                <span v-else>  @{{estipendioVue}}</span>
                            </span>
                        </template>
                        <template v-else>
                            <div v-if="actualizar">
                            <br/>
                                <input type="text" onkeypress="handleNumber(event, '{20,2}')" placeholder="Ingrese Estipendio" size=23 v-model="estipendioVue" name="estipendio" id="estipendio" class="sisbeca-input mt-2" required>
                            </div>
                            <span v-else>
                                <span v-if="isUpdate">@{{valueE}}</span>
                                <span v-else>{{number_format(0, 2, ',', '.')}}</span>
                            </span>
                        </template>
                        <div v-show="actualizar">
                            <div class="col-lg-12 text-right" >
                                <form v-if="showDate"  @submit.prevent.stop="saveEstipendio">
                                        <div class="input-group input-append date mb-3" data-date-format="mm/yyyy" id="dp3">
                                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                <input class="form-control" autocomplete="off" required placeholder="Seleccionar fecha" size="16" type="text" id="fecha" >
                                        </div>
                                        <input class="btn sisbeca-btn-primary" type="submit" value="Guardar">
                                </form>
                            </div>
                        </div>
                    </span>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button @click="actualizarEstipendio" class="btn btn-sm sisbeca-btn-primary"><span v-if="!actualizar">Actualizar Estipendio</span> <span v-else> Cancelar</span></button>
        </div>
        <hr>
    <div class="col-lg-4 col-md-6 col-sm-6 col-xs-12 offset-lg-4 offset-md-2 offset-sm-0 offset-xs-0">
            <h3>Histórico de Estipendios:</h3>
        <table  class="table striped stacked" >
            <thead>
                <tr>
                    <th class="text-center">Fecha</th>
                    <th class="text-center">Estipendio</th>
                    <th class="text-center"></th>

                </tr>
            </thead>
            <tbody>
                    <template v-for="historico in historial">
                <tr>
                    <td class="text-center"> @{{historico.mes}} / @{{historico.anio}}</td>
                    <td class="text-center">@{{historico.estipendio}}

                    </td>
                    <td class="text-center">
                    <a v-if="!historico.usado_en_nomina" class="btn btn-xs sisbeca-btn-primary" @click="modalActualizarEstipendioIndividual(historico)">
                            <i class="fa fa-pencil"></i>
                    </a>
                    <a v-else class="btn btn-xs sisbeca-btn-primary disabled">
                            <i class="fa fa-pencil"></i>
                    </a>
                    </td>
                </tr>
                </template>
        </table>
    </div>

    <form method="POST" @submit.prevent="saveEstipendioIndividual()">
            {{ csrf_field() }}
            <div class="modal fade" id="modal-estipendio">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title"><strong>Editar Estipendio</strong></h5>
                            <a class="pull-right mr-1" href="javascript(0)" data-dismiss="modal" ><i class="fa fa-remove"></i></a>
                        </div>
                        <div class="modal-body">
                                    <div class="col" style="padding-left: 0px;padding-right: 0px;">
                                        <label class="control-label " for="retroactivo">Estipendio</label>
                                        <input type="number" name="estipendio"  class="sisbeca-input input-sm" id="estipendioIndividual"  style="margin-bottom: 0px">
                                    </div>
                            <div class="modal-footer" style="border">
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

        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
            $("#dp3").datepicker( {
            format: "mm/yyyy",
            viewMode: "months",
            minViewMode: "months"
            });
        });
</script>
<script>
    {{--var estipendio = {{$costo->estipendio}}--}}

    function handleNumber(event, mask) {
        /* numeric mask with pre, post, minus sign, dots and comma as decimal separator
            {}: positive integer
            {10}: positive integer max 10 digit
            {,3}: positive float max 3 decimal
            {10,3}: positive float max 7 digit and 3 decimal
            {null,null}: positive integer
            {10,null}: positive integer max 10 digit
            {null,3}: positive float max 3 decimal
            {-}: positive or negative integer
            {-10}: positive or negative integer max 10 digit
            {-,3}: positive or negative float max 3 decimal
            {-10,3}: positive or negative float max 7 digit and 3 decimal
        */
        with (event) {
            stopPropagation()
            preventDefault()
            if (!charCode) return
            var c = String.fromCharCode(charCode)
            if (c.match(/[^-\d,]/)) return
            with (target) {
                var txt = value.substring(0, selectionStart) + c + value.substr(selectionEnd)
                var pos = selectionStart + 1
            }
        }
        var dot = count(txt, /\./, pos)
        txt = txt.replace(/[^-\d,]/g, '')

        var mask = mask.match(/^(\D*)\{(-)?(\d*|null)?(?:,(\d+|null))?\}(\D*)$/); if (!mask) return // meglio exception?
        var sign = !!mask[2], decimals = +mask[4], integers = Math.max(0, +mask[3] - (decimals || 0))
        if (!txt.match('^' + (!sign ? '' : '-?') + '\\d*' + (!decimals ? '' : '(,\\d*)?') + '$')) return

        txt = txt.split(',')
        if (integers && txt[0] && count(txt[0], /\d/) > integers) return
        if (decimals && txt[1] && txt[1].length > decimals) return
        txt[0] = txt[0].replace(/\B(?=(\d{3})+(?!\d))/g, '.')

        with (event.target) {
            value = mask[1] + txt.join(',') + mask[5]
            selectionStart = selectionEnd = pos + (pos == 1 ? mask[1].length : count(value, /\./, pos) - dot)
        }

        function count(str, c, e) {
            e = e || str.length
            for (var n = 0, i = 0; i < e; i += 1) if (str.charAt(i).match(c)) n += 1
            return n
        }
    }
    const app = new Vue({

        el: '#app',
        data:
        {
             estipendioVue:0,
            actualizar: false,
            isUpdate: false,
            valueE: 0,
            fecha:'',
            fechaNueva:'',
            historial: [],
            actualizarItem: false,
            id:0,
            idItem:0,
            es_editable: 0,
            showDate: false,
            mes: 0,
            year: 0,
            aniodefinido: 0,
            mesdefinido: 0

        },
        mounted(){
            this.showDate = true
            this.getEstipendios()
        },

        methods:
        {
            getEstipendios(){
                this.fecha = new Date(); //hoy
                if(this.fecha)
                {

                    let url,mes,year
                            mes =this.fecha.getMonth()+1
                            year = this.fecha.getFullYear()
                            console.log('Mes:', mes)
                            console.log('Anio:', year)
                        url = "{{route('estipendioBecario',array('mes'=>':a_mes','year'=>':b_year'))}}"
                        url = url.replace(':a_mes',parseInt(mes))
                        url = url.replace(':b_year',parseInt(year))
                        axios.get(url).then(response =>
                        {
                            if(response.data.res==0){
                                this.estipendioVue= response.data.costo.estipendio
                                this.valueE= response.data.costo.estipendio
                                this.mesdefinido= response.data.costo.mes
                                this.aniodefinido= response.data.costo.anio
                                this.historial =response.data.historial
                                this.id= response.data.id
                                this.es_editable =response.data.costo.usado_en_nomina
                                toastr.error('No existe un estipendio definido para el Mes y Año en Curso');
                            }
                            else{
                                this.estipendioVue= response.data.costo.estipendio
                                this.valueE= response.data.costo.estipendio
                                this.mesdefinido= response.data.costo.mes
                                this.aniodefinido= response.data.costo.anio
                                this.historial =response.data.historial
                                this.id= response.data.id
                                this.es_editable =response.data.costo.usado_en_nomina
                                //console.log(this.estipendioVue)
                            }

                        }).catch( error => {
                            console.log(error);
                        });

                }
            },
            actualizarEstipendio(){
            this.actualizar = !this.actualizar

            },

            modalActualizarEstipendioIndividual(historico){
           // this.actualizarItem = !this.actualizarItem
            this.idItem = historico.id
               // console.log('ID:' , this.idItem);
                $('#modal-estipendio').modal('show');
            },
            saveEstipendioIndividual() {
                $(".preloader").show();
                let estipendio = document.getElementById('estipendioIndividual').value
                if(estipendio == ""){
                    estipendio = 0
                }
                console.log('estipendio',estipendio)
                var dataform = new FormData()
                var id
                id= this.idItem
                dataform.append('estipendio', estipendio)
                dataform.append('id', id)
               // id= this.idItem
                //console.log('ID==', id);
                var url = '{{route('estipendio.actualizar')}}'
                axios.post(url,dataform).then(response =>
                {

                    this.getEstipendios()
                    $(".preloader").hide()
                    $('#modal-estipendio').modal('hide');
                    toastr.success(response.data.success)
                });
            },
            saveEstipendio() {
                $(".preloader").show();
                this.fechaNueva=document.getElementById('fecha').value;

                if(this.fechaNueva)
                {
                    let f = this.fechaNueva.split('/')
                    let url,mes,year
                    if(f.length>1){
                    mes = f[0]
                    year = f[1]
                    this.mes = mes
                    this.year = year
                    }
                }
                let estipendio = document.getElementById('estipendio').value
                if(estipendio == ""){
                    estipendio = 0
                }
                var dataform = new FormData()
                var id
                id= this.id
                dataform.append('estipendio', estipendio)
                dataform.append('id', id)
                dataform.append('mes', this.mes)
                dataform.append('anio', this.year)
                var url = '{{route('estipendio.actualizar')}}'
                axios.post(url,dataform).then(response =>
                {
                    this.estipendioVue = response.data.costo
                    this.valueE = response.data.costoval
                    this.isUpdate = true
                    this.historial =response.data.historial
                    this.actualizarEstipendio()
                    this.getEstipendios()
                    $(".preloader").hide()
                    if(response.data.res==1){
                    toastr.success(response.data.success)
                    }
                    else{
                        toastr.warning(response.data.success)
                    }

                });
            }
        }
    });
</script>
@endsection
@section('personalcss')
<style scope="scss">
.datepicker table tr td span.active.active,	.month.focused.active{
    background-color: #003865 !important;
    background-image: -webkit-gradient(linear,0 0,0 100%,from(#003865),to(#003865)) !important
}
</style>
@endsection