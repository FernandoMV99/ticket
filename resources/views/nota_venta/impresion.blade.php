@extends('menu.layout')

{{-- @section('img_title', 'nota_venta.svg') --}}
@section('title', 'Nota Venta')
@section('atributo1', 'hidden')
@section('content')
{{-- Modal Vista --}}


<form {{-- action="{{ route('hosting.update',$hostings->id) }}"   --}}enctype="multipart/form-data" method="post">
	@csrf
	@method('PATCH')
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
									<div class="row" style="margin-top: 40px">
										<div class="col-lg-6" align="left" >
											<b>Facturado a</b> <br>
											{{$cliente->empresa}}<br>
											Sr(a): {{$cliente->name}} {{$cliente->last_name}} <br>
											{{$empresa->ruc}}<br>
											{{$cliente->pais}}<br>
										</div>
										<div class="col-lg-6" align="right">
											{{$empresa->nombre}} <br>
											{{$empresa->pais}}-{{$empresa->departamento}}-{{$empresa->distrito}} <br>
											ID: {{$empresa->ruc}}
										</div>
									</div>
									<table class="table table-hover" >
										<thead>
											<tr>
												<th></th>
												<th>Descripcion</th>
												<th></th>
												<th style="text-align: right;">Total</th>
											</tr>
										</thead>
										<tbody>
											{{-- Hosting  --}}
											@if(isset($hosting_impresion))
											@foreach($hosting_impresion as $index => $hosting_impresion)
											<tr >
												<td><input type="checkbox"></td>
												<td><b>Plan Hosting:</b> {{$hosting_impresion->plan_hostings->nombre}} - <b>Dominio:</b> {{$hosting_impresion->dominio}} - <b>Años:</b> {{$hosting_impresion->anos}} - <b>FechaVencimiento:</b> {{$hosting_impresion->fecha_vencimiento}}</td>
												<td width="80px"></td>
												<td style="text-align: right;">{{$hosting_impresion->moneda}}{{$hosting_impresion->precio}}</td>
											</tr>
											@endforeach
											@endif
											{{--Fin Hosting  --}}
											{{-- Dominio  --}}
											@if(isset($dominio_impresion))
											@foreach($dominio_impresion as $index => $dominio_impresion)
											<tr >
												<td><input type="checkbox"></td>
												<td> <b>Dominio:</b> {{$dominio_impresion->dominio}} - <b>Años:</b> {{$dominio_impresion->anos}} - <b>FechaVencimiento:</b> {{$dominio_impresion->fecha_vencimiento}}</td>
												<td width="80px"></td>
												<td style="text-align: right;">{{$dominio_impresion->moneda}}{{$dominio_impresion->precio}}</td>
											</tr>
											@endforeach
											@endif
											{{--Fin Dominio  --}}
											{{-- certificado SSl  --}}
											@if(isset($certificadossl_impresion))
											@foreach($certificadossl_impresion as $index => $certificadossl_impresion)
											<tr >
												<td><input type="checkbox"></td>
												<td> <b>Dominio:</b> {{$certificadossl_impresion->dominio}} - <b>Años:</b> {{$certificadossl_impresion->anos}} - <b>FechaVencimiento:</b> {{$certificadossl_impresion->fecha_vencimiento}}</td>
												<td width="80px"></td>
												<td style="text-align: right;">{{$certificadossl_impresion->moneda}}{{$certificadossl_impresion->precio}}</td>
											</tr>
											@endforeach
											@endif
											{{-- certificado SSl  --}}
											@if(isset($certificadossl_impresion))
											@foreach($certificadossl_impresion as $index => $certificadossl_impresion)
											<tr >
												<td><input type="checkbox"></td>
												<td> <b>Dominio:</b> {{$certificadossl_impresion->dominio}} - <b>Años:</b> {{$certificadossl_impresion->anos}} - <b>FechaVencimiento:</b> {{$certificadossl_impresion->fecha_vencimiento}}</td>
												<td width="80px"></td>
												<td style="text-align: right;">{{$certificadossl_impresion->moneda}}{{$certificadossl_impresion->precio}}</td>
											</tr>
											@endforeach
											@endif
											{{--Fin certificado SSl  --}}
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
</form>

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
@endsection