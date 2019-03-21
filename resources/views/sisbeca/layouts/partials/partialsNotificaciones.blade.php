<!-- Comment -->
<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-muted text-muted  "  id="myBtnAlert" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-bell"></i>
      @if($cantNotif>0)
        <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
          @endif
    </a>
    <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn" id="myAlert">
        <ul>
            <li>
                <div class="drop-title">Notificaciones</div>
            </li>
            <li>

            @if($cantNotif>0)
                <div class="message-center">

                    <!-- Message -->
                    @for($i=0;$i<$alertas->count(); $i++)
                        @if(Auth::user()->rol==='coordinador')
                            <a href="{{route('solicitud.revisar',$alertas[$i]->solicitud)}}">
                                <div class="btn btn-danger btn-circle m-r-10"><i class="ti-user"></i></div>
                                <div class="mail-contnet">  
                                    <h6>{{$alertas[$i]->titulo}}</h6> <span class="mail-desc">{{$alertas[$i]->descripcion}}</span> <span class="time">{{$alertas[$i]->created_at}}</span>
                                </div>
                            </a>
                        @else
                            @if(Auth::user()->rol==='becario'||Auth::user()->rol==='mentor')
                            <a href="
                               @if(is_null($alertas[$i]->solicitud))
                                    @if(Auth::user()->rol==='becario')
                                        {{route('ver.mentorAsignado')}}
                                    @else
                                    {{route('listar.becariosAsignados')}}
                                    @endif
                                    @else
                                      {{route('solicitud.show',$alertas[$i]->solicitud)}}
                                    @endif
                                    "
                               >
                                <div class="btn btn-danger btn-circle m-r-10"><i class="ti-user"></i></div>
                                <div class="mail-contnet">
                                    <h6>{{$alertas[$i]->titulo}}</h6> <span class="mail-desc">{{$alertas[$i]->descripcion}}</span> <span class="time">{{$alertas[$i]->created_at}}</span>
                                </div>
                            </a>
                                @else
                                    @if(Auth::user()->rol==='directivo')
                                        @if($alertas[$i]->titulo==='Nomina(s) pendiente(s) por procesar')

                                          <a href="{{route('nomina.procesar')}}">
                                                <div class="btn btn-danger btn-circle m-r-10"><i class="ti-user"></i></div>
                                                <div class="mail-contnet">
                                                    <h6>{{$alertas[$i]->titulo}}</h6> <span class="mail-desc">{{$alertas[$i]->descripcion}}</span> <span class="time">{{$alertas[$i]->updated_at}}</span>
                                                </div>
                                            </a>
                                        @else
                                            @if(Auth::user()->esEntrevistador())
                                               fdfdfd
                                            @else
                                                @if($alertas[$i]->titulo==='Desincorporacion(es) pendiente(s) por procesar')

                                                    <a href="{{route('desincorporaciones.listar')}}">
                                                        <div class="btn btn-danger btn-circle m-r-10"><i class="ti-user"></i></div>
                                                        <div class="mail-contnet">
                                                            <h6>{{$alertas[$i]->titulo}}</h6> <span class="mail-desc">{{$alertas[$i]->descripcion}}</span> <span class="time">{{$alertas[$i]->created_at}}</span>
                                                        </div>
                                                    </a>
                                                @else
                                                    <a href="{{route('solicitud.revisar',$alertas[$i]->solicitud)}}">
                                                        <div class="btn btn-danger btn-circle m-r-10"><i class="ti-user"></i></div>
                                                        <div class="mail-contnet">
                                                            <h6>{{$alertas[$i]->titulo}}</h6> <span class="mail-desc">{{$alertas[$i]->descripcion}}</span> <span class="time">{{$alertas[$i]->created_at}}</span>
                                                        </div>
                                                    </a>
                                                @endif
                                            @endif
                                            @endif
                                        @else

                                        <a href="javascript:void(0)">
                                            <div class="btn btn-danger btn-circle m-r-10"><i class="ti-user"></i></div>
                                            <div class="mail-contnet">
                                                <h6>{{$alertas[$i]->titulo}}</h6> <span class="mail-desc">{{$alertas[$i]->descripcion}}</span> <span class="time">{{$alertas[$i]->created_at}}</span>
                                            </div>
                                        </a>

                                        @endif
                                @endif
                            @endif
                    @endfor


            </div>
            @else
                <p class="text-center">No Tiene Notificaciones Nuevas</p>
            @endif
        </li>
<li>
<a class="nav-link text-center" href="{{route('notificaciones.showAll')}}"> <strong>Ver todas las notificaciones</strong> <i class="fa fa-angle-right"></i> </a>
</li>
</ul>
</div>
</li>