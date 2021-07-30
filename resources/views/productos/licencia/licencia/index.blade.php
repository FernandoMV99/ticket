@extends('menu.layout')
@section('title', 'Licencias')
@section('img_title', 'licencias.svg')

@section('value_accion1', 'Agregar')
@section('data-toggle1', 'modal')
@section('data-target1', '#AgregarHosting')

@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<?php
use Carbon\Carbon;
?>
{{-- <div > Click aqui</div> --}}
<!-- Modal Agregar Motivos-->
<div class="modal inmodal" id="AgregarHosting" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content animated bounceIn">
			<div class="modal-header" style="padding: 10px"><h4 class="modal-title">Agregar Licencia</h4></div>
			<form action ="{{route('licencia.store')}}" method="POST" enctype="multipart/form-data" >
				@csrf
				<div class="modal-body">
					<div class="col-lg-12">
						<div class="tabs-container">
									<div class="panel-body">
										<div class="tile-body">
											<div class="form-row">
												<div class="form-group col-md-4">
													<label>Nombre del Cliente o Empresa:</label>
													<select id="cliente_id" name="cliente_id" class="form-control">
														<option>Selecciona un Cliente</option>
														@foreach($clientes as $cliente)
														<option value="{{$cliente->id}}">{{$cliente->name}} {{$cliente->last_name}}</option>
														@endforeach

													</select>
												</div>

												<div class="form-group col-md-5">
													<label>Equipos:</label>
													<select name="equipos_cliente"  id="equipos_cliente" class="form-control" required="">
													</select>
												</div>

												<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
												<script type="text/javascript">
													// $('#cliente_id').on('keyup',function(){
														$('#cliente_id').on('change',function(){
															$value = $(this).val();
															$.ajax({
																type: 'get',
																url: '{{URL::to('equipo_cliente')}}',
																data: {'cliente_id':$value},
																success:function(data){
																	$('#equipos_cliente').html(data);
																}
															})
														})
													</script>
													<div class="form-group col-md-3">
														<label>Categorias:</label>
														<select class="form-control" name="categoria" required="">
															@foreach($categoria as $categorias)
															<option value="{{$categorias->id}}">{{$categorias->nombre}}</option>
															@endforeach
														</select>
													</div>
												</div>
												<div class="form-row">
													<div class="form-group col-md-6">
														<label>Nombre de Licencia:</label>
														<input type="text" class="form-control" name="nombre_licencia" required="">
													</div>
													<div class="form-group col-md-6">
														<label >Codigo licencia:</label>
														<input type="text" class="form-control" name="cod_licencia" required="">
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
													<div class="form-group col-md-12">
														<label >Descripción:</label>
														<textarea name="descripcion" class="form-control"></textarea>
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
							<table class="table table-striped table-bordered table-hover dataTables-example" id="expamplee" >
								<thead>
									<tr>
										<th>Item</th>
										<th>Cliente</th>
										<th>Categoria Licencia</th>
										<th>Años</th>
										<th>Fecha Vencimiento</th>
										<th>Dias Faltantes</th>
										<th>Precio</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@foreach($licencia as $licencias)
									<tr>
										<td>{{$licencias->id}}
											@if($licencias->estado==1 & $licencias->estado_anulado==1)
											<span class="label label-danger">Anulado</span>
											@elseif($licencias->estado==1 & $licencias->estado_anulado==0)
											<span class="label label-warning">Inactivo</span>
											@elseif($licencias->estado==0 & $licencias->estado_anulado==0)
											<span class="label label-info">Activo</span>
										@endif</td>
										<td>{{$licencias->clientes->name}} {{$licencias->clientes->last_name}}</td>
										<td>{{$licencias->categoria->nombre}}</td>
										<td>{{$licencias->anos}} Año(s)</td>
										<td>{{$licencias->fecha_vencimiento}}</td>
										<td>
											<span hidden="">
												{{$date = $licencias->fecha_vencimiento."+ 1 days"}}
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
													<td>{{$licencias->moneda}}{{$licencias->precio}}</td>
													<!-- Formulario Anular-->
													<form action="{{ route('licencia.update',$licencias->id) }}"  enctype="multipart/form-data" method="post"  name="anular_registro{{$licencias->id}}">
														@csrf
														@method('PATCH')
														<input type="hidden" name="boton" value="Anulado">
													</form>
													<!-- Formulario Anular-->
													<td>
														@if($testdate<30 & $licencias->estado_anulado==0)
															<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#Renovar{{$licencias->id}}">Renovar</button>
															@else
															<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#HostingEdit{{$licencias->id}}">Ver</button>
														@endif</td>

														{{--  --}}
														<div class="modal inmodal" id="Renovar{{$licencias->id}}" tabindex="-1" role="dialog" aria-hidden="true">
															<div class="modal-dialog modal-lg">
																<div class="modal-content animated bounceIn">
																	<div class="modal-header" style="padding: 10px">
																		<h4 class="modal-title">Renovar Licencia</h4>
																		@if($licencias->estado_anulado=='0') <button class="demo4 a{{$licencias->id}}" style="background:#ff000000;border: 0px;"><img class="input-group-text" style="background:#ff000000;border: 0px;width: 50px" src="{{ asset('/multimedia/anulado.svg')}}" /></button> @endif

																	</div>

																	<form action="{{ route('licencia.update',$licencias->id) }}"  enctype="multipart/form-data" method="post">
																		@csrf
																		@method('PATCH')
																		<div class="modal-body">
																			<div class="col-lg-12">
																				<div class="tabs-container">
																					<div class="tab-content">
																						<div role="tabpanel" id="renovar{{$licencias->id}}" class="tab-pane active show">
																							<div class="panel-body">
																								<div class="tile-body">
																									<div class="form-row">

																										<div class="form-group col-md-6">
																											<label>Nombre del Cliente o Empresa:</label>
																											<input type="text" class="form-control" disabled="" value="{{$licencias->clientes->name}} {{$licencias->clientes->last_name}}">
																										</div>
																										<div class="form-group col-md-6">
																											<label>Fecha compra:</label>
																											<input type="text" class="form-control" readonly=""  value="{{$licencias->fecha_inicio}}">
																										</div>	<div class="form-group col-md-6">
																											<label>Fecha Vencimiento:</label>
																											<input type="date" class="form-control" readonly="" name="fecha_inicio" value="{{$licencias->fecha_vencimiento}}">
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
																				<input class="btn btn-primary btn-lg" type="submit" value="Renovar" name="boton" @if($licencias->estado_anulado=='1') disabled="" @endif>
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


					@foreach($licencia as $licencias)
					{{-- modal actulizar --}}
					<div class="modal inmodal" id="HostingEdit{{$licencias->id}}" tabindex="-1" role="dialog" aria-hidden="true">
						<div class="modal-dialog modal-lg">
							<div class="modal-content animated bounceIn">
								<div class="modal-header" style="padding: 10px">
									<h4 class="modal-title">Editar licencia</h4>
									@if($licencias->estado_anulado=='0') <button class="demo4 a{{$licencias->id}}" style="background:#ff000000;border: 0px;"><img class="input-group-text" style="background:#ff000000;border: 0px;width: 50px" src="{{ asset('/multimedia/anulado.svg')}}" /></button> @endif

								</div>
								<div class="modal-body">
									<div class="col-lg-12">
										<div class="tabs-container">
											<div class="panel-body">
												<div class="tile-body">
													<form action="{{ route('licencia.update',$licencias->id) }}"  enctype="multipart/form-data" method="post">
														@csrf
														@method('PATCH')
														<div class="form-row">
															<div class="form-group col-md-4">
																<label>Nombre del Cliente o Empresa:</label>
																<input type="text" class="form-control" disabled="" value="{{$licencias->clientes->name}} {{$licencias->clientes->last_name}}">
															</div>
															<div class="form-group col-md-5">
																<label>Equipo:</label>
																<input type="text" class="form-control" disabled="" value="{{$licencias->equipos->marcas->nombre}} - {{$licencias->equipos->codigo_equipo}} - {{$licencias->equipos->usuario}}">
															</div>

															<div class="form-group col-md-3">
																<label>Categoria:</label>
																<input type="text" class="form-control" value="{{$licencias->categoria->nombre}}" disabled="" >
															</div>
														</div>
														<div class="form-row">
															<div class="form-group col-md-6">
																<label>Fecha de inicio:</label>
																<input type="date" class="form-control"  name="fecha_inicio" value="{{$licencias->fecha_inicio}}" @if($licencias->estado_anulado=='1') disabled="" @endif>
															</div>
															<div class="form-group col-md-6">
																<label >Duración del contrato:</label>
																<select class="form-control" name="fecha_vencimiento" required="" @if($licencias->estado_anulado=='1') disabled="" @endif>
																	<option value="1" @if('1'==$licencias->anos) selected @endif >1 año</option>
																	<option value="2" @if('2'==$licencias->anos) selected @endif >2 años</option>
																	<option value="3" @if('3'==$licencias->anos) selected @endif >3 años</option>
																	<option value="4" @if('4'==$licencias->anos) selected @endif >4 años</option>
																	<option value="5" @if('5'==$licencias->anos) selected @endif >5 años</option>
																</select>
															</div>
														</div>
														<div class="form-row">
															<div class="form-group col-md-6">
																<label>Nombre Licencia:</label>
																<input type="text" class="form-control"  name="fecha_inicio" value="{{$licencias->nombre}}" @if($licencias->estado_anulado=='1') disabled="" @endif>
															</div>
															<div class="form-group col-md-6">
																<label >Codig Licencia:</label>
																<input type="text" class="form-control"  value="{{$licencias->codigo_licencia}}" @if($licencias->estado_anulado=='1') disabled="" @endif>
															</div>
														</div>
														<div class="form-row">
															<div class="form-group col-md-12">
																<label>Descripcion:</label>
																<textarea name="descripcion" class="form-control" rows="5" @if($licencias->estado_anulado=='1') disabled="" @endif>{{$licencias->descripcion}}</textarea>
															</div>
														</div>
														<div class="tile-footer" style="padding: 0px 20px;text-align: center;">
															<input class="btn btn-primary btn-lg" type="submit" value="Actualizar" name="boton" @if($licencias->estado_anulado=='1')hidden="hidden" @endif>
														</div>
													</form>
												</div>
											</div>
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
					{{-- modal actulizar --}}
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

						@foreach($licencia as $licencias)
						<!-- Sweet alert -->
						<script src="js/plugins/sweetalert/sweetalert.min.js"></script>
						<!-- Sweet Alert -->
						<link href="css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
						<script>

							$(document).ready(function () {
								$('.demo4.a{{$licencias->id}}').click(function () {
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
												document.anular_registro{{$licencias->id}}.submit()
												swal("Eliminado!", "Tu Registro Fue anulado ", "success");
											} else {
												swal("Cancelado", "Cancelado la anulacion", "error");
											}
										});
								});
							});
						</script>
						@endforeach

						@endsection