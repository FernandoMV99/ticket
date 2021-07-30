<?php

namespace App\Http\Controllers;

use App\ActividadUser;
use App\AlertasCorreo;
use App\CertificadoSsl;
use App\Dominios;
use App\Empresa;
use App\Equipos;
use App\Hosting;
use App\Licencia;
use App\TicketsAgregado;
use App\TicketsRespuesta;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user_logeado=auth()->user();
        $empresa=Empresa::first();
        $date= date('d/m/y');
        $date_vencimiento= date('Y-m-d');
        // return $date_vencimiento;

        /*Ingreso Diario Control*/
        $ingreso_diario=ActividadUser::where('usuario',$user_logeado->id)->first();
        if (empty($ingreso_diario)) {
            $ingreso_diario= new ActividadUser;
            $ingreso_diario->usuario=$user_logeado->id;
            $ingreso_diario->fecha=$date;
            $ingreso_diario->cantidad='1';
            $ingreso_diario->user_registrado=$user_logeado->id;
            $ingreso_diario->save();
        }elseif(isset($ingreso_diario) and $ingreso_diario->fecha != $date ){
            $ingreso_diario=ActividadUser::find($ingreso_diario->id);
            $ingreso_diario->cantidad=$ingreso_diario->cantidad+1;
            $ingreso_diario->fecha=$date;
            $ingreso_diario->save();
        }
        /*Ingreso Diario Control*/

        /*Cantidades*/
        $count_equipos=Equipos::where('cliente',$user_logeado->id)->count();
        $count_tickets_agregado=TicketsAgregado::where('cliente',$user_logeado->id)->count();
        $suma_deuda_tickets_agregado=TicketsAgregado::where('cliente',$user_logeado->id)->sum('precio');
        $mensaje_tickets_respuesta=TicketsRespuesta::where('cliente',$user_logeado->id)->where('trabajador',true)->where('estado_id',1)->get();
        $count_mensaje_tickets_respuesta=TicketsRespuesta::where('cliente',$user_logeado->id)->where('trabajador',true)->where('estado_id',1)->count();
        /*Cantidades*/

        /*Proximos a Vencer*/
        $hosting=Hosting::where('cliente',$user_logeado->id)->where('estado_anulado',0)->get();
        $dominio=Dominios::where('cliente',$user_logeado->id)->where('estado_anulado',0)->get();
        $licencia=Licencia::where('cliente',$user_logeado->id)->where('estado_anulado',0)->get();
        $certificado=CertificadoSsl::where('cliente',$user_logeado->id)->where('estado_anulado',0)->get();

        /*Proximos a Vencer*/

        if ($user_logeado->roles_id == 3) /*Si es Cliente te lleva aca*/
        {
            return view('inicio.home_cliente',compact('user_logeado','count_tickets_agregado','count_equipos','suma_deuda_tickets_agregado','mensaje_tickets_respuesta','count_mensaje_tickets_respuesta','ingreso_diario','empresa','hosting','date_vencimiento','dominio','licencia','certificado'));
        }
        if ($user_logeado->roles_id == 1)
        {
            return view('inicio.home');
        }
    }
}
