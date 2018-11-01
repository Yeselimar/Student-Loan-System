@extends('sisbeca.layouts.main')
@section('title','Becarios')
@section('subtitle','Sin Mentorias')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="fa fa-users fa-fw"></span> Becarios sin Mentor Asignado</div>


                <br/>
                <div class="col-lg-12 table-responsive content-personal">
                    @if($becarios->count() > 0)
                        <form class="form-horizontal" method="post" action ="{{route('asignarMentorBecario')}}">
                            {{csrf_field()}}
                            <div class="container">
                                <div class="row">
                                    <div class='col-sm-6'>
                                        <div class="form-group">
                                                <label for="mentor">Seleccione un Mentor:</label>
                                                    <select class="form-control select-mentor" style="height: 400px !important;" required id="mentor" name="mentor">
                                                        @foreach($mentores as $mentor)
                                                        <option value={{$mentor->user_id}}>{{$mentor->user->name.' '.$mentor->user->last_name}} - Tiene {{$mentor->numeroBecarios()}} becario(s) asignado(s)</option>
                                                    @endforeach
                                                </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="becarios">Becarios</label>
                                            <select class="form-control select-becarios" multiple required id="becarios"   name="becarios[]">
                                                @foreach($becarios as $becario)
                                                    <option value={{$becario->user_id}}>{{$becario->user->name.' '.$becario->user->lastname.' - '. $becario->user->cedula .' - '. $becario->user->email.' ('.$becario->status.')'  }}</option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <br/>
                            <br/>
                            <br/>

                            <div style="padding-left: 40px">
                            <input class="btn btn-lg btn-primary"  style="margin-left: 5px;" type="submit" value="Asignar">
                            </div>
                        </form>

                    @else

                        <div class="alert  alert-warning alert-important" role="alert">
                            Actualmente no hay becarios sin mentor asignado...
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
    <div id="relacionBecarioMentorID">
        <relacion-becario-mentor></relacion-becario-mentor>
    </div>
@endsection

@section('personaljs')


<script src="{{asset('js/relacionBecarioMentor.js')}}"></script>
<script>


        /*Checkbox all*/
        $('#select_all').change(function() {
            var checkboxes = $(this).closest('form').find(':checkbox');
            checkboxes.prop('checked', $(this).is(':checked'));
        });


        $('.select-mentor').chosen({

            placeholder_text_single:'Seleccione un Mentor',
            no_results_text: 'No se encontraron resultados'

        });

        $('.textarea-content').trumbowyg();

        $('.select-becarios').chosen({

            placeholder_text_multiple: 'Seleccione los becarios',
            search_contains: true,
            no_results_text: 'No se encontraron resultados'
        });

    </script>




@endsection
