@extends('sisbeca.layouts.main')
@section('title','Todos los Voluntariados')
@section('content')
<div class="col-lg-12" id="app">

<!--  Table-->
<b-container fluid>
    <!-- User Interface controls -->
    <b-row>
      <b-col md="6" class="my-1">
        <b-form-group horizontal label="Filter" class="mb-0">
          <b-input-group>
            <b-form-input v-model="filter" placeholder="Type to Search" />
            <b-input-group-append>
              <b-btn :disabled="!filter" @click="filter = ''">Clear</b-btn>
            </b-input-group-append>
          </b-input-group>
        </b-form-group>
      </b-col>
      <b-col md="6" class="my-1">
        <b-form-group horizontal label="Sort" class="mb-0">
          <b-input-group>
            <b-form-select v-model="sortBy" :options="sortOptions">
              <option slot="first" :value="null">-- none --</option>
            </b-form-select>
            <b-form-select :disabled="!sortBy" v-model="sortDesc" slot="append">
              <option :value="false">Asc</option>
              <option :value="true">Desc</option>
            </b-form-select>
          </b-input-group>
        </b-form-group>
      </b-col>
      <b-col md="6" class="my-1">
        <b-form-group horizontal label="Sort direction" class="mb-0">
          <b-input-group>
            <b-form-select v-model="sortDirection" slot="append">
              <option value="asc">Asc</option>
              <option value="desc">Desc</option>
              <option value="last">Last</option>
            </b-form-select>
          </b-input-group>
        </b-form-group>
      </b-col>
      <b-col md="6" class="my-1">
        <b-form-group horizontal label="Per page" class="mb-0">
          <b-form-select :options="pageOptions" v-model="perPage" />
        </b-form-group>
      </b-col>
    </b-row>

    <!-- Main table element -->
    <b-table show-empty
             stacked="md"
             :items="items"
             :fields="fields"
             :current-page="currentPage"
             :per-page="perPage"
             :filter="filter"
             :sort-by.sync="sortBy"
             :sort-desc.sync="sortDesc"
             :sort-direction="sortDirection"
             @filtered="onFiltered"
    >
      <template slot="name" slot-scope="row">@{{row.value.first}} @{{row.value.last}}</template>
      <template slot="isActive" slot-scope="row">@{{row.value?'Yes :)':'No :('}}</template>
      <template slot="actions" slot-scope="row">
        <!-- We use @click.stop here to prevent a 'row-clicked' event from also happening -->
        <b-button size="sm" @click.stop="info(row.item, row.index, $event.target)" class="mr-1">
          Info modal
        </b-button>
        <b-button size="sm" @click.stop="row.toggleDetails">
          @{{ row.detailsShowing ? 'Hide' : 'Show' }} Details
        </b-button>
      </template>
      <template slot="row-details" slot-scope="row">
        <b-card>
          <ul>
            <li v-for="(value, key) in row.item" :key="key">@{{ key }}: @{{ value}}</li>
          </ul>
        </b-card>
      </template>
    </b-table>

    <b-row>
      <b-col md="6" class="my-1">
        <b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" />
      </b-col>
    </b-row>

    <!-- Info modal -->
    <b-modal id="modalInfo" @hide="resetModal" :title="modalInfo.title" ok-only>
      <pre>@{{ modalInfo.content }}</pre>
    </b-modal>

  </b-container>




<!-- end Table-->




	<div class="text-right">
		<a href="{{route('becarios.todos')}}" class="btn btn-sm sisbeca-btn-primary">Listar Becarios</a>
	</div>
	<br>
	<div class="table-responsive">
		<table class="table table-hover table-bordered" >
			<thead>
				<tr>
					<th>Becario</th>
					<th>Nombre Voluntariado</th>
					<th>Fecha</th>
					<th class="text-center">Horas</th>
					<th class="text-center">Estatus</th>
					<th>Actualizado el</th>
					<th class="text-right">Acciones</th>
				</tr>
			</thead>
			<tbody>
				<tr v-for="voluntariado in voluntariados">
					<td>
						<small>
							@{{ voluntariado.usuario.name }} @{{ voluntariado.usuario.last_name }}
						</small>
					</td>
					<td>
						<small>
							@{{ voluntariado.nombre }}
							(@{{ voluntariado.tipo}})
						</small>
					</td>
					<td>
						<small>@{{fechaformatear(voluntariado.fecha)}}</small>
					</td>
					<td class="text-center">
						<small>@{{ voluntariado.horas}}</small>
					</td>
					<td class="text-center">
						<small>
						<span v-if="voluntariado.aval.estatus=='pendiente'" class="label label-warning">pendiente</span>
						<span v-if="voluntariado.aval.estatus=='aceptada'" class="label label-success">aceptada</span>
						<span v-if="voluntariado.aval.estatus=='negada'" class="label label-danger">negada</span>
						<span v-if="voluntariado.aval.estatus=='devuelto'" class="label label-danger">devuelto</span>
						</small>
					</td>
					<td>
						<small>@{{ fechacompletaformatear(voluntariado.aval.updated_at) }}</small>
					</td>
					<td>
						<a :href="urlEditarVoluntariado(voluntariado.id)" class="btn btn-xs sisbeca-btn-primary" title="Editar Periodo">
							<i class="fa fa-pencil"></i>
						</a>
						<a :href="urlVerComprobante(voluntariado.aval.url)" class="btn btn-xs sisbeca-btn-primary" title="Ver Constancia" target="_blank">
							<template v-if="voluntariado.aval.extension=='imagen'">
								<i class="fa fa-photo"></i>
							</template>
							<template v-else>
								<i class="fa fa-file-pdf-o"></i>
							</template>
							
						</a>
						<template v-if="voluntariado.aval.estatus!='aceptada'">
							<button type="button" class="btn btn-xs sisbeca-btn-default" title="Eliminar CVA" @click="modalEliminar(voluntariado,voluntariado.usuario)">
								<i class="fa fa-trash"></i>
							</button>
						</template>
						<template v-else>
							<button type="button" class="btn btn-xs sisbeca-btn-default" disabled="disabled">
								<i class="fa fa-trash"></i>
							</button>
						</template>
						<select v-model="voluntariado.aval.estatus" @change="actualizarestatus(voluntariado.aval.estatus,voluntariado.aval.id)" class="sisbeca-input input-sm sisbeca-select">
							<option v-for="estatu in estatus" :value="estatu">@{{ estatu}}</option>
						</select>
					</td>
				</tr>
				<tr v-if="voluntariados.length==0">
					<td colspan="7" class="text-center">
						No hay <strong>voluntariados</strong> cargados.
					</td>
				</tr>
			</tbody>
		</table>
	</div>
	<hr>
	<p class="h6 text-right">@{{voluntariados.length}} voluntariado(s) </p>

	<!-- Modal para eliminar voluntariado -->
	<div class="modal fade" id="eliminarvoluntariado">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
			    	<h5 class="modal-title"><strong>Eliminar Voluntariado</strong></h5>
			    </div>
				<div class="modal-body">
					<div class="col-lg-12">
						<br>
						<p class="h6 text-center">
							¿Está seguro que desea eliminar permanentemente el voluntariado de <strong>@{{becario_voluntariado}}</strong> con nombre <strong>@{{nombre_voluntariado}}</strong>?
						</p>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-sm sisbeca-btn-default pull-right" data-dismiss="modal">No</button>
					<button type="button" class="btn btn-sm sisbeca-btn-primary pull-right" @click="eliminarVoluntariado(id)">Si</button>
				</div>
			</div>
		</div>
	</div>
	<!-- Modal para eliminar voluntariado -->
</div>
@endsection

@section('personaljs')


<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>

<script>
	Vue.use(BootstrapVue);
	const items = [
	{ isActive: true, age: 40, name: { first: 'Dickerson', last: 'Macdonald' } },
	{ isActive: false, age: 21, name: { first: 'Larsen', last: 'Shaw' } },
	{
		isActive: false,
		age: 9,
		name: { first: 'Mini', last: 'Navarro' },
		_rowVariant: 'success'
	},
	{ isActive: false, age: 89, name: { first: 'Geneva', last: 'Wilson' } },
	{ isActive: true, age: 38, name: { first: 'Jami', last: 'Carney' } },
	{ isActive: false, age: 27, name: { first: 'Essie', last: 'Dunlap' } },
	{ isActive: true, age: 40, name: { first: 'Thor', last: 'Macdonald' } },
	{
		isActive: true,
		age: 87,
		name: { first: 'Larsen', last: 'Shaw' },
		_cellVariants: { age: 'danger', isActive: 'warning' }
	},
	{ isActive: false, age: 26, name: { first: 'Mitzi', last: 'Navarro' } },
	{ isActive: false, age: 22, name: { first: 'Genevieve', last: 'Wilson' } },
	{ isActive: true, age: 38, name: { first: 'John', last: 'Carney' } },
	{ isActive: false, age: 29, name: { first: 'Dick', last: 'Dunlap' } }
	];
	const app = new Vue({

	el: '#app',
	created: function()
	{
		this.obtenervoluntariados();
		this.obtenerestatusaval();
	},
	data:
	{
		id: 0,
		nombre_voluntariado:'',
		becario_voluntariado:'',
		voluntariados:[],
		estatus:[],
		seleccionado:'',
		tmp:'',
		items: items,
		fields: [
			{ key: 'name', label: 'Person Full name', sortable: true, sortDirection: 'desc' },
			{ key: 'age', label: 'Person age', sortable: true, 'class': 'text-center' },
			{ key: 'isActive', label: 'is Active' },
			{ key: 'actions', label: 'Actions' }
		],
		currentPage: 1,
		perPage: 5,
		totalRows: items.length,
		pageOptions: [ 5, 10, 15 ],
		sortBy: null,
		sortDesc: false,
		sortDirection: 'asc',
		filter: null,
		modalInfo: { title: '', content: '' }
	},
	computed: {
		sortOptions () {
		// Create an options list from our fields
		return this.fields
			.filter(f => f.sortable)
			.map(f => { return { text: f.label, value: f.key } })
			}
	},
	methods:
	{
		info (item, index, button) {
		this.modalInfo.title = `Row index: ${index}`
		this.modalInfo.content = JSON.stringify(item, null, 2)
		this.$root.$emit('bv::show::modal', 'modalInfo', button)
		},
		resetModal () {
		this.modalInfo.title = ''
		this.modalInfo.content = ''
		},
		onFiltered (filteredItems) {
		// Trigger pagination to update the number of buttons/pages due to filtering
		this.totalRows = filteredItems.length
		this.currentPage = 1
		},
		modalEliminar(voluntariado,becario)
		{
			this.id=voluntariado.id;
			this.nombre_voluntariado=voluntariado.nombre;
			this.becario_voluntariado=becario.name+' '+becario.last_name;
			$('#eliminarvoluntariado').modal('show');
		},
		eliminarVoluntariado(id)
		{
			var url = '{{route('voluntariados.eliminarservicio',':id')}}';
			url = url.replace(':id', id);
			axios.get(url).then(response => 
			{
				$('#eliminarvoluntariado').modal('hide');
				toastr.success(response.data.success);
				this.obtenervoluntariados();			
			});
		},
		urlVerComprobante(slug)
		{
			var url = "{{url(':slug')}}";
    		url = url.replace(':slug', slug);
            return url;
		},
		urlEditarVoluntariado(id)
		{
			var url = '{{route('voluntariados.editar',':id')}}';
			url = url.replace(':id', id);
			return url;
		},
		obtenervoluntariados: function()
		{
			var url = '{{route('voluntariados.obtenertodos')}}';
			axios.get(url).then(response => 
			{
				this.voluntariados = response.data.voluntariados;
			});
		},
		obtenerestatusaval: function()
		{
			var url = '{{route('aval.getEstatus')}}';
			axios.get(url).then(response => 
			{
				this.estatus = response.data.estatus;
			});	
		},
		actualizarestatus(estatu,id)
		{	
			var dataform = new FormData();
            dataform.append('estatus', estatu);
            var url = '{{route('aval.actualizarestatus',':id')}}';
            url = url.replace(':id', id);
			axios.post(url,dataform).then(response => 
			{
				this.obtenervoluntariados();
				toastr.success(response.data.success);
			});
		},
		fechaformatear(fecha)
		{
			return moment(new Date (fecha)).format('DD/MM/YYYY');
		},
		fechacompletaformatear(fecha)
		{
			return moment(new Date (fecha)).format('DD/MM/YYYY hh:mm A');
		}
	}
});
</script>

@endsection