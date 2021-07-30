@extends('menu.layout_cliente')


@section('img_title', 'dominios.svg')
@section('title', 'Mis Dominios')
@section('atributo1', 'hidden')


@section('content')
<?php
use Carbon\Carbon;
use App\Dominios;
?>
{{-- <td>  <dd>
	<div class="progress m-b-1">
		<div style="width: 60%;" class="progress-bar progress-bar-striped progress-bar-animated"></div>
	</div>
	<small>Project completed in <strong>60%</strong>. Remaining close the project, sign a contract and invoice.</small>
</dd></td> --}}
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12" >
			<div class="ibox ">
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
								<th>ITEM</th>
								<th>Datos Del Dominio</th>
							</thead>
							<tbody>
								@foreach($dominios_cliente as $dominios_clientes)
								<tr>
									<td>{{$dominios_clientes->id}}</td>
									<td>
										<div class="row">
											<div class="col-lg-6" align="left">
												<dl class="row mb-0">
													<div class="col-sm-4"><dt>Estado:</dt> </div>
													<div class="col-sm-8 text-sm-left"><dd class="mb-1">@if($dominios_clientes->estado==0)<span class="label label-info">Activo</span> @else <span class="label label-warning">Suspendido</span>@endif</div>
													</dl>
													<dl class="row mb-0">
														<div class="col-sm-4"><dt>Dominio:</dt> </div>
														<div class="col-sm-8 text-sm-left"><dd class="mb-1">{{$dominios_clientes->nombre_dominio}}</dd> </div>
													</dl>
													<dl class="row mb-0">
														<div class="col-sm-4"><dt>Dias Faltantes:</dt> </div>
														<div class="col-sm-8 text-sm-left"> <dd class="mb-1">
															<span hidden="">
																{{$date = $dominios_clientes->fecha_vencimiento."+ 1 days"}}
																{{$datework = Carbon::createFromDate($date)}}
																{{$fecha_compra = Carbon::createFromDate($dominios_clientes->fecha_compra)}}
																{{$now = Carbon::now()}}
																{{ $cienporciento=$fecha_compra->diffInDays($datework)}}
																@if ($datework>$now)
																{{$testdate=$now->diffInDays($datework)}}
																@else
																{{$testdate= 0}}
																@endif
																{{$porsentaje=100-(($testdate*100)/$cienporciento)}}
															</span>
															@if($testdate<31 & $testdate>15)<strong style="color: #00ad75">{{$testdate}} Días</strong>
																@elseif($testdate<16 & $testdate>7)<strong style="color: #c17312b8">{{$testdate}} Días</strong>
																	@elseif($testdate<8)<strong style="color: #ff1515f2">{{$testdate}} Días</strong>
																	@else <strong>{{$testdate}} Días</strong>
																@endif</dd>
															</div>
														</dl>
														<dl class="row mb-0">
															<div class="col-sm-4">
																<dt>porcentaje:</dt>
															</div>
															<div class="col-sm-7 text-sm-left">
																<dd class="mb-1">
																	<div class="progress m-b-1" style="background-color: #0b34ff2e">
																		@if($testdate<31 & $testdate>15)
																			<div style="width: {{round($porsentaje, 0)}}%;background-color:#00ad75;" class="progress-bar progress-bar-striped progress-bar-animated"></div>
																			@elseif($testdate<16 & $testdate>7)
																				<div style="width: {{round($porsentaje, 0)}}%;background-color:#c17312b8;" class="progress-bar progress-bar-striped progress-bar-animated"></div>
																				@elseif($testdate<8)
																				<div style="width: {{round($porsentaje, 0)}}%;background-color:#ff1515f2;" class="progress-bar progress-bar-striped progress-bar-animated"></div>
																				@else
																				<div style="width: {{round($porsentaje, 0)}}%" class="progress-bar progress-bar-striped progress-bar-animated"></div>
																				@endif
																			</div>
																		</dd>
																	</div>
																	<div class="col-sm-1 text-sm-left">{{round($porsentaje, 0)}}%</div>
																</dl>
															</div>
															<div class="col-lg-6" id="cluster_info">

																<dl class="row mb-0">
																	<div class="col-sm-4">
																		<dt>Fecha Compra:</dt>
																	</div>
																	<div class="col-sm-8 text-sm-left">
																		<dd class="mb-1">{{$dominios_clientes->fecha_compra}}</dd>
																	</div>
																</dl>
																<dl class="row mb-0">
																	<div class="col-sm-4">
																		<dt>Fecha Vencimiento:</dt>
																	</div>
																	<div class="col-sm-8 text-sm-left">
																		<dd class="mb-1">{{$dominios_clientes->fecha_vencimiento}}</dd>
																	</div>
																</dl>
																<dl class="row mb-0">
																	<div class="col-sm-4">
																		<dt>Fecha Creacion:</dt>
																	</div>
																	<div class="col-sm-8 text-sm-left">
																		<dd class="mb-1">{{$dominios_clientes->created_at}}</dd>
																	</div>
																</dl>
																<dl class="row mb-0">
																	<div class="col-sm-4"><dt>Descripcion:</dt> </div>
																	<div class="col-sm-8 text-sm-left"> <dd class="mb-1">{{$dominios_clientes->descripcion}}</dd></div>
																</dl>
															</div>
														</div>
													</td>
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