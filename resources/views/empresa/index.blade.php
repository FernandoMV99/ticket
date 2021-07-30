@extends('menu.layout')

@section('img_title', 'empresa.svg')
@section('title', 'Empresa')
@section('atributo1', 'hidden')

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
.form-control{ border-radius: 5px; }
.iconos_perfil{padding-right: 5px}
</style>
<div class="wrapper wrapper-content">
	<div class="row animated fadeInRight">
		<div class="col-md-4">
			<div class="ibox ">
				<div class="ibox-title" style="padding-right: 0px;">
					<div class="row">
						<div class="col-sm-10" style="margin-top: 10px"><h5>Correo de Notificaciones</h5></div>
						<div class="col-sm-2"  style="text-align: right"><button class="btn " id="boton_correo" style="background:#228b2200;" onclick="editar_correo()"><img alt="image" width="25px"  src="{{asset('multimedia/editar.svg')}}">
						</button></div>
					</div>
				</div>

				<div class="ibox-content">
					<div align="center"><img  style="width: 35%;height:auto;background-size: contain;border-radius: 5px;padding: 10px;" name="foto"  src="{{ asset('/multimedia/correo.svg')}}" /></div>
					<div class="ibox-content profile-content">

						<!-- vista Correo -->
						<div class="row m-t-lg" id="vista_correo" >
							<div style="padding-bottom: 15px;" class="col-md-12"><img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/correo.svg')}}"> {{$empresa->correo}}</div>
							<div style="padding-bottom: 15px;" class="col-md-12"><img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/puerto.svg')}}"> {{$empresa->puerto}}</div>
							<div style="padding-bottom: 15px;" class="col-md-12"><img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/smtp.svg')}}"> {{$empresa->smpt}}</div>
							<div style="padding-bottom: 15px;" class="col-md-12"><img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/encryp.svg')}}"> @if($empresa->encryption==" ")Ninguno @else{{$empresa->encryption}}@endif</div>
						</div>
						<!-- FIN vista Correo -->

						<!-- Formulario Correo -->
						<form action="{{ route('empresa.update',$empresa->id) }}"  enctype="multipart/form-data" method="post">
							@csrf
							@method('PATCH')
							<div class="row m-t-lg" id="form_correo" hidden >
								<div class="col-md-2"><img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/correo.svg')}}"></div>
								<div class="col-md-10" style="padding-bottom: 10px;"><input name="correo" type="text" value="{{$empresa->correo}}" class="form-control"></div>

								<div class="col-md-2"><img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/puerto.svg')}}"></div>
								<div class="col-md-10" style="padding-bottom: 10px;"><input name="puerto" type="text" value="{{$empresa->puerto}}" class="form-control"></div>

								<div class="col-md-2"><img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/smtp.svg')}}"></div>
								<div class="col-md-10" style="padding-bottom: 10px;"> <input name="smpt" type="text" value="{{$empresa->smpt}}" class="form-control"></div>

								<div class="col-md-2"><img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/encryp.svg')}}"></div>
								<div class="col-md-10" style="padding-bottom: 10px;">
									<select name="encryption"  class="form-control">
										<option value=""@if($empresa->encryption=='') selected="" @endif>Ninguno</option>
										<option value="SSL" @if($empresa->encryption=='SSL') selected=""  @endif>SSL</option>
										<option value="TSL" @if($empresa->encryption=='TSL') selected=""  @endif>TSL</option>
									</select>
								</div>

								<div class="col-md-12" align="right"><button class="btn btn-primary" name="boton" value="correo" >Editar</button></div>

							</div>
						</form>
						<!--Fin Formulario Correo -->

					</div>
				</div>

			</div>
		</div>
		<div class="col-md-8">
			<div class="ibox ">
				<div class="ibox-title" style="padding-right: 0px;">
					<div class="row">
						<div class="col-sm-10" style="margin-top: 10px"><h5>Datos Empresa</h5></div>
						<div class="col-sm-2"  style="text-align: right"><button class="btn " id="boton_empresa" style="background:#228b2200;" onclick="editar_empresa()"><img alt="image" width="25px"  src="{{asset('multimedia/editar.svg')}}">
						</button></div>
					</div>
				</div>

				<!-- Vista Empresa -->
				<div id="vista_empresa">
					<div class="ibox-content no-padding border-left-right">
						<div align="center"><img  style="width: 50%;height:auto;background-size: contain;border-radius: 5px; padding: 10px;" name="foto"  src="{{ asset('/multimedia/empresa/')}}/{{$empresa->foto}}"  /></div>
					</div>
					<div class="ibox-content profile-content">
						<div ><strong><div>{{$empresa->nombre}}</div><div style="text-align: right;">RUC:{{$empresa->ruc}}</div></strong></div>
						<p><i class="fa fa-map-marker"></i>{{$empresa->pais}}/{{$empresa->departamento}}/{{$empresa->distrito}}</p>
						<h5>Sobre mi:</h5>
						<p>{{$empresa->descripcion}}</p>
						<div class="row m-t-lg" align="center">
							<div class="col-md-3">
								<span class="bar"><img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/celular.svg')}}"> {{$empresa->celular}}</span>
							</div>
							<div class="col-md-3">
								<span class="bar"><img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/telefono.svg')}}"> {{$empresa->telefono}}</span>
							</div>
							<div class="col-md-6">
								<span class="bar"><img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/pagina_web.svg')}}"> {{$empresa->pagina_web}}</span>
							</div>
						</div>
					</div>
				</div>
				<!-- Fin Vista Empresa -->

				<!-- Formulario Empresa -->
				<form action="{{ route('empresa.update',$empresa->id) }}"  enctype="multipart/form-data" method="post">
					@csrf
					@method('PATCH')

					<div id="form_empresa" hidden>
						<div class="ibox-content no-padding border-left-right">
							<div class="row">
								<div class="col-sm-12">
									<input type="file" id="archivoInput" name="foto" onchange="return validarExt()"  />
									<input name="foto_original" type="hidden" value="{{$empresa->foto}}" />
									<div id="visorArchivo" class="responsive">
										<!--Aqui se desplegará el fichero-->
										<center ><img  style="  width: 35%;height:auto;background-size: contain;border-radius: 5px; padding: 10px;"  src="{{ asset('/multimedia/empresa/')}}/{{$empresa->foto}}"  /></center>
									</div>
								</div>
							</div>
						</div>
						<div class="ibox-content profile-content">
							<div class="row"><div class="col-sm-6"><input name="nombre" type="text" value="{{$empresa->nombre}}" class="form-control"></div><div class="col-sm-1">RUC:</div><div class="col-sm-5"><input name="ruc" type="text" value="{{$empresa->ruc}}" class="form-control"></div></div>

							<div class="row" style="padding-top: 20px">
								<div class="col-sm-1"><i class="fa fa-map-marker"></i></div>
								<div class="col-sm-3"><input name="pais" type="text" class="form-control" value="{{$empresa->pais}}"></div>
								<div class="col-sm-1">-</div>
								<div class="col-sm-3"><input name="departamento" type="text" class="form-control" value="{{$empresa->departamento}}"></div>
								<div class="col-sm-1">-</div>
								<div class="col-sm-3"><input name="distrito" type="text" class="form-control" value="{{$empresa->distrito}}"></div>
							</div>
							<h5>Sobre mi:</h5>
							<textarea class="form-control" name="descripcion">{{$empresa->descripcion}}</textarea>
							<div class="row m-t-lg" align="center">
								<div class="col-md-3">
									<span class="bar"><img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/celular.svg')}}"> <input name="celular" type="text" value="{{$empresa->celular}}" class="form-control" style="text-align: center;"></span>
								</div>
								<div class="col-md-3">
									<span class="bar"><img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/telefono.svg')}}"> <input name="telefono" type="text" value="{{$empresa->telefono}}" class="form-control" style="text-align: center;"></span>
								</div>
								<div class="col-md-6">
									<span class="bar"><img alt="image" width="25px" class="iconos_perfil" src="{{asset('multimedia/pagina_web.svg')}}"> <input name="pagina_web" type="text" value="{{$empresa->pagina_web}}" class="form-control" style="text-align: center;"></span>
								</div>
							</div>
							<div class="row" style="padding-top: 25px;">
								<div class="col-md-12"><button style="width: 150px" name="boton" value="empresa" class="btn btn-primary btn-sm btn-block"><i class="fa fa-edit"></i>Editar</button></div>

							</div>
						</div>
					</div>
				</form>

				<!-- FIN Formulario Empresa -->
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

	<!-- Notificacion de Errores -->
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
	<!-- FIN Notificacion de Errores -->

	<!-- foto previzualizar -->
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
					'<center><img name="foto" src="'+e.target.result+'" style=" width: 35%;background-size: contain;border-radius: 5px; padding: 10px;" /></center>';
				};
				visor.readAsDataURL(archivoInput.files[0]);
			}
		}
	</script>
	<!-- FIN foto previzualizar -->


	<!-- Formulario Cambio de vista a Formulario-->
	<script>
		function editar_correo() {
			var vista_correo = document.getElementById("vista_correo");
			var form_correo = document.getElementById("form_correo");
			var boton_correo= document.getElementById("boton_correo");


			var vista_empresa= document.getElementById("vista_empresa");
			var form_empresa= document.getElementById("form_empresa");
			var boton_empresa= document.getElementById("boton_empresa");

			if( vista_correo.hasAttribute("hidden") )
			{
				vista_correo.removeAttribute("hidden", "");

				boton_correo.innerHTML='<img alt="image" width="25px"  src="{{asset('multimedia/editar.svg')}}">';
				form_correo.setAttribute("hidden", "");
			}
			else{
				vista_correo.setAttribute("hidden", "");
				vista_empresa.removeAttribute("hidden", "");/*Remueve los formularios abiertos*/

				boton_correo.innerHTML='<img alt="image" width="25px"  src="{{asset('multimedia/cancelar.svg')}}">';
				boton_empresa.innerHTML='<img alt="image" width="25px"  src="{{asset('multimedia/editar.svg')}}">';


				form_correo.removeAttribute("hidden", "");
				form_empresa.setAttribute("hidden", "");
			}
		}
		function editar_empresa() {
			if( vista_empresa.hasAttribute("hidden") )
			{
				vista_empresa.removeAttribute("hidden", "");

				boton_empresa.innerHTML='<img alt="image" width="25px"  src="{{asset('multimedia/editar.svg')}}">';

				form_empresa.setAttribute("hidden", "");
			}
			else{
				vista_empresa.setAttribute("hidden", "");
				vista_correo.removeAttribute("hidden", "");/*Remueve los formularios abiertos*/

				boton_empresa.innerHTML='<img alt="image" width="25px"  src="{{asset('multimedia/cancelar.svg')}}">';
				boton_correo.innerHTML='<img alt="image" width="25px"  src="{{asset('multimedia/editar.svg')}}">';

				form_empresa.removeAttribute("hidden", "");
				form_correo.setAttribute("hidden", "");
			}
		}
	</script>
	<!-- Fin Formulario Cambio de vista a Formulario-->
	@endsection