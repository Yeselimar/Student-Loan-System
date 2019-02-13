@extends('sisbeca.layouts.main')
@section('title','Aliados')
@section('content')
<div class="col-lg-12">
    <div class="text-right">
        <a href="{{route('aliado.create')}}" class="btn btn-sm sisbeca-btn-primary">Crear Aliado</a>
    </div>
    <br>
    <div class="table-responsive">
        <table class="table table-hover table-bordered">
            <thead>
                <tr>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Título</th>
                    <th class="text-center">URL</th>
                    <th class="text-center">Actualizada el</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @if($banners->count()==0)
                    <td colspan="7" class="text-center">No hay <strong>banners</strong></td>
                @else
                    @foreach($banners as $banner)
                    <tr>
                        <td class="text-center"><span class="label label-default">Nada</span></td>
                        <td class="text-center">{{$banner->titulo}}</td>
                        <td class="text-center">
                            <a href="{{$banner->url}}" class="btn btn-xs sisbeca-btn-primary" target="_blank">{{$banner->url}}</a>
                        </td>
                        <td class="text-center">{{$banner->fechaActualizacion()}}</td>
                        <td>
                            <span data-toggle="modal" data-target="#veraliado{{$banner->id}}">
                                <button type="button" class="btn btn-xs sisbeca-btn-primary" data-toggle="tooltip" data-placement="bottom" title="Ver">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </span>

                            <a href="{{ route('aliado.edit',$banner->id) }}" class="btn btn-xs sisbeca-btn-primary" data-toggle="tooltip" data-placement="bottom" title="Editar">
                                <i class="fa fa-pencil"></i>
                            </a>

                            <span data-toggle="modal" data-target="#eliminaraliado{{$banner->id}}">
                                <button type="button" class="btn btn-xs sisbeca-btn-default" data-toggle="tooltip" data-placement="bottom" title="Eliminar">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </span>
                        </td>
                    </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>

@foreach($banners as $banner)
<!-- Modal para eliminar -->
<div class="modal fade" id="eliminaraliado{{$banner->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Banner</strong></h5>
            </div>
            <div class="modal-body" style="padding-top: 0px;">
                <br>
                <p>¿Está seguro que desea eliminar al aliado: <strong>{{$banner->titulo}}</strong>?</p>
            </div>
            <div class="modal-footer" style="padding-left: 5px;padding-right: 5px;">
                <a href="{{route('aliado.destroy',$banner->id)}}" class="btn btn-sm sisbeca-btn-default pull-right">Si</a>
                <button type="button" class="btn btn-sm sisbeca-btn-primary pull-right" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal para eliminar -->

<!-- Modal para ver imagen -->
<div class="modal fade" id="veraliado{{$banner->id}}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><strong>Banner</strong></h5>
            </div>
            <div class="modal-body">
                <br>
                <img src="{{url($banner->imagen)}}" alt="{{$banner->titulo}}" class="img-responsive sisbeca-border" >
                <br><br>
                <p class="text-center h6">{{$banner->titulo}}</p>
            </div>
            <div class="modal-footer" style="padding-left: 5px;padding-right: 5px;">
                <button type="button" class="btn btn-sm sisbeca-btn-default pull-right" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<!-- Fin Modal para ver imagen -->
@endforeach

@endsection

@section('personaljs')

<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
    </script>
@endsection
