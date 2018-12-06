@extends('sisbeca.layouts.main')
@section('title',$model=='crear' ? $becario->user->nombreyapellido().' - Cargar Voluntariado' : $becario->user->nombreyapellido().' - Editar Voluntariado: '.$voluntariado->nombre)
@section('content')
	<div class="col-lg-12">
        <div class="text-right">
            @if(Auth::user()->esBecario())
                <a href="{{route('voluntariados.index')}}" class="btn btn-sm sisbeca-btn-primary">Atrás</a>
            @else
                <a href="{{route('voluntariados.todos')}}" class="btn btn-sm sisbeca-btn-primary">Atrás</a>
            @endif
        </div>
		<br>
		<div class="col sisbeca-container-formulario">

			@if($model=='crear')

				{{ Form::open(['route' => ['voluntariados.guardar',$becario->user->id], 'method' => 'post', 'class'=>'form-horizontal', 'novalidate' => 'novalidate', 'files'=> true]) }}

			@else
				{{ Form::model($voluntariado,['route' => ['voluntariados.actualizar',$voluntariado->id], 'method' => 'post', 'class'=>'form-horizontal', 'novalidate' => 'novalidate', 'files'=> true]) }}
			@endif

			@if($model=='editar')
			@endif
			<div class="form-group">
				<div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <label class="control-label">Becario</label>
                        {{ Form::text('becario', $becario->user->nombreyapellido(), ['class' => 'sisbeca-input sisbeca-disabled', 'disabled'=>'disabled'])}}
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <label class="control-label">*Fecha</label>
                        {{ Form::text('fecha', ($model=='crear') ? null : date("d/m/Y", strtotime($voluntariado->fecha)) , ['class' => 'sisbeca-input', 'placeholder'=>'DD/MM/AAAA', 'id'=>"fecha"])}}
                        <span class="errors" >{{ $errors->first('fecha') }}</span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <label class="control-label">*Nombre</label>
                        {{ Form::text('nombre', ($model=='crear') ? null : $voluntariado->nombre , ['class' => 'sisbeca-input', 'placeholder'=>'Voluntariado en Caracas', 'id'=>"fechafin"])}}
                        <span class="errors">{{ $errors->first('nombre') }}</span>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <label class="control-label">*Descripción</label>
                        {{ Form::textarea('descripcion', ($model=='crear') ? null : $voluntariado->descripcion , ['class' => 'sisbeca-input sisbeca-textarea', 'placeholder'=>'Ingrese descripción'])}}
                        <span class="errors">{{ $errors->first('descripcion') }}</span>
                    </div>
                    
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <label class="control-label">*Tipo</label>
                        {{ Form::select('tipo', array('interno'=>'interno','externo'=>'externo'),($model=='crear') ? 'interno' : $voluntariado->tipo,['class' =>'sisbeca-input']) }}
                        <span class="errors">{{ $errors->first('tipo') }}</span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <label class="control-label">*Lugar</label>
                        {{ Form::text('lugar', ($model=='crear') ? null : $voluntariado->lugar , ['class' => 'sisbeca-input', 'placeholder'=>'Los Ruices, Caracas', 'id'=>"fechafin"])}}
                        <span class="errors" >{{ $errors->first('lugar') }}</span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <label class="control-label">*Horas</label>
                        {{ Form::text('horas', ($model=='crear') ? null : $voluntariado->horas , ['class' => 'sisbeca-input', 'placeholder'=>'17', 'id'=>"horas"])}}
                        <span class="errors">{{ $errors->first('horas') }}</span>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-6">
                    	<label for="comprobante" class="control-label">
                    		{{ $model=='crear' ? '*Comprobante' : 'Actualizar Comprobante' }}
                        </label>
                        {{ Form::file('comprobante',['class' => 'sisbeca-input ', 'accept'=>'image/jpeg,image/jpg/image/png,application/pdf' ] ) }}
                        <span class="errors">{{ $errors->first('comprobante') }}</span>
                    </div>
                    @if($model=='editar')
                    <div class="col-lg-4 col-md-4 col-sm-6">
                    	<label for="comprobante" class="control-label">Comprobante Actual</label>
                        <a href="{{url($voluntariado->aval->url)}}" target="_blank" class="btn sisbeca-btn-primary btn-block">
                        	@if( $voluntariado->aval->esImagen() )
                        		<i class="fa fa-photo"></i>
                        	@else
                        		<i class="fa fa-file-pdf-o"></i>
                        	@endif
                        	Ver
                    	</a>
                    </div>
                    @endif

                    @if(Auth::user()->rol==="admin")
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        <label for="estatus" class="control-label">Estatus Comprobante</label>
                        {{ Form::select('estatus', array('pendiente'=>'pendiente','aceptada'=>'aceptada','negada'=>'negada'), $voluntariado->aval->estatus,['class' =>'sisbeca-input']) }}
                    </div>
                    @endif
				</div>
			</div>

			<hr>	

			<div class="form-group">
				<div class="row">
					<div class="col-lg-12 text-right" >
                        @if(Auth::user()->esBecario())
                            <a href="{{route('voluntariados.index')}}" class="btn sisbeca-btn-default">Cancelar</a>
                        @else
                            <a href="{{route('voluntariados.todos')}}" class="btn sisbeca-btn-default">Cancelar</a>
                        @endif

                        @if($model=='editar')
                            @if($voluntariado->aval->estatus!='aceptada')
                                <button class="btn sisbeca-btn-primary" type="submit">Guardar</button>
                            @else
                                <button class="btn sisbeca-btn-primary" type="submit" disabled="disabled">Guardar</button>
                            @endif
                        @else
                            <button class="btn sisbeca-btn-primary" type="submit">Guardar</button>
                        @endif
					</div>
				</div>
			</div>		

			{{ Form::close() }}
		</div>
	</div>
@endsection

@section('personaljs')

<script>
	$('#fecha').datepicker({
		format: 'dd/mm/yyyy',
		language: 'es',
		orientation: 'bottom',
		autoclose: true,
	});
</script>
@endsection
