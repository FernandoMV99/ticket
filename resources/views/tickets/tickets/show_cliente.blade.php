@extends('menu.layout_cliente')

@section('img_title', 'ticket2.svg')
@section('title', 'Tickets/Ver')
@section('value_accion1', 'Atras')
@section('href_accion1', route('tickets.index'))

<link href="{{ asset('css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
@section('content')

<style>/*Estilos de pagina*/
.contedor_mensaje{height: 500px}
.cuadro_ticket{margin-bottom: 70px}
table{font-size: 13px}
.note-insert{display: none}
.note-view{display: none}
.img_cliente{width: 60px;height: 60px;border-radius: 10px 0 0 10px;border-top: 0px}
.img_trabajador{width: 60px;height: 60px;border-radius: 0 10px 10px 0;border-top: 0px}
</style>

<div class="ibox-content cuadro_ticket">
	<div class="row">

		<div class="col-lg-12">{{-- Cabecera de ticket --}}
			<div class="form-control">
				<div class="row">
					<div class="col-lg-10">
						<h2>Ticket  #{{$tickets_agregado->codigo_ticket}}</h2>
					</div>
					<div class="col-lg-2" align="right">
						<button disabled=""  class="btn btn-info">@if($tickets_agregado->estado_resuelto==0)Abierto @else Cerrado @endif</button>
					</div>
					<div class="col-lg-12">
						<h3>Motivo: {{$tickets_agregado->motivo->nombre}}</h3>
						<h4>Asunto: {{$tickets_agregado->asunto}}</h4>
					</div>
				</div>
			</div>
		</div>

		<div class="col-lg-12">

			@if(isset($tickets_agregado->precio))<div class="alert alert-info alert-dismissable" style="margin-bottom: 0px;"><b>Nota:</b> Este Soporte Fue Cobrado por {{$tickets_agregado->moneda}}{{$tickets_agregado->precio}}</div>@endif

			<div class="chat-discussion contedor_mensaje">

				<div class="chat-message left">{{-- Primer Mensaje de ticket generado --}}
					<img class="message-avatar img_cliente" src="{{asset('multimedia/users/')}}/{{$tickets_agregado->clientes->foto}}">
					<div class="message" style="border-radius: 0px 5px 5px 5px;">
						<a class="message-author" href="#"> {{$tickets_agregado->clientes->name}}  {{$tickets_agregado->clientes->last_name}}</a>{{-- nombre usuario --}}
						<span class="message-date">{{$tickets_agregado->created_at}}</span>{{-- fecha y Hora --}}
						<span class="message-content">{!!$tickets_agregado->mensaje!!}</span>{{-- mensaje --}}
						<span class="row">
							@foreach($archivos_agregados as $archivos_agregado){{-- Archivos, fotos, que hayan mandado --}}
							<div class="col-lg-2">
								<img class="form-control" src="{{asset('multimedia/')}}/{{$archivos_agregado->carpeta}}/{{$archivos_agregado->nombre}}" alt="" >
							</div>
							@endforeach
						</span>
					</div>
				</div>

				@foreach($tickets_respuesta as $tickets_respuestas)

				<div class="chat-message{{-- Inicio div --}}
				@if(isset($tickets_respuestas->trabajador)) right
				@elseif($tickets_respuestas->clientes->roles_id ==3) left
				@endif" >{{-- Fin div --}}

				@if(isset($tickets_respuestas->trabajador)){{-- Imagen de Cliente y Trabajador --}}
				<img class="message-avatar img_trabajador" src="{{asset('multimedia/users/')}}/{{$tickets_respuestas->trabajadors->foto}}">
				@else
				<img class="message-avatar img_cliente" src="{{asset('multimedia/users/')}}/{{$tickets_respuestas->clientes->foto}}">
				@endif

				<div class="message" style="border-radius: 0">
					<a class="message-author" href="#">
						@if(isset($tickets_respuestas->trabajador)){{$tickets_respuestas->trabajadors->name}}
						@elseif($tickets_respuestas->clientes->roles_id ==3){{$tickets_respuestas->clientes->name}}
						@endif
					</a>
					<span class="message-date">{{$tickets_respuestas->created_at}}</span>
					<span class="message-content" style="text-align: left;"> {!!$tickets_respuestas->mensaje!!}</span>
					<span class="message-content" style="text-align: left;">
						@foreach($archivos_respuesta as $archivos_respuestas)
						@if($archivos_respuestas->tabla_id_bd == $tickets_respuestas->id)
						<div class="col-lg-2">
							<img class="form-control" src="{{asset('multimedia/')}}/{{$archivos_respuestas->carpeta}}/{{$archivos_respuestas->nombre}}"  alt="" >
						</div>
						@endif
						@endforeach
					</span>
				</div>
			</div>

			@endforeach
		</div>

	</div>
</div>{{-- Fin row --}}


<div class="row">
	<div class="col-lg-12">
		<div class="chat-message-form">
			<div class="form-group">
				<form action ="{{route('tickets_respuesta.store')}}" method="POST" enctype="multipart/form-data" >
					@csrf
					<textarea name="mensaje" required="" class="summernote" ></textarea>
					<input type="hidden" name="ticket_agregado_id" value="{{$tickets_agregado->id}}">
					<input type="hidden" name="cliente" value="{{$tickets_agregado->cliente}}">
					<button class="btn btn-info" >Enviar</button>
				</form>
			</div>
		</div>
	</div>
</div>

</div>
<style>
.note-editable.card-block{height: 151.906px;}
</style>

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

<!-- Page-Level Scripts -->
<script>
	$(document).ready(function(){
		$('.dataTables-example').DataTable({
			pageLength: 10,
			responsive: true,
			dom: '<"htmlbuttons"B>lTfgitp',
			buttons: []});
	});
</script>

<!-- iCheck -->
<script src="{{asset('js/plugins/iCheck/icheck.min.js')}}"></script>

<!-- SUMMERNOTE -->
<script src="{{asset('js/plugins/summernote/summernote-bs4.js')}}"></script>

<script>
	$(document).ready(function(){

		$('.summernote').summernote();

	});

</script>
@endsection