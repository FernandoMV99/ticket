@extends('menu.layout')@section('title', 'Hosting')
@section('img_title', 'hosting.svg')

@section('value_accion1', 'Agregar')
@section('data-toggle1', 'modal')
@section('data-target1', '#AgregarHosting')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php
use Carbon\Carbon;
use App\HostingCorreos;
?>
{{-- <div > Click aqui</div> --}}
<!-- Modal Agregar Motivos-->
<div class="modal inmodal" id="AgregarHosting" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceIn">
			<div class="modal-header" style="padding: 10px"><h4 class="modal-title">Agregar Hosting</h4></div>
			<form action ="{{route('hosting.store')}}" method="POST" enctype="multipart/form-data" >
				@csrf
				<div class="modal-body">
					<div class="col-lg-12">
						<div class="tabs-container">

							<ul class="nav nav-tabs" role="tablist">
								<li><a class="nav-link active show" data-toggle="tab" href="#tab-1" style="font-size:15px;">Datos Hosting</a></li>
								<li><a class="nav-link" data-toggle="tab" href="#tab-2" style="color: #ff7600;font-size:15px;font-style: italic;">CPanel</a></li>
							</ul>

							<div class="tab-content">

								<div role="tabpanel" id="tab-1" class="tab-pane active show">
									<div class="panel-body">
										<div class="tile-body">
											<div class="form-row">
												<div class="form-group col-md-6">
													<label>Nombre del Cliente o Empresa:</label>
													<select name="cliente"  class="form-control">
														@foreach($clientes as $cliente)
														<option value="{{$cliente->id}}">{{$cliente->name}} {{$cliente->last_name}}</option>
														@endforeach
													</select>
												</div>

												<div class="form-group col-md-6">
													<label>Plan Hosting:</label>
													<select class="form-control" name="plan_hosting" required="">
														@foreach($plan_hosting as $plan_hostings)
														<option value="{{$plan_hostings->id}}">{{$plan_hostings->nombre}}</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="form-row">
												<div class="form-group col-md-6">
													<label>Fecha de inicio:</label>
													<input type="date" class="form-control" name="fecha_inicio" required="">
												</div>
												<div class="form-group col-md-6">
													<label >Duración del contrato:</label>
													<select class="form-control" name="fecha_vencimiento" required="">
														<option value="1">1 año</option>
														<option value="2">2 años</option>
														<option value="3">3 años</option>
														<option value="4">4 años</option>
														<option value="5">5 años</option>
													</select>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div role="tabpanel" id="tab-2" class="tab-pane">
									<div class="panel-body">
										<div class="form-group row">
											<label class="col-sm-2" for="cpanel_domain_name">Dominio:</label>
											<div class="col-sm-10 input-group">
												<div class="input-group-prepend">
													<span class="input-group-text">www.</span>
												</div>
												<input list="browsers" class="form-control" name="dominio" autocomplete="off" required="required">
												<datalist id="browsers">
													@foreach($dominios as $dominio)<option value="{{$dominio->nombre_dominio}}">@endforeach
													</datalist>
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-2">Usuario:</label>
												<div class="col-sm-10">
													<input type="text" class="form-control"  name="cpanel_usuario" value="root" >
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-2">Contraseña:</label>
												<div class="col-sm-10">
													<input type="text" class="form-control"  name="cpanel_password">
												</div>
											</div>
											<div class="form-group row">
												<label class="col-sm-2">IP Pública:</label>
												<div class="col-sm-10">
													<input type="text" class="form-control"  name="cpanel_ip_publica">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tile-footer" style="padding: 0px 20px;text-align: center;">
							<label>¿Desea Enviar correo de Notificación al cliente?</label>
							<input type="radio" name="email_envio" value="0" checked="">Si
							<input type="radio" name="email_envio" value="1">No<br>
							<input class="btn btn-primary btn-lg" type="submit" value="Registrar">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
	<!-- Fin Modal Agregar Motivos-->

	<div class="wrapper wrapper-content animated fadeInRight">
		<div class="row">
			<div class="col-lg-12" >
				<div class="ibox ">
					<div class="ibox-content">
						<div class="table-responsive">
							<table class="table table-striped table-bordered table-hover dataTables-example" >
								<thead>
									<tr>
										<th>Item</th>
										<th>Cliente</th>
										<th>Dominio</th>
										<th>Plan Hosting</th>
										<th>Años</th>
										<th>Fecha Vencimiento</th>
										<th>Dias Faltantes</th>
										<th>Precio</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@foreach($hosting as $hostings)
									<tr>
										<td>{{$hostings->id}}
											@if($hostings->estado==1 & $hostings->estado_anulado==1)
											<span class="label label-danger">Anulado</span>
											@elseif($hostings->estado==1 & $hostings->estado_anulado==0)
											<span class="label label-warning">Inactivo</span>
											@elseif($hostings->estado==0 & $hostings->estado_anulado==0)
											<span class="label label-info">Activo</span>
										@endif</td>
										<td>{{$hostings->clientes->name}} {{$hostings->clientes->last_name}}</td>
										<td>{{$hostings->dominio}}</td>
										<td>{{$hostings->plan_hostings->nombre}}</td>
										<td>{{$hostings->anos}} Año(s)</td>
										<td>{{$hostings->fecha_vencimiento}}</td>
										<td>
											<span hidden="">
												{{$correos=HostingCorreos::where('hosting_id',$hostings->id)->where('estado_borrado','0')->get()}}
												{{$date = $hostings->fecha_vencimiento."+ 1 days"}}
												{{$datework = Carbon::createFromDate($date)}}
												{{$now = Carbon::now()}}
												@if($datework>$now)
												{{$testdate = $now->diffInDays($datework)}}
												@else
												{{$testdate = '-'.$now->diffInDays($datework)}}
												@endif
											</span>
											@if($testdate<31 & $testdate>15)<strong style="color: #00ad75">{{$testdate}} Días</strong>
												@elseif($testdate<16 & $testdate>7)<strong style="color: #c17312b8">{{$testdate}} Días</strong>
													@elseif($testdate<8)<strong style="color: #ff1515f2">{{$testdate}} Días</strong>
														@else <strong>{{$testdate}} Días</strong>
														@endif
													</td>
													<td>{{$hostings->moneda}}{{$hostings->precio}}</td>
													<!-- Formulario Anular-->
													<form action="{{ route('hosting.update',$hostings->id) }}"  enctype="multipart/form-data" method="post"  name="anular_registro{{$hostings->id}}">
														@csrf
														@method('PATCH')
														<input type="hidden" name="dominio" value="{{$hostings->dominio}}">
														<input type="hidden" name="boton" value="Anulado">
													</form>
													<!-- Formulario Anular-->
													<td>
														@if($testdate<30 & $hostings->estado_anulado==0)
															<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#Renovar{{$hostings->id}}">Renovar</button>
															@else
															<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#HostingEdit{{$hostings->id}}">Ver</button>
														@endif</td>

														{{--  --}}
														<div class="modal inmodal" id="Renovar{{$hostings->id}}" tabindex="-1" role="dialog" aria-hidden="true">
															<div class="modal-dialog modal-lg">
																<div class="modal-content animated bounceIn">
																	<div class="modal-header" style="padding: 10px">
																		<h4 class="modal-title">Renovar Hosting</h4>
																		@if($hostings->estado_anulado=='0') <button class="demo4 a{{$hostings->id}}" style="background:#ff000000;border: 0px;"><img class="input-group-text" style="background:#ff000000;border: 0px;width: 50px" src="{{ asset('/multimedia/anulado.svg')}}" /></button> @endif

																	</div>

																	<form action="{{ route('hosting.update',$hostings->id) }}"  enctype="multipart/form-data" method="post">
																		@csrf
																		@method('PATCH')
																		<div class="modal-body">
																			<div class="col-lg-12">
																				<div class="tabs-container">
																					<div class="tab-content">
																						<div role="tabpanel" id="renovar{{$hostings->id}}" class="tab-pane active show">
																							<div class="panel-body">
																								<div class="tile-body">
																									<div class="form-row">

																										<div class="form-group col-md-4">
																											<label>Nombre del Cliente o Empresa:</label>
																											<input type="text" class="form-control" disabled="" value="{{$hostings->clientes->name}} {{$hostings->clientes->last_name}}">
																										</div>
																										<div class="form-group col-md-4">
																											<label>Fecha compra:</label>
																											<input type="text" class="form-control" readonly="" name="fecha_inicio" value="{{$hostings->fecha_inicio}}">
																										</div>	<div class="form-group col-md-4">
																											<label>Fecha Vencimiento:</label>
																											<input type="text" class="form-control" readonly="" name="fecha_inicio" value="{{$hostings->fecha_vencimiento}}">
																										</div>

																										<div class="form-group col-md-6">
																											<label>Plan Hosting:</label>
																											<select class="form-control" name="plan_hosting" required="">
																												@foreach($plan_hosting as $plan_hostings)
																												<option value="{{$plan_hostings->id}}" @if($plan_hostings->id==$hostings->plan_hosting) selected @endif >{{$plan_hostings->nombre}}</option>
																												@endforeach
																											</select>
																										</div>

																										<div class="form-group col-md-6">
																											<label >Duración del contrato:</label>
																											<select class="form-control" name="fecha_vencimiento" required="">
																												<option value="1" >1 año</option>
																												<option value="2" >2 años</option>
																												<option value="3" >3 años</option>
																												<option value="4" >4 años</option>
																												<option value="5" >5 años</option>
																											</select>
																										</div>
																									</div>
																								</div>
																							</div>
																						</div>
																					</div>
																				</div>
																			</div>
																			<div class="tile-footer" style="padding: 0px 20px;text-align: center;">
																				<input class="btn btn-primary btn-lg" type="submit" value="Renovar" name="boton" @if($hostings->estado_anulado=='1') disabled="" @endif>
																			</div>
																		</div>
																	</form>
																</div>
															</div>
														</div>
														{{-- Modal renovar --}}

													</tr>

													@endforeach
												</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>


					@foreach($hosting as $hostings)
					{{-- modal actulizar --}}
					<div class="modal inmodal" id="HostingEdit{{$hostings->id}}" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content animated bounceIn">
								<div class="modal-header" style="padding: 10px">
									<h4 class="modal-title">Editar Hosting</h4>
									@if($hostings->estado_anulado=='0') <button class="demo4 a{{$hostings->id}}" style="background:#ff000000;border: 0px;"><img class="input-group-text" style="background:#ff000000;border: 0px;width: 50px" src="{{ asset('/multimedia/anulado.svg')}}" /></button> @endif

								</div>


								<div class="modal-body">
									<div class="col-lg-12">
										<div class="tabs-container">

											<ul class="nav nav-tabs" role="tablist">
												<li><a class="nav-link active show" data-toggle="tab" href="#HostingdatosEdit{{$hostings->id}}" style="font-size:15px;">Datos Hosting</a></li>
												<li><a class="nav-link" data-toggle="tab" href="#CpanelEdit{{$hostings->id}}" style="color: #ff7600;font-size:15px;font-style: italic;">CPanel</a></li>
												<li><a class="nav-link" data-toggle="tab" href="#correos{{$hostings->id}}" style="font-size:15px;">Correos Corporativos</a></li>
												<li  @if($hostings->estado_anulado=='1')hidden="hidden" @endif><a class="nav-link" data-toggle="tab" href="#crearcorreos{{$hostings->id}}" style="font-size:15px;">Crear Correos</a></li>
											</ul>
											<div class="tab-content">
												<div role="tabpanel" id="HostingdatosEdit{{$hostings->id}}" class="tab-pane active show">
													<div class="panel-body">
														<div class="tile-body">
															<div class="form-row">
																<div class="form-group col-md-6">
																	<form action="{{ route('hosting.update',$hostings->id) }}"  enctype="multipart/form-data" method="post">
																		@csrf
																		@method('PATCH')
																		<label>Nombre del Cliente o Empresa:</label>
																		<input type="text" class="form-control" disabled="" value="{{$hostings->clientes->name}} {{$hostings->clientes->last_name}}">
																	</div>

																	<div class="form-group col-md-6">
																		<label>Plan Hosting:</label>
																		<select class="form-control" name="plan_hosting" required=""  @if($hostings->estado_anulado=='1') disabled="" @endif>
																			@foreach($plan_hosting as $plan_hostings)
																			<option value="{{$plan_hostings->id}}" @if($plan_hostings->id==$hostings->plan_hosting) selected @endif >{{$plan_hostings->nombre}}</option>
																			@endforeach
																		</select>
																	</div>
																</div>
																<div class="form-row">
																	<div class="form-group col-md-6">
																		<label>Fecha de inicio:</label>
																		<input type="date" class="form-control" readonly="" name="fecha_inicio" value="{{$hostings->fecha_inicio}}">
																	</div>
																	<div class="form-group col-md-6">
																		<label >Duración del contrato:</label>
																		<select class="form-control" name="fecha_vencimiento" required="" @if($hostings->estado_anulado=='1') disabled="" @endif>
																			<option value="1" @if('1'==$hostings->anos) selected @endif >1 año</option>
																			<option value="2" @if('2'==$hostings->anos) selected @endif >2 años</option>
																			<option value="3" @if('3'==$hostings->anos) selected @endif >3 años</option>
																			<option value="4" @if('4'==$hostings->anos) selected @endif >4 años</option>
																			<option value="5" @if('5'==$hostings->anos) selected @endif >5 años</option>
																		</select>
																	</div>
																</div>
																<div class="form-row">
																	<div class="form-group col-md-12">
																		<label>Descripcion:</label>
																		<textarea name="" class="form-control" disabled="" rows="5" >{{$hostings->plan_hostings->descripcion}}</textarea>
																	</div>
																</div>
																<div class="tile-footer" style="padding: 0px 20px;text-align: center;">
																	<input class="btn btn-primary btn-lg" type="submit" value="Actualizar" name="boton" @if($hostings->estado_anulado=='1')hidden="hidden" @endif>
																</div>
															</div>
														</div>
													</div>

													<div role="tabpanel" id="CpanelEdit{{$hostings->id}}" class="tab-pane">
														<div class="panel-body">
															<div class="form-group row">
																<label class="col-sm-2" for="cpanel_domain_name">Dominio:</label>
																<div class="col-sm-10 input-group">

																	<input class="form-control" disabled value="http://{{$hostings->dominio}}">
																	<div class="input-group-prepend">
																		<a href="https://{{$hostings->dominio}}" target="_blank"><img class="input-group-text" style="width: 35px;height: auto;padding-left: 6px;padding-right: 6px;" src="{{ asset('/multimedia/web.svg')}}" /></a>
																	</div>
																</div>
															</div>
															<div class="form-group row">
																<label class="col-sm-2">Usuario:</label>
																<div class="col-sm-10">
																	<input type="text" class="form-control"  @if($hostings->estado_anulado=='1') disabled="" @endif name="cpanel_usuario" value="{{$hostings->cpanel_usuario}}">
																</div>
															</div>
															<div class="form-group row">
																<label class="col-sm-2">Contraseña:</label>
																<div class="col-sm-10">
																	<input type="text" class="form-control"  @if($hostings->estado_anulado=='1') disabled="" @endif name="cpanel_password" value="{{$hostings->cpanel_password}}">
																</div>
															</div>
															<div class="form-group row">
																<label class="col-sm-2">IP Pública:</label>
																<div class="col-sm-10">
																	<input type="text" class="form-control"  @if($hostings->estado_anulado=='1') disabled="" @endif name="cpanel_ip_publica" value="{{$hostings->cpanel_ip_publica}}">
																</div>
															</div>
															<div class="tile-footer" style="padding: 0px 20px;text-align: center;">
																<input class="btn btn-primary btn-lg" type="submit" value="Actualizar" name="boton" @if($hostings->estado_anulado=='1')hidden="hidden" @endif>
															</div>
														</div>
													</div>
												</form>
												{{-- Correos --}}
												<div role="tabpanel" id="correos{{$hostings->id}}" class="tab-pane">
													<div class="panel-body" style="padding:0 5px">
														<span hidden="">
															{{$correos=HostingCorreos::where('hosting_id',$hostings->id)->get()}}
															{{$i=1}}
														</span>
														<div class="table-responsive">
															<table class="table table-striped table-bordered table-hover dataTables-example" >
																<thead>
																	<th>Item</th>
																	<th>Correo</th>
																	<th>Contraseña</th>
																	<th>S.Entrante</th>
																	<th>P.IMAP/P.POP3</th>
																	<th>S.Salida</th>
																	<th>P.SMTP</th>
																</thead>
																<tbody>
																	@foreach($correos as $correo)
																	<tr data-toggle="modal" @if($correo->estado_borrado==0 )data-target="#editar_correo{{$correo->id}}" @endif  id="correo_vista{{$correo->id}}">
																		<td>@if($correo->estado_borrado==1 )<span style="font-size: 8px;" class="label label-danger float-right btn-xs">Borrado</span>@else {{$i++}} @endif</td>
																		<td width="200px"><span>{{$correo->correo}}</span><input  hidden=""  type="text" value=" {{$correo->correo}}" class="form-control"></td>
																		<td>{{$correo->contrasena}}</td>
																		<td>{{$correo->servidor_entrante}}</td>
																		<td>{{$correo->servidor_entrante_imap}} / {{$correo->servidor_entrante_pop}}</td>
																		<td>{{$correo->servidor_salida}}</td>
																		<td>{{$correo->servidor_salida_smptp}}</td>
																		<!-- Button trigger modal -->

																	</tr>


																	@endforeach
																</tbody>

															</table>
														</div>
													</div>
												</div>
												{{-- Fin Cooreos --}}
												{{--  crearCorreos --}}

												<div role="tabpanel" id="crearcorreos{{$hostings->id}}" class="tab-pane">
													<div class="panel-body">
														<form action="{{ route('hosting_correos.store') }}" id="form" enctype="multipart/form-data" method="post" class="wizard-big">
															@csrf
															<input hidden="" name="hosting_id" required="required" value="{{$hostings->id}}" type="hidden" class="form-control" >
															<div id="listas{{$hostings->id}}">
																<div class="form-row">
																	<div class="col-md-1">
																		<label>Correo:</label>
																	</div>
																	<div class="form-group col-md-5">
																		<div class="input-group">
																			<input name="email[]" onkeyup="this.value=Numeros(this.value)"  required="required" value="" type="text" class="form-control" >
																			<div class="input-group-prepend"><span style="font-size: 12px" class="input-group-text">&#64;{{$dominio_para_correo=substr($hostings->dominio, 4)}}</span></div>
																		</div>
																	</div>

																	<div class="col-md-2">
																		<label>Contraseña:</label>
																	</div>
																	<div class="form-group col-md-3">
																		<input name="password[]"  required="required" type="text" class="form-control" >
																	</div>

																	<button style="display: inline;background: none;padding-top: 0px;height: 38px;" class="btn" type="button" id="add_field{{$hostings->id}}" >
																		<img src="{{asset('multimedia/agregar.png')}}" width="20px">
																	</button>
																</div>
															</div>
															<div class="tile-footer" style="padding: 0px 20px;text-align: center;">
																<input class="btn btn-primary btn-lg" type="submit" value="Registrar" name="boton" @if($hostings->estado_anulado=='1') hidden="hidden" @endif>
															</div>
														</form>
													</div>

												</div>
												{{-- Fin crear Cooreos --}}
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
					{{-- modal actulizar --}}

					@foreach($correos as $correo)
					<!-- Modal -->
					<div class="modal fade" id="editar_correo{{$correo->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title" id="exampleModalLabel">Editar Correo </h5>
									<button type="button" style=" margin-left: 5px;" class="btn btn-danger btn-xs">Borrar Correo</button>

								</div>
								<form action="{{ route('hosting_correos.update',$correo->id) }}"  enctype="multipart/form-data" method="post">
									@csrf
									@method('PATCH')
									<div class="modal-body">
										<div class="form-row">
											<div class="col-md-2">
												<label>Correo:</label>
											</div>
											<div class="form-group col-md-4">
												<div class="form-control" style="background-color: #e9ecef;opacity: 1;">{{$correo->correo}}</div>
											</div>
											<div class="col-md-2">
												<label>Contraseña:</label>
											</div>
											<div class="form-group col-md-4">
												<input value="{{$correo->contrasena}}" name="contrasena" required="required" type="text" class="form-control" >
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-2">
												<label>S.Entrante:</label>
											</div>
											<div class="form-group col-md-4">
												<input value="{{$correo->servidor_entrante}}" name="servidor_entrante" required="required" type="text" class="form-control" >
											</div>
											<div class="col-md-2">
												<label>P.IMAP/P.POP3:</label>
											</div>
											<div class="form-group col-md-2">
												<input value="{{$correo->servidor_entrante_imap}}" name="servidor_entrante_imap"  required="required" type="text" class="form-control" >
											</div>
											<div class="form-group col-md-2">
												<input value="{{$correo->servidor_entrante_pop}}" name="servidor_entrante_pop"  required="required" type="text" class="form-control" >
											</div>
										</div>
										<div class="form-row">
											<div class="col-md-2">
												<label>S.Salida:</label>
											</div>
											<div class="form-group col-md-4">
												<input value="{{$correo->servidor_salida}}" name="servidor_salida" required="required" type="text" class="form-control" >
											</div>
											<div class="col-md-2">
												<label>P.SMTP:</label>
											</div>
											<div class="form-group col-md-4">
												<input value="{{$correo->servidor_salida_smptp}}" name="servidor_salida_smptp"  required="required" type="text" class="form-control" >
											</div>

										</div>
										<div class="col-md-12" align="right">
											<button type="submit" class="btn btn-primary" >Actualizar</button>
										</div>
									</div>
								</form>
							</div>
						</div>
					</div>
					@endforeach
					{{--  --}}
					@endforeach

					<style>.dataTables_wrapper.container-fluid.dt-bootstrap4.no-footer{padding-bottom: 0px;}</style>
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

					@foreach($hosting as $hostings)
					<!-- Sweet alert -->
					<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
					<!-- Sweet Alert -->
					<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
					<script>

						$(document).ready(function () {
							$('.demo4.a{{$hostings->id}}').click(function () {
								swal({
									title: "Estas Seguro?",
									text: "Tu Registro sera anulado sin modo a recuperarlo!",
									type: "warning",
									showCancelButton: true,
									confirmButtonColor: "#DD6B55",
									confirmButtonText: "Si, Borrar!",
									cancelButtonText: "No, Cancelar!",
									closeOnConfirm: false,
									closeOnCancel: false },
									function (isConfirm) {
										if (isConfirm) {
											document.anular_registro{{$hostings->id}}.submit()
											swal("Eliminado!", "Tu Registro Fue anulado ", "success");
										} else {
											swal("Cancelado", "Cancelado la anulacion", "error");
										}
									});
							});
						});
					</script>

					<script>
var campos_max{{$hostings->id}} = 5; //max de 10 campos
var x{{$hostings->id}}x = 0;
var borar_ifv= 0;
$(document).ready(function(){
	$("#add_field{{$hostings->id}}").click(function(e){
  e.preventDefault(); //prevenir novos clicks
  if (x{{$hostings->id}}x < campos_max{{$hostings->id}}){
  	$("#listas{{$hostings->id}}").append(

  		'<div class="form-row">'+
  		'<div class="col-md-1">'+
  		'<label>Correo:</label>'+
  		'</div>'+
  		'<div class="form-group col-md-5">'+
  		'<div class="input-group">'+
  		'<input name="email[]" onkeyup="this.value=Numeros(this.value)"  required="required" value="" type="text" class="form-control" >'+
  		'<div class="input-group-prepend"><span style="font-size: 12px" class="input-group-text">&#64;{{$dominio_para_correo=substr($hostings->dominio, 4)}}</span></div>'+
  		'</div>'+
  		'</div>'+
  		'<div class="col-md-2">'+
  		'<label>Contraseña:</label>'+
  		'</div>'+
  		'<div class="form-group col-md-3">'+
  		'<input name="password[]"  required="required"  type="text" class="form-control" >'+
  		'</div>'+
  		'<button style="display: inline;background: none;" class="remover_campo{{$hostings->id}} btn" type="button" >'+
  		'<img src="{{asset('multimedia/borrar.png')}}" width="25px">'+
  		'</button>'+
  		'</div>');
  	x{{$hostings->id}}x++;
  }
});

  // Remover o div anterior
  $("#listas{{$hostings->id}}").on("click", ".remover_campo{{$hostings->id}}", function (e) {
  	e.preventDefault();
  	$(this).parent('div').remove();
  	x{{$hostings->id}}x--;
  });
});

</script>
@endforeach
{{-- Limites de Caracteres --}}
<script>
function Numeros(string){//Solo numeros
	var out = '';
    var filtro = 'qwertyuiopasdfghjklñzxcvbnm1234567890.';//Caracteres validos

    //Recorrer el texto y verificar si el caracter se encuentra en la lista de validos
    for (var i=0; i<string.length; i++)
    	if (filtro.indexOf(string.charAt(i)) != -1)
             //Se añaden a la salida los caracteres validos
         out += string.charAt(i);

    //Retornar valor filtrado
    return out;
}
</script>
{{-- Limites de Caracteres --}}

@endsection