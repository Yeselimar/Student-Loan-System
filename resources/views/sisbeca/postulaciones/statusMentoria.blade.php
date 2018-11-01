@extends('sisbeca.layouts.main')
@section('title','Inicio')
@section('subtitle','Postulación')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="fa fa-users fa-fw"></span> Status de Postulación</div>


                <div class="col-md-12">
                    <div class="box box-danger box-solid">

                        <div class="alert  alert-info alert-important" role="alert">
                            Su Postulación fue enviada Exitosamente, Actualmente se encuentra en proceso de ser revisada!!
                        </div>
                        <!-- /.box-body -->
                        <!-- Loading (remove the following to stop the loading)-->
                        <div  class="overlay">
                            <i class="fa fa-refresh fa-spin"></i>

                        </div>
                        <div align="center">
                            <span style="font-size: 25px" class="label label-light-info"><strong>EN PROCESO...</strong></span>
                        </div>
                        <!-- end loading -->
                    </div>
                    <!-- /.box -->
                </div>

            </div>
        </div>
    </div>
@endsection


