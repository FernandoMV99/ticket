@extends('menu.layout')

@section('img_title', 'equipos.svg')
@section('title', 'Equipos')
@section('atributo1', 'hidden')

@section('content')
<?php
use Carbon\Carbon;
use App\Equipos;
use App\Dominios;
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
									<th>Item</th>
									<th>Nombre Cliente</th>
									<th>Cantidad Equipos</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<span hidden="">
								{{$i=1}}
								</span>
								@foreach($cliente as $clientes)
								<span hidden="">
									{{$equipo=Equipos::where('cliente',$clientes->id)->count()}}
								</span>
								<tr>
									<td>{{$i++}}</td>
									<td>{{$clientes->name}} {{$clientes->last_name}}</td>
									<td>{{$equipo}} Equipos</td>
									<td><a href="{{ route('equipos.show', $clientes->id) }}" ><button type="button"  class="btn btn-info ">VER</button></a></td>
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