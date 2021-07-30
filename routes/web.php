<?php

use App\Http\Controllers\MarcasController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
// 	return view('welcome');
// });
Route::group(
	[ 'middleware' => ['auth']],
	function(){

		//TICKET
		Route::resource('/motivos','MotivosController');
		Route::resource('/tickets','TicketsController');
		Route::resource('/tickets_respuesta','TicketsRespuestaController');
		Route::get('/ticket/pagos_pendientes','TicketsController@pagos_pendientes')->name('tickets.pagos_pendiente');

		//USUARIO
		Route::resource('/usuario','UserController')->except(['destroy']);
		Route::post('/usuario/confirmar_email','UserController@confirmar_email')->name('usuario.confirmar_email');

		//EMPRESA
		Route::resource('/empresa','EmpresaController')->only(['index','update']);

		//PRODUCTOS
			//Certificado SSL
		Route::resource('/plan_certicado_ssl','PlanCertificadoSslController')->only(['index','update','store']);
		Route::resource('/certificado_ssl','CertificadoSslController')->only(['index','update','store']);
			//Hosting
		Route::resource('/planes_hosting','PlanHostingController')->only(['index','update','store']);
		Route::resource('/hosting','HostingController')->only(['index','update','store']);
		Route::resource('/hosting_correos','HostingCorreosController')->only(['index','update','store']);
			//Dominios
		Route::resource('/proveedor_dominio','ProveedorDominiosController')->only(['index','update','store']);
		Route::resource('/plan_dominio','PlanDominioController')->only(['index','update','store']);
		Route::resource('/dominios','DominiosController')->only(['index','update','store']);
			//Licenciada
		Route::get('equipo_cliente','LicenciaController@equipo_cliente');
		Route::resource('/categoria','CategoriaLicenciaController')->only(['index','update','store']);
		Route::resource('/licencia','LicenciaController')->only(['index','update','store']);

		//SOPORTE TECNICO
		Route::resource('/plan_soporte_tecnico','PlanSoporteTecnicoController')->except(['destroy']);
		Route::resource('/soporte_tecnico','SoporteTecnicoController')->except(['destroy']);

		//EQUIPOS
		Route::resource('/equipos','EquiposController')->except(['destroy']);
		Route::resource('/software_equipos','SoftwareEquipoController')->except(['destroy']);
		Route::resource('/tipo_equipo','TipoEquipoController')->except(['destroy','show']);
		Route::resource('/marcas','MarcasController')->except(['destroy','show']);

		//NOTA VENTA
		Route::resource('/nota_venta','NotaVentaController')->only(['index','update','show']);


		// Route::get('/', 'HomeController@index')->name('home');
		Route::get('/', 'HomeController@index');
	});
Auth::routes();



	// Route::resource('/','LayoutController');
