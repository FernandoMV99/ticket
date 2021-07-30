@extends('menu.layout')
@section('img_title', 'user.svg')
@section('title', 'Usuarios')
@section('value_accion1', 'Agregar')
@section('data-toggle1', 'modal')
@section('data-target1', '#AgregarUsuario')

@section('content')
<style>
input#archivoInput{
	position:absolute;
	top:0px;
	left:0px;
	right:0px;
	bottom:0px;
	width:100%;
	height:100%;
	opacity: 0	;
}
.form-control{ border-radius: 5px;height: 36px !important
}
</style>
{{-- FIN MODAL AGREGAR Usuarios --}}
{{-- {{date("d-m-Y H:m:s")}}
<input type="date"> --}}
<div class="modal inmodal fade" id="AgregarUsuario" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Agregar Cliente</h4>
			</div>
			<div class="wrapper wrapper-content">
				{{-- <form id="form" action="#" class="wizard-big"> --}}
					<form action="{{ route('usuario.store') }}" id="form" enctype="multipart/form-data" method="post" class="wizard-big">
						@csrf
						<h1>Datos Personales</h1>
						<fieldset>
							<h2>Datos Personales</h2>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label >Nombres:</label>
										<input autocomplete="off" type="text" class="form-control required" name="name" value="">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label >Apellidos:</label>
										<input autocomplete="off" type="text" class="form-control required" name="last_name" value="">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label >Empresa:</label>
										<input autocomplete="off" type="text" class="form-control required" name="empresa" value="">
									</div>
								</div>
								<div class="col-lg-6">
										<label >Empresa:</label>
									<div class="input-group" >
										<div class="input-group-prepend">
											<select name="documento_identificacion" class="input-group-text" >
												@foreach($documento_iden as $documento_identificacion)
												<option value="{{$documento_identificacion->id}}"> {{$documento_identificacion->nombre}}</option>
												@endforeach
											</select>
										</div>
										<input type="number" class="form-control" autocomplete="off" name="numero_identificacion"  required="">
									</div>
								</div>
								<div class="col-lg-6">

									<label >celular:</label>
									<div class="input-group m-b">
										<div class="input-group-prepend">
											<span class="input-group-addon">+</span>
											<input type="number" autocomplete="off" class="form-control required" name="cod_celular" value="51" style="width: 80px ;border-radius: 0px">
										</div>
										<input style="border-radius: 0px" autocomplete="off" type="number" class="form-control required" type="text" name="celular">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label >Pais:</label>
										<select class="form-control required" name="pais">
											<option value="Perú">Perú</option>
											@foreach($paises as $pais)
											<option value="{{$pais->nombre}}">{{$pais->nombre}}</option>
											@endforeach
										</select>
									</div>
								</div>
							</div>

						</fieldset>
						<h1>Datos Login</h1>
						<fieldset>
							<h2>Registrar Login</h2>
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group">
										<label>Correo :</label>
										<input autocomplete="off" name="email" type="email" class="form-control required">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Roles</label>
										<select class="form-control required" name="roles_id">
											@foreach($roles as $rol)
											<option value="{{$rol->id}}">{{$rol->nombre}}</option>
											@endforeach
										</select>
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Contraseña:</label>
										<input autocomplete="off" id="password" name="password" type="password" disabled="" value="***************" class="form-control required">
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group">
										<label>Confirmar Contraseña:</label>
										<input autocomplete="off" id="confirm" name="confirm" type="password" disabled="" value="***************" class="form-control required">
									</div>
								</div>
							</div>
						</fieldset>
						<h1>Foto de Perfil</h1>
						<fieldset>
							<div class="col-sm-12">
								<input type="file" id="archivoInput" name="foto" onchange="return validarExt()"  />
								<div id="visorArchivo">
									<!--Aqui se desplegará el fichero-->
									<center ><img style="border-radius: 5px; border: 3px solid #24d47a52;padding: 10px;" name="foto"  src="{{ asset('/multimedia/users/usuario.svg')}}" width="350px" height="250px" /></center>
								</div>
							</div>
						</fieldset>
					</form>
				</div>

			</div>
		</div>
	</div>

	{{-- FIN MODAL AGREGAR USUARIO --}}
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
										<th>Apellido</th>
										<th>Empresa</th>
										<th>Celular</th>
										<th>Correo</th>
										<th>Tipo Usuario</th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@foreach($usuarios as $usuario)
									<tr class="gradeX">
										<td>@if($usuario->estado_activo==1) <span class="label label-info">Activo</span> @else <span class="label label-default">Desactivo</span> @endif {{$item++}}</td>
										<td>{{$usuario->name}}</td>
										<td>{{$usuario->last_name}}</td>
										<td>{{$usuario->empresa}}</td>
										<td>{{$usuario->celular}}</td>
										<td>{{$usuario->email}}</td>
										<td>{{$usuario->roles->nombre}}</td>
										<td><a href="{{ route('usuario.show', $usuario->id) }}"><button type="button" class="btn btn-s-m btn-primary">Ver</button></a></td>
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

	{{-- Notificacion de Errores --}}
	<script src="{{ asset('js/plugins/toastr/toastr.min.js') }}"></script>
	@if($errors->any())
	@foreach ($errors->all() as $error)
	<script>
		$(document).ready(function() {
			setTimeout(function() {
				toastr.options = {
					closeButton: true,
					progressBar: false,
					showMethod: 'slideDown',
					timeOut: 2000
				};
				toastr.error('{{ $error }}');
			}, 0);
		});
	</script>@endforeach
	@endif
	{{-- Fin Notificacion de Errores --}}

	{{-- Validar Formulario 1 2 3 --}}
	<!-- Steps -->
	<script src="{{ asset('js/plugins/steps/jquery.steps.min.js') }}"></script>

	<!-- Jquery Validate -->
	<script src="{{ asset('js/plugins/validate/jquery.validate.min.js') }}"></script>


	<script>
		$(document).ready(function(){
			$("#wizard").steps();
			$("#form").steps({
				bodyTag: "fieldset",
				onStepChanging: function (event, currentIndex, newIndex)
				{
                    // Always allow going backward even if the current step contains invalid fields!
                    if (currentIndex > newIndex)
                    {
                    	return true;
                    }

                    // Forbid suppressing "Warning" step if the user is to young
                    if (newIndex === 3 && Number($("#age").val()) < 18)
                    {
                    	return false;
                    }

                    var form = $(this);

                    // Clean up if user went backward before
                    if (currentIndex < newIndex)
                    {
                        // To remove error styles
                        $(".body:eq(" + newIndex + ") label.error", form).remove();
                        $(".body:eq(" + newIndex + ") .error", form).removeClass("error");
                    }

                    // Disable validation on fields that are disabled or hidden.
                    form.validate().settings.ignore = ":disabled,:hidden";

                    // Start validation; Prevent going forward if false
                    return form.valid();
                },
                onStepChanged: function (event, currentIndex, priorIndex)
                {
                    // Suppress (skip) "Warning" step if the user is old enough.
                    if (currentIndex === 2 && Number($("#age").val()) >= 18)
                    {
                    	$(this).steps("next");
                    }

                    // Suppress (skip) "Warning" step if the user is old enough and wants to the previous step.
                    if (currentIndex === 2 && priorIndex === 3)
                    {
                    	$(this).steps("previous");
                    }
                },
                onFinishing: function (event, currentIndex)
                {
                	var form = $(this);

                    // Disable validation on fields that are disabled.
                    // At this point it's recommended to do an overall check (mean ignoring only disabled fields)
                    form.validate().settings.ignore = ":disabled";

                    // Start validation; Prevent form submission if false
                    return form.valid();
                },
                onFinished: function (event, currentIndex)
                {
                	var form = $(this);

                    // Submit form input
                    form.submit();
                }
            }).validate({
            	errorPlacement: function (error, element)
            	{
            		element.before(error);
            	},
            	rules: {
            		confirm: {
            			equalTo: "#password"
            		}
            	}
            });
        });
    </script>
    {{-- Fin Validar Formulario 1 2 3 --}}

    {{-- foto previzualizar --}}

    <script type="text/javascript">
    	function validarExt()
    	{
    		var archivoInput = document.getElementById('archivoInput');
    		if (archivoInput.files && archivoInput.files[0])
    		{
    			var visor = new FileReader();
    			visor.onload = function(e)
    			{
    				document.getElementById('visorArchivo').innerHTML =
    				'<center><img name="foto" src="'+e.target.result+'"width="350px" height="250px" style="border-radius: 5px;" /></center>';
    			};
    			visor.readAsDataURL(archivoInput.files[0]);
    		}
    	}
    </script>
    {{-- fin foto previzualizar --}}


    @endsection