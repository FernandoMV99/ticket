@extends('menu.layout_cliente')
@section('title', 'Inicio')
@section('atributo1', 'hidden')
@section('img_title', 'inicio.svg')

@section('content')
<?php
use App\HostingCorreos;
use Carbon\Carbon;
?>



<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5><img class="rounded" width="20px" src="{{asset('multimedia/entrar.svg')}}"> Ingreso Diario</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$ingreso_diario->cantidad}}</h1>
                    <small>Total de Ingresos</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5><img class="rounded" width="20px" src="{{asset('multimedia/ticket2.svg')}}"> Tickets Generados</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$count_tickets_agregado}}</h1>
                    <div class="stat-percent font-bold text-info"><button  onclick="window.location='{{ route("tickets.index") }}'" class="btn label label-info float-right">Ver</button></div>
                    <small>Total de Tickets</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5><img class="rounded" width="20px" src="{{asset('multimedia/nota_venta.svg')}}"> Pagos Pendientes</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">S/.{{$suma_deuda_tickets_agregado}}</h1>
                    <div class="stat-percent font-bold text-info"><button onclick="window.location='{{ route("tickets.pagos_pendiente") }}'"  class="btn label label-info float-right">Ver</button></div>
                    <small>Total deuda</small>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="ibox ">
                <div class="ibox-title">
                    <h5><img class="rounded" width="20px" src="{{asset('multimedia/equipos.svg')}}"> Cantidad Equipos</h5>
                </div>
                <div class="ibox-content">
                    <h1 class="no-margins">{{$count_equipos}}</h1>
                    <div class="stat-percent font-bold text-info"><button onclick="window.location='{{ route("equipos.index") }}'" class="btn label label-info float-right">Ver</button></div>
                    <small>Total Equipos</small>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-lg-6">
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5><img class="rounded" width="20px" src="{{asset('multimedia/ticket2.svg')}}">  Mensajes</h5>
                        </div>
                        <div class="ibox-title">
                            <h3><i class="fa fa-envelope-o"></i> Respuestas Tickets</h3>
                            <small><i class="fa fa-tim"></i> Tienes {{$count_mensaje_tickets_respuesta}} Nuevos Mensajes por Leer</small>
                        </div>
                        <div class="ibox-content">
                            <div class="feed-activity-list">
                                @foreach($mensaje_tickets_respuesta as $mensaje_tickets_respuestas)
                                <div style="cursor: pointer;" class="feed-element" onclick="window.location='{{ route("tickets.show", $mensaje_tickets_respuestas->ticket_agregado_id) }}'">
                                    <div>
                                        <small class="float-right text-navy">{{$mensaje_tickets_respuestas->created_at}}</small>
                                        <strong>{{$mensaje_tickets_respuestas->trabajadors->name}} {{$mensaje_tickets_respuestas->trabajadors->last_name}}</strong>
                                        <div>{!! substr($mensaje_tickets_respuestas->mensaje, 0,80 )!!}....</div>
                                        <small class="text-muted"><b>Codigo Ticket: {{$mensaje_tickets_respuestas->ticket_agregado->codigo_ticket}}</b></small>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-12">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>Proximos a Vencer</h5>
                        </div>
                        <div class="ibox-content table-responsive">
                            <table class="table table-hover no-margins" >
                                <thead align="center">
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Fecha Vencimiento</th>
                                        <th>Value</th>
                                    </tr>
                                </thead>
                                <tbody align="center">
                                    {{$canti=NULL}}
                                    {{-- Hosting --}}
                                    @foreach($hosting as $hostings)
                                    <span hidden="">
                                        {{$date = $hostings->fecha_vencimiento}}
                                        {{$datework = Carbon::createFromDate($date)}}
                                        {{$now = Carbon::now()}}
                                        @if ($datework>$now) {{$testdate=$now->diffInDays($datework)}}
                                        @else {{$testdate= 0}}@endif
                                    </span>
                                    @if($testdate <30)
                                    <span hidden="">{{$canti=1}}</span>
                                    <tr onclick="window.location='{{ route("hosting.index") }}'">
                                        <td>Hosting <br> {{$hostings->dominio}} </td>
                                        <td><i class="fa fa-clock-o"></i> {{$hostings->fecha_vencimiento}} </td>
                                        <td style="color:red;text-align: center;" > @if($testdate ==0)<span class="label label-warning">Vencido</span>@else<b> {{$testdate}} Día(s)</b>@endif</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    {{-- Dominio --}}
                                    @foreach($dominio as $dominios)
                                    <span hidden="">
                                        {{$date = $dominios->fecha_vencimiento}}
                                        {{$datework = Carbon::createFromDate($date)}}
                                        {{$now = Carbon::now()}}
                                        @if ($datework>$now) {{$testdate=$now->diffInDays($datework)}}
                                        @else {{$testdate= 0}}@endif
                                    </span>
                                    @if($testdate <30)
                                    <span hidden="">{{$canti=1}}</span>
                                    <tr onclick="window.location='{{ route("dominios.index") }}'">
                                        <td>Dominio <br> {{$dominios->nombre_dominio}} </td>
                                        <td><i class="fa fa-clock-o"></i> {{$dominios->fecha_vencimiento}} </td>
                                        <td style="color:red;text-align: center;" > @if($testdate ==0)<span class="label label-warning">Vencido</span>@else<b> {{$testdate}} Día(s)</b>@endif</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    {{-- Licencia --}}
                                    @foreach($licencia as $licencias)
                                    <span hidden="">
                                        {{$date = $licencias->fecha_vencimiento}}
                                        {{$datework = Carbon::createFromDate($date)}}
                                        {{$now = Carbon::now()}}
                                        @if ($datework>$now) {{$testdate=$now->diffInDays($datework)}}
                                        @else {{$testdate= 0}}@endif
                                    </span>
                                    @if($testdate <30)
                                    <span hidden="">{{$canti=1}}</span>
                                    <tr onclick="window.location='{{ route("licencia.index") }}'">
                                        <td>Licencia  {{$licencias->categoria->nombre}}</td>
                                        <td><i class="fa fa-clock-o"></i> {{$licencias->fecha_vencimiento}} </td>
                                        <td style="color:red;text-align: center;" > @if($testdate ==0)<span class="label label-warning">Vencido</span>@else<b> {{$testdate}} Día(s)</b>@endif</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    {{-- Certificados --}}
                                    @foreach($certificado as $certificados)
                                    <span hidden="">
                                        {{$date = $certificados->fecha_vencimiento}}
                                        {{$datework = Carbon::createFromDate($date)}}
                                        {{$now = Carbon::now()}}
                                        @if ($datework>$now) {{$testdate=$now->diffInDays($datework)}}
                                        @else {{$testdate= 0}}@endif
                                    </span>
                                    @if($testdate <30)
                                    <span hidden="">{{$canti=1}}</span>
                                    <tr onclick="window.location='{{ route("certificado_ssl.index") }}'">
                                        <td>Certificado SSL</td>
                                        <td><i class="fa fa-clock-o"></i> {{$certificados->fecha_vencimiento}} </td>
                                        <td style="color:red;text-align: center;" > @if($testdate ==0)<span class="label label-warning">Vencido</span>@else<b> {{$testdate}} Día(s)</b>@endif</td>
                                    </tr>
                                    @endif
                                    @endforeach
                                    @if(empty($canti))
                                    <tr >
                                        <td colspan="3"><h3> <i>No hay Productos por Vencer</i></h3> </td>
                                    </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="col-lg-6">
           <div class="ibox ">
            <div class="ibox-title">
                <h5>Nosotros</h5>
            </div>
            <div>
                <div class="ibox-content no-padding border-left-right"  align="center">
                    <img alt="image" class="img-fluid" width="250px" src="{{asset('multimedia/empresa')}}/{{$empresa->foto}}">
                </div>
                <div class="ibox-content profile-content">
                    <h4><strong>{{$empresa->nombre}}</strong></h4>
                    <p><i class="fa fa-map-marker"></i> {{$empresa->pais}} / {{$empresa->departamento}} / {{$empresa->distrito}}</p>
                    <h5>Sobre Nosotros</h5>
                    <p>
                     {{$empresa->descripcion}}
                 </p>
                 <div class="row m-t-lg">
                    <div class="col-md-12">
                        <span class="line">
                            <b>Dejanos tu opinion, sugerencia o comentario para mejorar nuestra Plataforma de Servicio. Te lo agradecemos de antemano:</b></span>
                            <textarea name="" class="form-control" rows="5"></textarea>
                        </div>
                    </div><br>
                    <div class="user-button">
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-primary btn-sm btn-block"><i class="fa fa-envelope"></i> Enviar Sugerencia</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</div>
</div>

<!-- Mainly scripts -->
<script src="{{ asset('js/jquery-3.1.1.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.js') }}"></script>
<script src="{{ asset('js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
<script src="{{ asset('js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>

<script src="{{ asset('js/plugins/dataTables/datatables.min.js') }}"></script>
<script src="{{ asset('js/plugins/dataTables/dataTables.bootstrap4.min.js') }}"></script>
<!-- Custom and plugin javascript -->
<script src="{{ asset('js/inspinia.js') }}"></script>
<script src="{{ asset('js/plugins/pace/pace.min.js') }}"></script>

@endsection