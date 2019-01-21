@extends('sisbeca.layouts.main')
@section('title','Postulación a Mentoría')
@section('subtitle','Postulación a Mentoría')
@section('content')

<div class="col-lg-12">
    <div class="panel panel-default">
        <div class="panel-body">
            <strong>Ingresar Información para su Postulación</strong>
            <hr>
            <form role="form" class="f1 formMultiple" method="post" action="{{ route('enviarPostulancionMentorGuardar') }}" enctype="multipart/form-data" style="padding: 0px!important">
                {{ csrf_field() }}

                    <div class="d-flex justify-content-center ">
                        <div class="form-group m-r-5">
                            <label class="form-group"> Nombre: </label>
                            <input class="sisbeca-input" name="nombre" type="text">
                        </div>
                        <div class="form-group m-r-5">
                            <label class="form-group"> Nombre</label>
                            <input class="sisbeca-input" name="nombre" type="text">
                        </div>
                        <div class="form-group m-r-5">
                            <label class="form-group"> Nombre</label>
                            <input class="sisbeca-input" name="nombre" type="text">
                        </div>


                    </div>
             <!--        <div class="d-flex card-body card-block">
                        <div class="d-flex form-group">
                            <label for="country" class=" form-control-label">Country</label>
                            <input type="text" id="country" placeholder="Country name" class="form-control">
                            <label for="url_pdf">Cargue su Hoja de Vida</label>
                            <input name="url_pdf" accept="application/pdf" type="file" id="url_pdf" class="sisbeca-input" required>
                            @if ($errors->has('url_pdf'))
                                <span class="help-block">
                                    <strong>{{ $errors->first('url_pdf') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div> -->

                <div class="f1-buttons">
                    <button type="submit" class="btn sisbeca-btn-primary">Enviar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@section('personaljs')

@endsection
