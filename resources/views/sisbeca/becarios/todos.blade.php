@extends('sisbeca.layouts.main')
@section('title','Todos los becarios')
@section('content')
<div class="col-lg-12" id="app">
	<div class="text-right">
		<a href="{{route('becarios.todos')}}" class="btn btn-sm sisbeca-btn-primary">Listar Becarios</a>
	</div>
	<br>
	<div class="table-responsive">
		<div id="becarios_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
			<div class="row">
				<div class="col-sm-12 col-md-6">
					<div class="dataTables_length" style="">
						<label>Mostrar 
							<select aria-controls="dd" v-model="perPage" class="custom-select custom-select-sm form-control form-control-sm">
								<option v-for="(value, key) in pageOptions" :key="key">
									@{{value}}
								</option>
							</select> Entradas</label>
						</div>
					</div>
					<div class="col-sm-12 col-md-6">
						<div class="dataTables_filter pull-right">
							<b-input-group-append>
								<label>Buscar<input type="search" v-model="filter" class="form-control form-control-sm" placeholder="" >
								</label>
							</b-input-group-append>
						</div>
					</div>
				</div>

				<b-table 
				show-empty
				empty-text ="No hay periodos"
				empty-filtered-text="
				No hay registros que coincidan con su búsqueda"
				class="table table-bordered table-hover dataTable no-footer"
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
				<template slot="estatus" slot-scope="row">
					<span v-if="row.item.estatus=='activo'" class="label label-success">
						@{{row.item.estatus}}
					</span>
					<span v-if="row.item.estatus=='inactivo'" class="label label-danger">
						@{{row.item.estatus}}
					</span>

					<div v-if="row.item.estatus=='probatorio1'">
						<span class="label label-warning">
							@{{row.item.estatus}}
						</span>
					</div>
					<div v-else-if="row.item.estatus=='probatorio2'">
						<span class="label label-danger">
							@{{row.item.estatus}}
						</span>
					</div>
					
				</template>
				<template slot="actions" slot-scope="row">
					asas
				</template>

			</b-table>

			<b-row class="my-0 pull-right" >
				<b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" />
			</b-row>


		</div>
	</div>
	<hr>
	asasa
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

    el: '#app',
    data:
    {
        becarios:[],
        items:
		[{
			"id": null,
			"estatus": "",
			"rol": "",
			"cedula": "",
			"becario": ""
		}],
		fields: [
		{ key: 'becario', label: 'Becario', sortable: true, 'class': 'text-center' },
		{ key: 'cedula', label: 'Cédula', sortable: true, 'class': 'text-center' },
		{ key: 'rol', label: 'Rol', sortable: true, 'class': 'text-center' },
		{ key: 'estatus', label: 'Estatus', sortable: true, 'class': 'text-center' },
		{ key: 'actions', label: 'Acciones' }
		],
		currentPage: 1,
		perPage: 10,
		totalRows: 0,
		pageOptions: [ 5, 10, 15 ],
		sortBy: null,
		sortDesc: false,
		sortDirection: 'asc',
		filter: null,
		modalInfo: { title: '', content: '' }
    },
    beforeCreate:function()
	{
		$("#preloader").show();
	},
    created: function()
    {
        this.obtenerbecarios();
    },
    computed:
	{
		sortOptions ()
		{
			// Create an options list from our fields
			return this.fields
			.filter(f => f.sortable)
			.map(f => { return { text: f.label, value: f.key } })
		}
	},
    methods:
    {
    	onFiltered (filteredItems)
		{
			// Trigger pagination to update the number of buttons/pages due to filtering
			this.totalRows = filteredItems.length
			this.currentPage = 1
		},
    	obtenerbecarios()
    	{
    		var url = '{{route('becarios.todos.api')}}';
            axios.get(url).then(response => 
            {
               	this.items = response.data.becarios;
            	$("#preloader").hide();
			}).catch( error => {
				console.log(error);
				$("#preloader").hide();
			});
    	}
    }
});
</script>
@endsection