@extends('menu.layout')

@section('img_title', 'ticket2.svg')
@section('title', 'Tickets/Ver')
@section('value_accion1', 'Atras')
@section('href_accion1', route('tickets.index'))

<link href="{{ asset('css/plugins/summernote/summernote-bs4.css')}}" rel="stylesheet">
@section('content')

<style>/*Estilos de pagina*/
.contedor_mensaje{height: 500px}
.cuadro_ticket{margin-bottom: 70px}
.note-editable.card-block{height: 150px}
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

		<div class="col-lg-9">

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

	<div class="col-lg-3" style="padding-top: 10px">
		<div class="row" style="margin-bottom: 15px;">
			<div class="col-lg-4" align="right">
				<img class="message-avatar" style="width: 50px;height: auto" src="{{asset('multimedia/users/')}}/{{$tickets_agregado->clientes->foto}}">
			</div>
			<div class="col-lg-8" align="left">
				<h3>{{$tickets_agregado->clientes->name}} {{$tickets_agregado->clientes->last_name}}</h3>
				@if($notaventa>0)<button class="btn btn-info"  data-toggle="modal" data-target="#modal_nota_venta">Generar Nota venta </button>@endif
			</div>
		</div>
		<hr>
		<div  class="chat-discussion" style="background:white;padding-left: 0px;padding-top: 0px;">
			<div  class="row">
				<div class="col-lg-12 " style="color:black" >
					<h3>Información</h3>
				</div>
				<div class="col-lg-12" style="color:gray">
					<p> <strong>Empresa:</strong> {{$tickets_agregado->clientes->empresa}}</p>
					<p> <strong>Correo:</strong> {{$tickets_agregado->clientes->email}}</p>
					<p> <strong>Fecha de Registro:</strong> {{$tickets_agregado->clientes->created_at}}</p>
					<p> <strong>Tickets Generados:</strong>  {{$cantidad_ticket_generado_por_cliente}}</p>
				</div>
				<div class="col-lg-12"  style="color:black">
					<h3>Detalles de Soporte</h3>
				</div>
				<div class="col-lg-12" style="color:gray">
					@if(isset($soporte))

					<p class="expirado_sopor" > <strong>Plan Soporte:</strong> {{$soporte->plansoporte->nombre}}</p>
					<p class="expirado_sopor" > <strong>E.Seleccionados:</strong> {{$soporte->cantidad_equipos_asignados}} Equipo(s)</p>
					<p class="expirado_sopor" style="margin-bottom: 5px"> <strong>Fecha Vencimiento:</strong> {{$soporte->fecha_vencimiento}}</p>

					<style>
					@if($date_now>$soporte->fecha_vencimiento).expirado_sopor{color: red;}@endif
				</style>

				@else
				<p> No tiene Plan Soporte</p>
				@endif
				@if(isset($equipo_show))<p><strong>Equipos en Soporte:</strong> <a href="#" data-toggle="modal" data-target="#Equipo">Ver Equipo</a></p>@endif

			</div>
			{{-- Hosting --}}
			<div class="col-lg-12"  style="color:black">
				<h3>Detalles de Hosting</h3>
			</div>
			<div class="col-lg-12"  style="color:gray">
				@if(count($hosting)>0)
				@foreach($hosting as $hostings)
				<p @if($date_now>$hostings->fecha_vencimiento)style=" color: red;"@endif>{{$hostings->plan_hostings->nombre}} / {{$hostings->dominio}}</p>
				@endforeach
				@else
				<p>No tiene Ningun Hosting</p>
				@endif
			</div>
			{{--FIN Hosting --}}

			{{-- Dominio --}}
			<div class="col-lg-12"  style="color:black">
				<h3>Detalles de Dominio</h3>
			</div>
			<div class="col-lg-12"  style="color:gray">
				@if(count($dominio)>0)
				@foreach($dominio as $dominios)
				<p @if($date_now>$dominios->fecha_vencimiento)  style="color: red;"@endif>{{$dominios->nombre_dominio}}</p>
				@endforeach
				@else
				<p>No tiene Ningun Dominio</p>
				@endif
			</div>
			{{--FIN Dominio --}}

			{{-- Certificado SSL --}}
			<div class="col-lg-12"  style="color:black">
				<h3>Detalles de Certificado</h3>
			</div>
			<div class="col-lg-12"  style="color:gray">
				@if(count($certificado_ssl)>0)
				@foreach($certificado_ssl as $certificado_ssls)
				<p  @if($date_now>$certificado_ssls->fecha_vencimiento)  style="color: red;"@endif>{{$certificado_ssls->planes_ssl->nombre}} / {{$certificado_ssls->nombre_dominio}}</p>
				@endforeach
				@else
				<p>No tiene Ningun Certificado</p>
				@endif
			</div>
			{{--FIN Certificado SSL --}}

		</div>

	</div>



</div>
</div>{{-- Fin row --}}


<div class="row">
	<div class="col-lg-12">
		<div class="chat-message-form">
			<div class="form-group">
				<form action ="{{route('tickets_respuesta.store')}}" method="POST" enctype="multipart/form-data" >
					@csrf
					<textarea name="mensaje" required="" class="summernote" >

						<style> .note-editable.card-block{height: 356.719px;} </style>
						Hola {{$tickets_agregado->clientes->name}}: <br>
						Lamento que tengas problemas con " {{$tickets_agregado->motivo->nombre}}". Estaré encantado de ayudar.
						<br><br>
						(escribir Aqui)
						<br><br>Gracias por su paciencia.<br><br>
						============================================ <br>
						{{auth()->user()->name}} {{substr(auth()->user()->last_name, 0,1)}}.<br>
						Especialista en Soporte <br>
						{{$tickets_agregado->clientes->empresa}} - ¡Nuestra velocidad, su éxito! <br>

					</textarea>
					<input type="hidden" name="ticket_agregado_id" value="{{$tickets_agregado->id}}">
					<input type="hidden" name="cliente" value="{{$tickets_agregado->cliente}}">
					<button class="btn btn-info" >Enviar</button>
				</form>
			</div>
		</div>
	</div>
</div>


</div>

@if(isset($equipo_show))
{{-- Modal --}}
<div class="modal inmodal fade" id="Equipo" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog ">
		<div class="modal-content">
			<div class="ibox-title" align="center" style="padding:10px 0;border-bottom: 2px solid #00000026;">
				<h4 class="modal-title">Detalles Software</h4>
			</div>
			<div class="modal-body">
				<div class="row" >
					<div class="col-4" align="center">
						<img alt="image" class=" m-t-xs img-fluid" width="100px" src="{{asset('multimedia/tipo_equipo')}}/{{$equipo_show->tipoequipo->imagen}}"> <br>
						<strong>{{$equipo_show->marcas->nombre}} / {{$equipo_show->codigo_equipo}}</strong>
					</div>
					<div class="col-8">
						<p><strong for="">Usuario del Equipo:</strong> {{$equipo_show->usuario}} </p>
						<p><strong for="">Numero Serie:</strong> {{$equipo_show->numero_serie}}</p>
						<p><strong for="">Equipo en Soporte:</strong>@if($equipo_show->estado_soporte==1) Equipo No incluido en Soporte. @else Equipo incluido en Soporte. @endif</p>
					</div>
					<div class="col-12">
						<p><strong for="">Detalles de Hardware:</strong> <textarea class="form-control" rows="5" disabled="" style="height: auto;font-size:12px;">{{$equipo_show->descripcion_hardware}}</textarea></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{{-- Modal --}}
@endif
{{-- Modal Vista --}}
<div class="modal inmodal" id="modal_nota_venta" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceIn">


			<div class="modal-body">
				<div class="col-lg-12">
					<div class="tabs-container">
						<div class="tab-content">
							<div>
								<div class="panel-body">
									<div class="tile-body">
										<div class="ibox ">
											<div class="row">
												<div class="col-lg-8" align="left">
													<img  style="width: 50%;height:auto;background-size: contain;border-radius: 5px; padding: 10px;" name="foto"  src="{{ asset('/multimedia/empresa/')}}/{{$empresa->foto}}"  />
												</div>
												<div class="col-lg-4" align="right">
													<div class="form-control" align="center" style="color: grey;background-color: #def7e8; margin-bottom: 0px;border:none" >
														<b><h2>Nota de Venta</h2></b>
													</div>
												</div>
											</div>
											<div class="row" style=" margin-top: 10px;">
												<div class="col-lg-6" align="left"><b>Descripcion</b></div>
												<div class="col-lg-6" align="right"><b>Total</b></div>
											</div>
											<hr>
											<form action="{{ route('tickets.update',$tickets_agregado->id) }}"  enctype="multipart/form-data" method="post" id="formulario_precio" >
												@csrf
												@method('PATCH')
												<div class="row">
													<div class="col-lg-6" align="left">
														Soporte técnico<br>
														<b>Motivo:</b> {{$tickets_agregado->motivo->nombre}}<br>
														<b>Asunto:</b> {{$tickets_agregado->asunto}}<br>
														@if(isset($tickets_agregado->equipo))
														<b>Equipo en Soporte:</b> {{$equipo_show->marcas->nombre}} / {{$equipo_show->tipoequipo->nombre}} / {{$equipo_show->usuario}}
														@endif
													</div>

													<div class="col-lg-6" align="right">

														<div class="input-group" style="width:150px">
															<div class="input-group-prepend">
																@if(isset($tickets_agregado->precio))
																<div class="input-group-text" >{{$tickets_agregado->moneda}} </div>
																@else
																@foreach($moneda as $monedas)
																<select name="moneda" class="input-group-text">
																	<option value="{{$monedas->simbolo}}" @if($tickets_agregado->moneda==$monedas->simbolo) selected=""@endif> {{$monedas->simbolo}}</option>
																</select>
																@endforeach
																@endif
															</div>
															<input style="text-align: center;" type="text" class="form-control" autocomplete="off" name="precio"  required="" @if(isset($tickets_agregado->precio)) value="{{$tickets_agregado->precio}}" readonly="" @else value="80" @endif>
														</div>


													</div>
													<div class="col-lg-12 tile-footer" style="padding: 0px 20px;text-align: center;">
														<hr>
														<label>¿Desea Enviar correo de Notificación al cliente?</label>
														<input type="radio" name="email_envio" value="0" checked="">Si
														<input type="radio" name="email_envio" value="1">No<br>
													</div>
												</div>
											</form>
											<hr>
											<div align="right">
												<button class="btn btn-info" onclick="document.getElementById('formulario_precio').submit();">Notificar</button>
											</div>
										</div>
									</div>
								</div>
							</div>

							<div role="tabpanel" id="CpanelEdit" class="tab-pane">
								<div class="panel-body">
								</div>
							</div>
						</div>
					</div>
				</div>

			</div>
		</form>
	</div>
</div>
</div>

{{--Fin Modal vista --}}


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