@extends('menu.layout')

@section('img_title', 'nota_venta.svg')
@section('title', 'Nota Venta')
@section('atributo1', 'hidden')
@section('content')
<?php
use App\Hosting;
use App\Dominios;
use App\NotasPago;
use App\CertificadoSsl;
use App\SoporteTecnico;
use App\Licencia;
use App\TicketsAgregado;
?>
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12" >
			<div class="ibox ">
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
								<tr>
									<th>ID</th>
									<th>Nombre</th>
									<th>Nombre</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								@foreach($clientes as $cliente)
								<span hidden="">
									{{$soporte=SoporteTecnico::where('cliente',$cliente->id)->where('estado','0')->where('estado_anulado','0')->where('estado_pagado','0')->get()}}
									{{$soporte_count=$soporte->count()}}

									{{$hostings=Hosting::where('cliente',$cliente->id)->where('estado','0')->where('estado_anulado','0')->where('estado_pagado','0')->get()}}
									{{$hosting_count=$hostings->count()}}

									{{$dominios=Dominios::where('cliente',$cliente->id)->where('estado','0')->where('estado_anulado','0')->where('estado_pagado','0')->get()}}
									{{$dominio_count=$dominios->count()}}

									{{$certificado_ssls=CertificadoSsl::where('cliente',$cliente->id)->where('estado','0')->where('estado_anulado','0')->where('estado_pagado','0')->get()}}
									{{$certificado_ssl_count=$certificado_ssls->count()}}

									{{$licencia=Licencia::where('cliente',$cliente->id)->where('estado','0')->where('estado_anulado','0')->where('estado_pagado','0')->get()}}
									{{$licencia_count=$licencia->count()}}


									{{$ticket=TicketsAgregado::where('cliente',$cliente->id)->where('estado_enviado_notificacion',1)->where('estado_pagado','0')->get()}}
									{{$ticket_count=$ticket->count()}}
									{{$suma_produc=$soporte_count+$hosting_count+$dominio_count+$certificado_ssl_count+$licencia_count}}
									{{$suma_todos=$soporte_count+$hosting_count+$dominio_count+$certificado_ssl_count+$licencia_count+$ticket_count}}
								</span>
								<tr>
									<td>{{$cliente->id}}</td>
									<td>{{$cliente->name}} {{$cliente->last_name}}</td>
									<td>{{$cliente->email}} </td>

									<td>
										<button type="button" class="btn btn-primary"  @if($suma_todos==0) disabled="" @else  data-toggle="modal" data-target="#cliente_ver{{$cliente->id}}" @endif>Ver</button>
										<button type="button" class="btn " data-toggle="modal" data-target="#pdf{{$cliente->id}}"><img src="{{asset('multimedia/pdf.png')}}" width="30px"></button>

									</td>
								</tr>
								@endforeach
							</tbody>
						</table>
						@foreach($clientes as $cliente)
						<span hidden="">
							{{$soporte=SoporteTecnico::where('cliente',$cliente->id)->where('estado','0')->where('estado_anulado','0')->where('estado_pagado','0')->get()}}
							{{$soporte_count=$soporte->count()}}

							{{$hostings=Hosting::where('cliente',$cliente->id)->where('estado','0')->where('estado_anulado','0')->where('estado_pagado','0')->get()}}
							{{$hosting_count=$hostings->count()}}

							{{$dominios=Dominios::where('cliente',$cliente->id)->where('estado','0')->where('estado_anulado','0')->where('estado_pagado','0')->get()}}
							{{$dominio_count=$dominios->count()}}

							{{$certificado_ssls=CertificadoSsl::where('cliente',$cliente->id)->where('estado','0')->where('estado_anulado','0')->where('estado_pagado','0')->get()}}
							{{$certificado_ssl_count=$certificado_ssls->count()}}
							{{$licencia=Licencia::where('cliente',$cliente->id)->where('estado','0')->where('estado_anulado','0')->where('estado_pagado','0')->get()}}
							{{$licencia_count=$licencia->count()}}

							{{$ticket=TicketsAgregado::where('cliente',$cliente->id)->where('estado_enviado_notificacion',1)->where('estado_pagado','0')->get()}}
							{{$ticket_count=$ticket->count()}}

							{{$ticket_pagado=TicketsAgregado::where('cliente',$cliente->id)->where('estado_enviado_notificacion',1)->where('estado_pagado','1')->get()}}
							{{$ticket_pagado_count=$ticket_pagado->count()}}

							{{$suma_produc=$soporte_count+$hosting_count+$dominio_count+$certificado_ssl_count+$licencia_count}}
							{{$suma_todos=$soporte_count+$hosting_count+$dominio_count+$certificado_ssl_count+$licencia_count+$ticket_count}}
						</span>
						<tr>

							{{-- Modal lista pdf --}}
							<div class="modal inmodal" id="pdf{{$cliente->id}}" tabindex="-1" role="dialog" aria-hidden="true">
								<div class="modal-dialog modal-lg">
									<div class="modal-content animated bounceIn">
										<div class="panel-body">
											<div class="col-lg-12">
												<div class="tabs-container">
													<ul class="nav nav-tabs" role="tablist">
														<li><a class="nav-link active" data-toggle="tab" href="#descarga{{$cliente->id}}-1">N.Venta Productos</a></li>
														<li><a  class="nav-link"  disa data-toggle="tab" href="#descarga{{$cliente->id}}-2">N.Venta Tickets</a></li>
													</ul>
													<div class="tab-content">
														<div role="tabpanel" id="descarga{{$cliente->id}}-1" class="tab-pane active">
															<div class="panel-body">
																<div class="table-responsive">
																	<table class="table table-striped table-bordered table-hover dataTables-example" >
																		<thead>
																			<tr>
																				<th>Item</th>
																				<th>Codigo PDF</th>
																				<th>Hora Fecha</th>
																				<th>Archivo</th>
																			</tr>
																		</thead>
																		<tbody>
																			<span hidden="">
																				{{$notas_pago=NotasPago::where('cliente',$cliente->id)->where('estado','0')->get()}}
																				{{$i=1}}
																			</span>
																			@foreach($notas_pago as $notas_pagos)
																			<tr>
																				<td>{{$i++}}</td>
																				<td>{{$notas_pagos->codigo_nota}}</td>
																				<td>{{$notas_pagos->created_at}}</td>
																				<td align="center">

																					<a href="{{ asset('multimedia/notas_pago')}}/{{$notas_pagos->nombre_archivo}}.pdf" download="{{$notas_pagos->nombre_archivo}}.pdf"><img src="{{asset('multimedia/descarga.png')}}" width="20px"></a>
																				</td>
																			</tr>
																			@endforeach
																		</tbody>
																	</table>
																</div>
															</div>
														</div>
														<div role="tabpanel" id="descarga{{$cliente->id}}-2" class="tab-pane">
															<div class="panel-body">

																<div class="row">
																	<div class="col-lg-8" align="left">
																		<img  style="width: 50%;height:auto;background-size: contain;border-radius: 5px; padding: 10px;" name="foto"  src="{{ asset('/multimedia/empresa/')}}/{{$empresa->foto}}"  />
																	</div>
																	<div class="col-lg-4" align="right">
																		<div class="form-control" align="center" style="color: grey;background-color: #def7e8; margin-bottom: 0px;border:none" >
																			<b><h2>Nota de Venta</h2> pagado</b>

																		</div>
																	</div>
																</div>
																<div class="table-responsive">
																	<table class="table table-striped table-bordered table-hover dataTables-example" >
																		<thead>
																			<tr>
																				<th align="left">Descripcion</th>
																				<th style="text-align: right;">Total</th>
																			</tr>
																		</thead>
																		<tbody>
																			<form action="{{route('nota_venta.update',$cliente->id)}}"  name="t{{$cliente->id}}"method="POST" enctype="multipart/form-data" >
																				@csrf
																				@method('PATCH')
																				{{-- Soporte  --}}
																				@foreach($ticket_pagado as $tickets_agregado)
																				<tr>
																					<td align="left">
																						Soporte Técnico / <b>{{$tickets_agregado->codigo_ticket}}</b> <br>
																						<b>Motivo:</b> {{$tickets_agregado->motivo->nombre}}<br>
																						<b>Asunto:</b> {{$tickets_agregado->asunto}}<br>
																						@if(isset($tickets_agregado->equipo))
																						<b>Equipo en Soporte:</b>{{$tickets_agregado->equipos->marcas->nombre}} / {{$tickets_agregado->equipos->tipoequipo->nombre}} / {{$tickets_agregado->equipos->usuario}}
																						@endif
																					</td>
																					<td style="text-align: right;">{{$tickets_agregado->moneda}}{{$tickets_agregado->precio}}</td>
																				</tr>
																				@endforeach
																				{{--Fin Soporte  --}}
																			</form>
																		</tbody>
																	</table>
																</div>
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
						{{--Fin Modal lista pdf --}}
						{{-- Modal Vista --}}
						<div class="modal inmodal" id="cliente_ver{{$cliente->id}}" tabindex="-1" role="dialog" aria-hidden="true">
							<div class="modal-dialog modal-lg">
								<div class="modal-content animated bounceIn">
									<div class="panel-body">
										<div class="row">
											<div class="col-lg-12">
												<div class="tabs-container">
													<ul class="nav nav-tabs" role="tablist">

														@if($suma_produc>0)
														<li><a class="nav-link active" data-toggle="tab" href="#tab{{$cliente->id}}-1">N.Venta Productos</a></li>
														@endif
														@if($ticket_count>0)
														<li><a  class="nav-link @if($suma_produc==0) active @endif"  disa data-toggle="tab" href="#tab{{$cliente->id}}-2">N.Venta Tickets</a></li>
														@endif
													</ul>
													<div class="tab-content">
														<div role="tabpanel" id="tab{{$cliente->id}}-1" class="tab-pane @if($suma_produc>0) active @endif">
															<div class="panel-body">

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
																<table class="table table-hover" >
																	<thead>
																		<tr>
																			<th><input type="checkbox" onclick="seleccionar_todo_{{$cliente->id}}()" id="checkbox{{$cliente->id}}" ></th>
																			<th>Descripcion</th>
																			<th></th>
																			<th style="text-align: right;">Total</th>
																		</tr>
																	</thead>
																	<tbody>
																		<form action="{{route('nota_venta.update',$cliente->id)}}"  name="f{{$cliente->id}}"method="POST" enctype="multipart/form-data" >
																			@csrf
																			@method('PATCH')
																			{{-- Soporte  --}}
																			<tr  @if($soporte_count<1) hidden="" @endif ><td colspan="4" align="center"><b>Soporte</b></td></tr>

																				@foreach($soporte as $soportes)
																				<tr>
																					<td><input type="checkbox" name="soporte[]" value="{{$soportes->id}}"> </td>
																					<td><b>Plan Soporte:</b> {{$soportes->plansoporte->nombre}} - <b>Valido Por:</b> {{$soportes->anos}} Mes(es) - <b>FechaVencimiento:</b>{{$soportes->fecha_vencimiento}}</td>
																					<td width="80px"></td>
																					<td style="text-align: right;">{{$soportes->moneda}}{{$soportes->precio}}</td>
																				</tr>
																				@endforeach
																				{{--Fin Soporte  --}}
																				{{-- Hosting  --}}
																				<tr  @if($hosting_count<1) hidden="" @endif ><td colspan="4" align="center"><b>Hosting</b></td></tr>

																					@foreach($hostings as $hostingss)
																					<tr>
																						<td><input type="checkbox" name="hosting[]" value="{{$hostingss->id}}"> </td>
																						<td><b>Plan Hosting:</b> {{$hostingss->plan_hostings->nombre}} - <b>Dominio:</b> {{$hostingss->dominio}} - <b>Años:</b> {{$hostingss->anos}} - <b>FechaVencimiento:</b> {{$hostingss->fecha_vencimiento}}</td>
																						<td width="80px"></td>
																						<td style="text-align: right;">{{$hostingss->moneda}}{{$hostingss->precio}}</td>
																					</tr>
																					@endforeach
																					{{--Fin Hosting  --}}

																					{{--Dominio  --}}
																					<tr  @if($dominio_count<1) hidden="" @endif ><td colspan="4" align="center"><b>Dominios</b></td></tr>
																						@foreach($dominios as $dominioss)
																						<tr >
																							<td><input type="checkbox" name="dominio[]" value="{{$dominioss->id}}"> </td>
																							<td><b>Dominio:</b> {{$dominioss->nombre_dominio}} - <b>Años:</b> {{$dominioss->anos}} - <b>FechaVencimiento:</b> {{$dominioss->fecha_vencimiento}}</td>
																							<td width="80px"></td>
																							<td style="text-align: right;">{{$dominioss->moneda}}{{$dominioss->precio}}</td>
																						</tr>
																						@endforeach
																						{{--FinDominio  --}}

																						{{-- certificado_ssls --}}
																						<tr  @if($certificado_ssl_count<1) hidden="" @endif ><td colspan="4" align="center"><b>Certificados SSL</b></td></tr>
																							@foreach($certificado_ssls as $certificado_ssl)
																							<tr >
																								<td><input type="checkbox" name="certificadossl[]" value="{{$certificado_ssl->id}}"> </td>
																								<td><b>Plan:</b> {{$certificado_ssl->planes_ssl->nombre}} - <b>Dominio:</b> {{$certificado_ssl->nombre_dominio}} - <b>Años:</b> {{$certificado_ssl->anos}} - <b>FechaVencimiento:</b> {{$certificado_ssl->fecha_vencimiento}}</td>
																								<td width="80px"></td>
																								<td style="text-align: right;">{{$certificado_ssl->moneda}}{{$certificado_ssl->precio}}</td>
																							</tr>
																							@endforeach
																							{{--FIN certificado_ssls --}}

																							{{-- Licencia --}}
																							<tr  @if($licencia_count<1) hidden="" @endif ><td colspan="4" align="center"><b>Licencias</b></td></tr>
																								@foreach($licencia as $licencias)
																								<tr >
																									<td><input type="checkbox" name="licencia[]" value="{{$licencias->id}}"> </td>
																									<td><b>Categoria:</b> {{$licencias->categoria->nombre}} - <b>Equipo:</b> {{$licencias->equipos->marcas->nombre}} /  {{$licencias->equipos->tipoequipo->nombre}} /{{$licencias->equipos->usuario}} - <b>Años:</b> {{$licencias->anos}} - <b>FechaVencimiento:</b> {{$licencias->fecha_vencimiento}}</td>
																									<td width="80px"></td>
																									<td style="text-align: right;">{{$licencias->moneda}}{{$licencias->precio}}</td>
																								</tr>
																								@endforeach
																								<tr>
																									<td colspan="4" align="right"><b>Total:</b> S/.{{$hostings->sum('precio')+$dominios->sum('precio')+$certificado_ssls->sum('precio')+$soporte->sum('precio')+$licencia->sum('precio')}}</td>
																								</tr>
																								<tr>
																									<td colspan="4">
																										<div class="col-lg-12 tile-footer" style="padding: 0px 20px;text-align: center;">
																											<label>¿Desea Enviar correo de Notificación al cliente?</label>
																											<input type="radio" name="email_envio" value="0" checked="">Si
																											<input type="radio" name="email_envio" value="1">No<br><input name="boton_venta" type="hidden" value="productos"><input  class="btn btn-success" type="submit" value="Guardar"></td>
																										</div>
																									</tr>
																									{{--FIN Licencia --}}
																								</form>
																							</tbody>
																						</table>
																					</div>
																				</div>
																				<div role="tabpanel" id="tab{{$cliente->id}}-2" class="tab-pane @if($suma_produc==0) active @endif">
																					<div class="panel-body">
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
																						<table class="table table-hover" >
																							<thead>
																								<tr>
																									<th style="width:10px"><input type="checkbox" onclick="ticket_seleccionar_todo_{{$cliente->id}}()" id="ticket_checkbox{{$cliente->id}}" ></th>
																									<th align="left">Descripcion</th>
																									<th></th>
																									<th style="text-align: right;">Total</th>
																								</tr>
																							</thead>
																							<tbody>
																								<form action="{{route('nota_venta.update',$cliente->id)}}"  name="t{{$cliente->id}}"method="POST" enctype="multipart/form-data" >
																									@csrf
																									@method('PATCH')
																									{{-- Soporte  --}}

																									<tr  @if($ticket_count<1) hidden="" @endif ><td colspan="4" align="center"><b>Tickets</b></td></tr>

																										@foreach($ticket as $tickets_agregado)
																										<tr>
																											<td><input type="checkbox" name="ticket[]" value="{{$tickets_agregado->id}}"> </td>
																											<td align="left">
																												Soporte Técnico / <b>{{$tickets_agregado->codigo_ticket}}</b> <br>
																												<b>Motivo:</b> {{$tickets_agregado->motivo->nombre}}<br>
																												<b>Asunto:</b> {{$tickets_agregado->asunto}}<br>
																												@if(isset($tickets_agregado->equipo))
																												<b>Equipo en Soporte:</b>{{$tickets_agregado->equipos->marcas->nombre}} / {{$tickets_agregado->equipos->tipoequipo->nombre}} / {{$tickets_agregado->equipos->usuario}}
																												@endif
																											</td>
																											<td width="80px"></td>
																											<td style="text-align: right;">{{$tickets_agregado->moneda}}{{$tickets_agregado->precio}}</td>
																										</tr>
																										@endforeach
																										<tr>
																											<td colspan="4" align="right"><b>Total:</b> S/.{{$ticket->sum('precio')}}</td>
																										</tr>
																										<tr>
																											<td colspan="4">
																											{{-- 	<div class="col-lg-12 tile-footer" style="padding: 0px 20px;text-align: center;">
																													<label>¿Desea Enviar correo de Notificación al cliente?</label>
																													<input type="radio" name="email_envio" value="0" checked="">Si
																													<input type="radio" name="email_envio" value="1">No<br> --}}
																													<input name="boton_venta" type="hidden" value="ticket"><input class="btn btn-success" type="submit" value="Guardar">
																												{{-- </div> --}}
																											</td>
																										</tr>

																										{{--Fin Soporte  --}}
																									</form>
																								</tbody>
																							</table>

																						</div>
																					</div>
																				</div>


																			</div>
																		</div>

																	</div>

																</div>
															</div>
														</div>
														<script type="text/javascript">
															function seleccionar_todo_{{$cliente->id}}(){
																var b=document.getElementById("checkbox{{$cliente->id}}");
																b.removeAttribute('onclick');
																b.setAttribute("onclick", "deseleccionar_todo_{{$cliente->id}}()");

																for (i=0;i<document.f{{$cliente->id}}.elements.length;i++)
																	if(document.f{{$cliente->id}}.elements[i].type == "checkbox")
																		document.f{{$cliente->id}}.elements[i].checked=1
																}
																function deseleccionar_todo_{{$cliente->id}}(){
																	var b=document.getElementById("checkbox{{$cliente->id}}");
																	b.removeAttribute('onclick');
																	b.setAttribute("onclick", "seleccionar_todo_{{$cliente->id}}()");
																	for (i=0;i<document.f{{$cliente->id}}.elements.length;i++)
																		if(document.f{{$cliente->id}}.elements[i].type == "checkbox")
																			document.f{{$cliente->id}}.elements[i].checked=0
																	}

																</script>
																<script>
																	function ticket_seleccionar_todo_{{$cliente->id}}(){
																		var b=document.getElementById("ticket_checkbox{{$cliente->id}}");
																		b.removeAttribute('onclick');
																		b.setAttribute("onclick", "ticket_deseleccionar_todo_{{$cliente->id}}()");

																		for (i=0;i<document.t{{$cliente->id}}.elements.length;i++)
																			if(document.t{{$cliente->id}}.elements[i].type == "checkbox")
																				document.t{{$cliente->id}}.elements[i].checked=1
																		}
																		function ticket_deseleccionar_todo_{{$cliente->id}}(){
																			var b=document.getElementById("ticket_checkbox{{$cliente->id}}");
																			b.removeAttribute('onclick');
																			b.setAttribute("onclick", "ticket_seleccionar_todo_{{$cliente->id}}()");
																			for (i=0;i<document.t{{$cliente->id}}.elements.length;i++)
																				if(document.t{{$cliente->id}}.elements[i].type == "checkbox")
																					document.t{{$cliente->id}}.elements[i].checked=0
																			}
																		</script>
																		{{--Fin Modal vista --}}
																	</div>
																	@endforeach
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
											@endsection