<!DOCTYPE html>
<html lang="es">
<head>
    <?php
    use App\TicketsRespuesta;
    use  App\TicketsAgregado;
    use  App\Archivos;
    $user_logeado=auth()->user()->id;
    $tickets_cantidad=TicketsAgregado::where('estado_id','1')->count();
    $tickets_respuesta_cantidad=TicketsRespuesta::where('estado_id','1')->where('cliente',$user_logeado)->count();
    $tickets_agregado_notificaciones=TicketsAgregado::where('estado_id','1')->take(7)->get();
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>@yield('title', 'Inicio')</title>
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="icon" type="image/png" href="{{asset('multimedia/favicon.svg')}}">

<link href="{{asset('css/plugins/awesome-bootstrap-checkbox/awesome-bootstrap-checkbox.css')}}" rel="stylesheet">
<link href="{{asset('css/plugins/iCheck/custom.css')}}" rel="stylesheet">

<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('font-awesome/css/font-awesome.css') }}" rel="stylesheet">

<!-- Toastr style -->
<link href="{{ asset('css/plugins/toastr/toastr.min.css') }}" rel="stylesheet">

<!-- Gritter -->
<link href="{{ asset('js/plugins/gritter/jquery.gritter.css') }}" rel="stylesheet">

<link href="{{ asset('css/animate.css') }}" rel="stylesheet">
<link href="{{ asset('css/style.css') }}" rel="stylesheet">
<link href="{{ asset('main.css') }}" rel="stylesheet">
<!-- Ladda style -->
<link href="{{ asset('css/plugins/ladda/ladda-themeless.min.css') }}" rel="stylesheet">

<!-- css Formulario con categorias 1 2 3 -->
<link href="{{ asset('css/plugins/steps/jquery.steps.css') }}" rel="stylesheet">


</head>
<body>
    <div id="wrapper">
        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav metismenu" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            @if( isset(Auth::user()->foto))
                            <img style="width: 150px;height: 150px;border-radius: 10px" src="{{asset('multimedia/users/')}}/{{ Auth::user()->foto }}"  >
                            @else
                            <img style="width: 150px;height: 150px;border-radius: 10px" src="{{asset('multimedia/users/usuario.svg')}}"  >
                            @endif
                            <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                <span class="block m-t-xs font-bold">{{Auth::user()->name}} {{Auth::user()->last_name}} </span>
                                <span class="text-muted text-xs block">{{Auth::user()->empresa}} </span>
                            </a>
                        </div>
                        <div class="logo-element">
                            @if( isset(Auth::user()->foto))
                            <img  alt="image" src="{{asset('multimedia/users/')}}/{{Auth::user()->foto}}" style="width: 50px;height: 50PX;border-radius: 10px"  >
                            @else
                            <img style="width: 50px;height: 50PX;border-radius: 10px" src="{{asset('multimedia/users/usuario.svg')}}"  >
                            @endif

                        </div>
                    </li>

                    {{-- Menu --}}
                    <style>
                    .iconos{width: 22px;margin-right: 10px}
                </style>

                <li>
                    <a href="/"><img src="{{ asset('/multimedia/inicio.svg')}}" class="iconos"><span class="nav-label">Inicio</span> </a>
                </li>
                <li>
                    <a href="#"><img src="{{ asset('/multimedia/ticket2.svg')}}" class="iconos"><span class="nav-label">Tickets</span> <span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level">
                        <li><a href="{{route('tickets.index')}}">Tickets</a></li>
                        <li><a href="{{route('tickets.pagos_pendiente')}}">Pagos Pendientes</a></li>
                    </ul>
                </li>
                <li class="">
                    <a href="#" aria-expanded="false"><img src="{{ asset('/multimedia/productos_web.svg')}}" class="iconos"><span class="nav-label">Productos</span><span class="fa arrow"></span></a>
                    <ul class="nav nav-second-level collapse" aria-expanded="false" style="height: 0px;">
                        <li><a href="{{route('certificado_ssl.index')}}">Certificado SSL</a></li>
                        <li><a href="{{route('dominios.index')}}">Dominios</a></li>
                        <li><a href="{{route('hosting.index')}}">Hosting</a></li>
                        <li><a href="{{route('licencia.index')}}">Licencia</a></li>
                    </ul>
                </li>
                <li><a href="{{route('equipos.index')}}"><img src="{{ asset('/multimedia/equipos.svg')}}" class="iconos"><span class="nav-label">Mis Equipos</span></a></li>
                <li>
                    <a href="{{route('soporte_tecnico.index')}}"><img src="{{ asset('/multimedia/soporte_tecnico.svg')}}" class="iconos"><span class="nav-label">Soporte Tecnico</span></a>
                </li>

                {{-- Fin Menu --}}

            </ul>

        </div>
    </nav>
    <style>
    li.iconos_notificaciones{ margin-right: 10px;}
    ul.notificaciones{margin-right: 30px}
</style>
<div id="page-wrapper" class="gray-bg dashbard-1">
    <div class="row border-bottom">
        <nav class="navbar navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
            </div>
            <ul class="nav navbar-top-links navbar-right notificaciones">
                <!-- Mensajes -->
                <li class="dropdown iconos_notificaciones">
                          {{--   <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                             <img src="{{ asset('multimedia/ticket.svg') }}" alt="ticket" width="18px">
                             @if($tickets_cantidad>0 and  Auth::user()->roles_id != 3)
                             <span class="label label-warning">{{$tickets_cantidad}}</span>
                             @elseif( Auth::user()->roles_id == 3)
                             <span class="label label-warning">{{$tickets_respuesta_cantidad}}</span>
                             @endif
                         </a> --}}  {{-- Tickets --}}
                         @if($tickets_cantidad>0)
                         <ul class="dropdown-menu dropdown-messages dropdown-menu-right">
                            @foreach($tickets_agregado_notificaciones as $tickets_agregado_notificacione)
                            <a href="{{ route('tickets.show', $tickets_agregado_notificacione->id) }}">
                                <li>
                                    <div class="dropdown-messages-box">
                                      {{--   <a class="dropdown-item float-left" href="profile.html">
                                            <img alt="image" class="rounded-circle" src="img/profile.jpg">
                                        </a> --}}
                                        <div class="media-body ">
                                            <small class="float-right">{{$tickets_agregado_notificacione->codigo_ticket}}</small>
                                            <strong>{{$tickets_agregado_notificacione->motivo->nombre}}</strong> : <strong>{{$tickets_agregado_notificacione->clientes->name}}</strong>
                                            <br>
                                            <small class="text-muted">{{$tickets_agregado_notificacione->created_at}}</small>
                                        </div>
                                    </div>
                                </li>
                            </a>
                            @endforeach
                            <li class="dropdown-divider"></li>
                            <li>
                                <div class="text-center link-block">
                                    <a href="{{route('tickets.index')}}" class="dropdown-item">
                                     <img src="{{ asset('multimedia/ticket.svg') }}" alt="ticket" width="18px"><strong> Leer Todos los Tikets</strong>
                                 </a>
                             </div>
                         </li>
                     </ul>
                     @endif

                 </li>
                 <!-- Fin Mensajes -->

                 <!-- Notificaciones -->
                 <li class="dropdown iconos_notificaciones">

                    {{-- <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell"></i>  <span class="label label-primary">8</span>
                    </a> --}}
                    <ul class="dropdown-menu dropdown-alerts">
                        <li>
                            <a href="grid_options.html" class="dropdown-item">
                                <div>
                                    <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                    <span class="float-right text-muted small">4 minutes ago</span>
                                </div>
                            </a>
                        </li>
                        <li class="dropdown-divider"></li>
                        <li>
                            <div class="text-center link-block">
                                <a href="notifications.html" class="dropdown-item">
                                    <strong>Ver Todas Las Alertas</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </li>
                <!-- Fin Notificaciones -->
                <!-- Configuracion -->
                <li class="dropdown iconos_notificaciones">
                    <div class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#" style="margin-right: 10px">
                            <span class="text-muted text-xs block"><img src="{{ asset('multimedia/configuracion.svg') }}" alt="configuracion" width="18px"> </span>
                        </a>
                        <ul class="dropdown-menu animated fadeInRight">
                            <li><a class="dropdown-item" href="{{route('usuario.edit',Auth::user()->id) }}"><img src="{{ asset('multimedia/perfil.svg') }}" alt="perfil" width="14px"> Perfil</a></li>
                            <li class="dropdown-divider"></li>
                            <li><a href="{{ route('logout') }}"onclick="event.preventDefault();document.getElementById('logout-form').submit();"><img src="{{ asset('multimedia/salir.svg') }}" alt="salir" width="14px"> Salir<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                            </i></a></li>
                        </ul>
                    </div>
                </li>
                <!-- Fin Configuracion -->

            </nav>
        </div>
        <div class="row  border-bottom white-bg dashboard-header">
            <div class="col-lg-10"><h2><img src="/multimedia/@yield("img_title",'' )" width="30px"> @yield('title', 'Inicio')</h2></div>
            <div class="col-lg-2" align="right">
                <a  data-toggle="@yield('data-toggle1', '')" data-target="@yield('data-target1', '')" @yield('atributo1', '')  href="@yield('href_accion1', '#')" class="btn btn-primary">@yield('value_accion1', '')</a>

                <a  data-toggle="@yield('data-toggle2', '')" data-target="@yield('data-target1', '')"  @yield('atributo2', 'hidden')  href="@yield('href_accion2', '#')" class="btn btn-primary">@yield('value_accion2', '')</a>
            </div>
        </div>

        @yield('content')
        {{-- Contenido --}}


        <div class="footer">
          <div class="float-right">
            Visitanos: &nbsp;&nbsp; <a href="https://www.facebook.com/JYPPERIFERICOS" target="_blank" ><i class="fa fa-facebook-square" aria-hidden="true"></i></a>&nbsp;
            <a href="https://api.whatsapp.com/send?phone=51946201443&text=Hola!%20Necesito%20Ayuda%20con%20el%20sistema%20de%20Facturación,%20Gracias!%20" target="_blank" ><i class="fa fa-whatsapp" aria-hidden="true"></i></a>
        </div>
        <div>
            <strong>Copyright </strong> &nbsp;<a href="http://www.jypsac.com" target="_blank" > JyP Perifericos</a>&nbsp;  &copy; 2021-2022
        </div>
    </div>
</div>

</div>
</div>
{{-- Chat Virtual --}}
<div class="small-chat-box fadeInRight animated">

    <div class="heading" draggable="true">
        <small class="chat-date float-right">
            02.19.2015
        </small>
        Small chat
    </div>

    <div class="content">

        <div class="left">
            <div class="author-name">
                Monica Jackson <small class="chat-date">
                    10:02 am
                </small>
            </div>
            <div class="chat-message active">
                Lorem Ipsum is simply dummy text input.
            </div>

        </div>
        <div class="right">
            <div class="author-name">
                Mick Smith
                <small class="chat-date">
                    11:24 am
                </small>
            </div>
            <div class="chat-message">
                Lorem Ipsum is simpl.
            </div>
        </div>
        <div class="left">
            <div class="author-name">
                Alice Novak
                <small class="chat-date">
                    08:45 pm
                </small>
            </div>
            <div class="chat-message active">
                Check this stock char.
            </div>
        </div>
        <div class="right">
            <div class="author-name">
                Anna Lamson
                <small class="chat-date">
                    11:24 am
                </small>
            </div>
            <div class="chat-message">
                The standard chunk of Lorem Ipsum
            </div>
        </div>
        <div class="left">
            <div class="author-name">
                Mick Lane
                <small class="chat-date">
                    08:45 pm
                </small>
            </div>
            <div class="chat-message active">
                I belive that. Lorem Ipsum is simply dummy text.
            </div>
        </div>


    </div>
    <div class="form-chat">
        <div class="input-group input-group-sm"><input type="text" class="form-control"> <span class="input-group-btn"> <button
            class="btn btn-primary" type="button">Send
        </button> </span></div>
    </div>

</div>
<div id="small-chat">

    <span class="badge badge-warning float-right">5</span>
    <a class="open-small-chat">
        <i class="fa fa-comments"></i>

    </a>
</div>
{{-- Chat Virtual --}}
</div>

<!-- Ladda -->
<script src="{{ asset('js/plugins/ladda/spin.min.js')}}"></script>
<script src="{{ asset('js/plugins/ladda/ladda.min.js')}}"></script>
{{-- <script src="js/plugins/ladda/ladda.jquery.min.js"></script> --}}

<script>
    $(document).ready(function (){
        // Bind normal buttons
        Ladda.bind( '.ladda-button',{ timeout: 10000 });
    });
</script>

<!-- Notificacion de Errores -->
@if($errors->any())
@foreach ($errors->all() as $error)
<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
<script>
    $(document).ready(function() {
        setTimeout(function() {
            toastr.options = {
                closeButton: true,
                progressBar: false,
                showMethod: 'slideDown',
                timeOut: 2500
            };
            toastr.error('{{ $error }}');
        }, 0);
    });
</script>@endforeach
@endif
<!-- FIN Notificacion de Errores -->
</body>
</html>
