@extends('sisbeca.layouts.main')
@section('title','Reporte Tiempo')
@section('content')
<div class="col-lg-12" id="app">
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
				empty-text ="No hay becarios"
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
				
				<template slot="becario" slot-scope="row">
					@{{ row.item.becario.nombreyapellido}} (@{{ row.item.becario.cedula}})
				</template>

				<template slot="tiempo_actividades" slot-scope="row">
					@{{ row.item.tiempo_actividades}}
				</template>

				<template slot="tiempo_cva" slot-scope="row">
					@{{ row.item.tiempo_cva}}
				</template>

				<template slot="tiempo_voluntariado" slot-scope="row">
					@{{ row.item.tiempo_voluntariado}}
				</template>

				<template slot="tiempo_periodos" slot-scope="row">
					@{{ row.item.tiempo_periodos}}
				</template>
				<!--
				<template slot="actions" slot-scope="row">
					<p>mis acciones</p>
				</template>
				-->
			</b-table>

			<b-row class="my-0 pull-right" >
				<b-pagination :total-rows="totalRows" :per-page="perPage" v-model="currentPage" class="my-0" />
			</b-row>


		</div>
	</div>
	
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
	Vue.use(BootstrapVue);
	const app = new Vue({

	el: '#app',
	data:
	{
		becarios:[],
		items:
		[{
			"tiempo_actividades": '',
			"tiempo_cva": "",
			"tiempo_voluntariado": "",
			"tiempo_periodos": "",
			"becario": {
				"id": null,
				"cedula": '',
				"nombreyapellido": "",
			},
		}],
		fields: [
		{ key: 'becario', label: 'Becario', sortable: true, 'class': 'text-center' },
		{ key: 'tiempo_actividades', label: 'Chat Club/Talleres', sortable: true, 'class': 'text-center' },
		{ key: 'tiempo_cva', label: 'CVA', sortable: true, 'class': 'text-center' },
		{ key: 'tiempo_voluntariado', label: 'Voluntariado', sortable: true, 'class': 'text-center' },
		{ key: 'tiempo_periodos', label: 'Nota Académica', sortable: true, 'class': 'text-center' },
		//{ key: 'actions', label: 'Acciones' }
		],
		currentPage: 1,
		perPage: 5,
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
		this.obtenerbecariosreportetiempo();
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
		obtenerbecariosreportetiempo()
		{
			var url = '{{route('seguimiento.reportetiempo.api')}}';
			axios.get(url).then(response => 
			{
				this.items = response.data.becarios;
				console.log(this.items);
				this.totalRows = this.items.length;
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