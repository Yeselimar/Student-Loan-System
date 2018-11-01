@extends('sisbeca.layouts.main')
@section('title','Becarios')
@section('subtitle',' Elegir Becario')
@section('content')

    <div class="row">
        <div class="col-12">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="fa fa-users fa-fw"></span> Seleccione los Postulante que seran elegidos como Becario</div>

                <div class="col-lg-12 table-responsive">
                @if(($concursos->status='finalizado')||($becarios->count() > 0))
                    <form class="form-horizontal" method="post" action ="{{route('cambioStatus')}}">
                     {{csrf_field()}}
                    <div class="container">
                        <div class="row">
                            <div class='col-sm-12'>
                                <div class="form-group">
                                  
                                </div>
                            </div>
                        </div>
                    </div>

                   
                        <table id="myTable" data-order='[[ 0, "asc" ]]' data-page-length='10' class="display" style="width:100%">
                            <thead>
                            <tr>
                                <th class="text-center" ><input type="checkbox" value="1" id="select_all" name='all' onclick="check(this)">Seleccionar </th> 
                                <th class="text-center">Nombre y Apellido</th>
                                <th class="text-center">Cedula</th>
                                <th class="text-center">Entrevista</th>
                                <th class="text-center">E-mail</th>

                            </tr>
                            </thead>
                            <tbody >
                            @foreach($becarios as $becario)

                                <tr class="tr">
                                    <td class="text-center">
                                        <div class="checkbox">
                                            <label><input type="checkbox" value="1" name='{{$becario->user_id}}' id="select_all[]"></label>
                                        </div>
                                    </td>
                                  
                                    <td class="text-center">{{ $becario->user->name.' '.$becario->user->lastname }}</td>
                                    <td class="text-center">{{ $becario->user->cedula }}</td>
                                    <td class="text-center"><span class="label label-light-success"><strong>Entrevistado el {{ date("d/m/Y", strtotime($becario->fecha_entrevista))}}</strong></span></td>
                                    <td class="text-center">{{ $becario->user->email }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                      
                        <input class="btn btn-md btn-primary pull-right"  style="margin-left: 5px;" type="submit" value="Aprobar" name="aprobado">
                    
                   
                        </form>
                          

                      @else
                        <br/>
                    <div class="alert  alert-warning alert-important" role="alert">
                            Actualmente no hay Postulantes a ProExcelencia...
                    </div>
                    @endif
                   
                   <br/><br/>
                   <hr/>
                        
                       <button type="button" onclick="finalizarConcurso()"  class="btn btn-md btn-warning pull-left"  style="margin-right: 5px;" >Finalizar Concurso</button>

                </div>

            </div>
        </div>
    </div>

    <!-- MODAL -->

    <div class="modal fade" id="modal">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span></button>
                   <h4 class="modal-title">Confirmación</h4>
               </div>

               <p align="center">¿Esta seguro que desea Aprobar como Becario?</p>

               <form method="POST" action={{route('cambioStatus')}} accept-charset="UTF-8">

                   {{csrf_field()}}
                   {{method_field('PUT')}}
                  <input type="hidden" id='valor' name="valor"  value="0">
               <div class="modal-footer">
                   <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                   <button type="submit" class="btn btn-info pull-left">Si</button>
               </div>

               </form>

           </div>


       </div>

       <!-- /.modal-content -->
   </div>


   <div class="modal fade" id="modal-default">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span></button>
                   <h4 class="modal-title">Confirmación</h4>
               </div>

               <p align="center">¿Esta seguro que desea Rechazar a como Becario?</p>

               <form method="POST" action={{route('cambioStatus')}} accept-charset="UTF-8">

                   {{csrf_field()}}
                   {{method_field('PUT')}}
                   <input type="hidden" id='valor' name="valor"  value="0">
                   <div class="modal-footer">
                       <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>
                       <button type="submit" class="btn btn-info pull-left" >Si</button>
                   </div>

               </form>

           </div>


       </div>
   </div>

@endsection

@section('personaljs')

    <script>
        $(document).ready(function() {
            $('#myTable').DataTable( {
                columnDefs: [
                    { targets: [0], searchable: false}
                ]
            } );
        } );

        $('#myTable')
            .removeClass( 'display' )
            .addClass('table table-hover');

        $( function() {
            $( "#datepicker" ).datepicker({ minDate: 0, maxDate: "+2M +10D",orientation: "bottom" });
        } );

        /*Checkbox all*/
        $('#select_all').change(function() {
            var checkboxes = $(this).closest('form').find(':checkbox');
            checkboxes.prop('checked', $(this).is(':checked'));
        });

        function finalizarConcurso() {

            var route= "#";


            $.ajax({
                url: route,
                beforeSend: function() {
                    $('.preloader').show();
                },
                complete: function(){
                    location.assign( "{{route('finalizarConcurso')}}");
                }
            });

        }


    </script>

       @endsection



