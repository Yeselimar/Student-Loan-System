@extends('sisbeca.layouts.main')
@section('title','Nóminas Generadas')
@section('content')
	
<div class="col-lg-12" id="app">

	<div class="card-body">
                                <ul class="nav nav-tabs" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#home" role="tab" aria-selected="true"><span class="hidden-sm-up"><i class="ti-home"></i></span> <span class="hidden-xs-down"> Listado de Nominas Generadas</span></a> </li>
                                    <li v-if="seccionD" class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile" role="tab" aria-selected="false"><span class="hidden-sm-up"><i class="ti-user"></i></span> <span class="hidden-xs-down">Profile</span></a> </li>
                                </ul>
                                <div class="tab-content tabcontent-border">
                                    <div class="tab-pane active show" id="home" role="tabpanel">
                                        <div class="p-20">
										<div class="table-responsive">
											<div v-if="seccionS" class="dataTables_wrapper dt-bootstrap4 no-footer">
												<div class="row">
													<div class="col-sm-12 col-md-6">
														<div class="dataTables_length" style="">
															<label>Mostrar 
																<select aria-controls="dd" v-model="perPageS" class="custom-select custom-select-sm form-control form-control-sm">
																	<option v-for="(value, key) in pageOptionsS" :key="key">
																		@{{value}}
																	</option>
																</select> Entradas</label>
															</div>
														</div>
														<div class="col-sm-12 col-md-6">
															<div class="dataTables_filter pull-right">
																<b-input-group-append>
																	<label>Buscar<input type="search" v-model="filterS" class="form-control form-control-sm" placeholder="" >
																	</label>
																</b-input-group-append>
															</div>
														</div>
													</div>

													<b-table 
													show-empty
													empty-text ="<span class='label label-default'>No existen nominas generadas recientemente</span>"
													empty-filtered-text="
													No hay registros que coincidan con su búsqueda"
													class="table table-bordered table-hover dataTable no-footer"
													stacked="md"
													:items="itemsS"
													:fields="fieldsS"
													:current-page="currentPageS"
													:per-page="parseInt(perPageS)"
													:filter="filterS"
													:sort-by.sync="sortByS"
													:sort-desc.sync="sortDescS"
													:sort-direction="sortDirectionS"
													@filtered="onFilteredS"
													>
													<template slot="mes" slot-scope="row">
															@{{row.item.mes}}/@{{row.item.year}}
													</template>
													<template slot="total_becarios" slot-scope="row">
														<span>@{{row.item.total_becarios}}</span>
													</template>

													<template slot="sueldo_base" slot-scope="row">
														<span>@{{formatomoneda(row.item.sueldo_base)}}</span>
														</a>
													</template>
													<template slot="total_pagado" slot-scope="row">
														<span>@{{formatomoneda(row.item.total_pagado)}}</span> 
														</a>
													</template>
													<template slot="fecha_generada" slot-scope="row">
														<span v-if="row.item.fecha_generada">@{{ fechaformatear(row.item.fecha_generada) }}</span>

													</template>
													
													
													<template slot="actions" slot-scope="row">
															
															<a v-b-popover.hover.bottom="'Detalle de la nomina'" :href="row.item.url_detalle" @click.stop="isLoading=true" class="btn btn-xs sisbeca-btn-primary">
																	<i class="fa fa-eye"></i>
															</a>
															<a v-b-popover.hover.bottom="'Generar nomina en PDF'" target="_blank" :href="row.item.url_pdf" @click.stop="isLoading=true" class="btn btn-xs sisbeca-btn-primary">
																<i class="fa fa-file-pdf-o"></i>
																</a>
																<a v-b-popover.hover.bottom="'Pagar Nomina'" :href="row.item.url_pagar" @click.stop="isLoading=true" class="btn btn-xs sisbeca-btn-primary">
																	<i class="fa fa-plus"></i>
															</a>
													</template>
														

												</b-table>

												<b-row class="my-0 pull-right" >
													<b-pagination :total-rows="totalRowsS" :per-page="parseInt(perPageS)" v-model="currentPageS" class="my-0" />
												</b-row>


											</div>
										</div>
                                        </div>
                                    </div>
                                    <div class="tab-pane p-20" id="profile" role="tabpanel">2</div>
                                </div>
</div>

	
	<section v-if="isLoading" class="loading" id="preloader">
      <div>
          <svg class="circular" viewBox="25 25 50 50">
              <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
      </div>
    </section>	
</div>
@endsection

@section('personaljs')
<script>
const app = new Vue({
	el: '#app',
	mounted: function()
	{
		this.showDate = true
	},
	data:
	{
		isLoading: false,
		seccionS: false,
		seccionD: false,
		itemsS:
			[],
			fieldsS: [
			{ key: 'mes', label: 'Mes/Año', sortable: true, 'class': 'text-center' },
			{ key: 'total_becarios', label: 'N° Becarios', sortable: true, 'class': 'text-center' },
			{ key: 'sueldo_base', label: 'Estipendio Actual', sortable: true, 'class': 'text-center' },
			{ key: 'total_pagado', label: 'Total a Pagar', sortable: true, 'class': 'text-center' },
			{ key: 'fecha_generada', label: 'Fecha Generada', sortable: true, 'class': 'text-center' },
			{ key: 'actions', label: 'Acciones', 'class': 'text-center' }
			],
			currentPageS: 1,
			perPageS: 10,
			totalRowsS: 0,
			pageOptionsS: [ 10, 20,50,100 ],
			sortByS: null,
			sortDescS: false,
			sortDirectionS: 'asc',
			filterS: null,
			mes: '',
			year: '',
	},
	computed: {
		sortOptionsS ()
			{
				// Create an options list from our fields
				return this.fieldsS
				.filter(f => f.sortable)
				.map(f => { return { text: f.label, value: f.key } })
			},
	},
	created(){
		this.isLoading=true
		this.getListarNominas()

	},
	methods: {
	fechaformatear(fecha)
		{
			if(fecha)
			{
				return moment(new Date (fecha)).format('DD/MM/YYYY')
			}
			return '-'
		},
		formatomoneda(monto)
		{
			if(monto){
				return Number(monto).toLocaleString("es-ES", {minimumFractionDigits: 2});

			} else 
				return 0
		},
		onFilteredS (filteredItems)
			{
				// Trigger pagination to update the number of buttons/pages due to filtering
				this.totalRowsS = filteredItems.length
				this.currentPageS = 1
			},
		getListarNominas(){
			url = "{{route('listar.nominas.api')}}"

				  this.isLoading = true
				  axios.get(url).then(response => 
					{
						if(response.data.res){
							this.itemsS = response.data.nominas
							this.seccionS = true;
							
							this.itemsS.forEach(function(nomina,i){
								console.log('nomonia',nomina)
								let url_d = "{{ route('nomina.listar.ver',array('mes'=>':m','anho'=>':y')) }}" 
								url_d=url_d.replace(':m',nomina.mes)
								url_d=url_d.replace(':y',nomina.year)
								nomina.url_detalle = url_d
								url_d = "{{ route('nomina.generado.pdf',array('mes'=>':m','anho'=>':y')) }}"
								url_d=url_d.replace(':m',nomina.mes)
								url_d=url_d.replace(':y',nomina.year)
								nomina.url_pdf = url_d
								url_d = "{{ route('nomina.pagar',array('mes'=>':m','anho'=>':y')) }}"
								url_d=url_d.replace(':m',nomina.mes)
								url_d=url_d.replace(':y',nomina.year)
								nomina.url_pagar = url_d
							},this)
							
						} else{
							toastr.warning('No existen nominas generadas recientemente');
						}
						this.isLoading = false


					}).catch( error => {
						toastr.error('Ha ocurrido un error inesperado');
						this.isLoading = false
					});
		}
	}
	
});
</script>
@endsection
