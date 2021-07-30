@extends('menu.layout_cliente')
@section('img_title', 'nota_venta.svg')

@section('title', 'Tickets')
@section('atributo1', 'hidden')
@section('content')
<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-lg-12" >
			<div class="ibox ">
				<div class="ibox-content">
					<div class="panel-body">
						<div class="tile-body">
							<div class="ibox ">
								<div class="row">
									<div class="col-lg-6" align="left">
										<img  style="width: 50%;height:auto;background-size: contain;border-radius: 5px; padding: 10px;" name="foto"  src="{{ asset('/multimedia/empresa/')}}/{{$empresa->foto}}"  />
									</div>
									<div class="col-lg-2" align="left"></div>
									<div class="col-lg-4" align="right">
										<div class="form-control" align="center" style="color: grey;background-color: #def7e8; margin-bottom: 0px;border:none" >
											<b><h2>Pagos Pendientes</h2></b>
										</div>
									</div>
								</div>
								<div class="row" style=" margin-top: 10px;">
									<div class="col-lg-6" align="left"><b>Descripcion</b></div>
									<div class="col-lg-6" align="right"><b>Total</b></div>
								</div>
								<hr>
								@if(count($tickets_agregados)==0)
								<div class="row">
									<div class="col-lg-12" align="center">
										<h1> No hay Registros de Deudas</h1>
									</div>
								</div>
								@endif
								@foreach($tickets_agregados as $tickets_agregado)
								<div class="row">
									<div class="col-lg-6" align="left">
										Soporte Técnico / <b>{{$tickets_agregado->codigo_ticket}}</b> <br>
										<b>Motivo:</b> {{$tickets_agregado->motivo->nombre}}<br>
										<b>Asunto:</b> {{$tickets_agregado->asunto}}<br>
										@if(isset($tickets_agregado->equipo))
										<b>Equipo en Soporte:</b>{{$tickets_agregado->equipos->marcas->nombre}} / {{$tickets_agregado->equipos->tipoequipo->nombre}} / {{$tickets_agregado->equipos->usuario}}
										@endif
									</div>

									<div class="col-lg-6" align="right">
										<p>{{$tickets_agregado->moneda}}{{$tickets_agregado->precio}}</p>
									</div>
									<hr>
								</div>
								<hr>
								@endforeach
								<div class="row">
								<div class="col-lg-12" align="right">
									<b>Total:</b> S/. {{$tickets_agregados->sum('precio')}}
								</div>
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