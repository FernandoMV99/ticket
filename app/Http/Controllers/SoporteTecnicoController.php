<?php
namespace App\Http\Controllers;
use App\AlertasCorreo;
use App\Cliente;
use App\Dominios;
use App\Empresa;
use App\Equipos;
use App\Hosting;
use App\Moneda;
use App\Motivo;
use App\PlanHosting;
use App\PlanSoporteTecnico;
use App\ProveedorDominios;
use App\SoporteTecnico;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Swift_Attachment;
use Swift_MailTransport;
use Swift_Mailer;
use Swift_Message;
use Swift_Preferences;
use Swift_SmtpTransport;
class SoporteTecnicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      // if (auth()->user()->roles_id == 3){return back();}/*Clientes no entran*/
      $user_logeado=auth()->user();
      $soporte_tecnico_cliente=SoporteTecnico::where('cliente',$user_logeado->id)->where('estado_anulado',0)->get();
      $soporte_tecnico=SoporteTecnico::all();
      $plan_soporte=PlanSoporteTecnico::all();
      $moneda=Moneda::all();
      $clientes=User::orderBy('name')->where('roles_id','3')->get();

      foreach ($soporte_tecnico as $soporte_tecnicos) {
        $date = $soporte_tecnicos->fecha_vencimiento."+ 1 days";
        $datework = Carbon::createFromDate($date);
        $now = Carbon::now();
        if ($datework>$now) {$testdate=$now->diffInDays($datework);}
        else{$testdate= 0;}

        if ($testdate<1){$estado='1';}
        else{$estado='0';}

            //Cambio de Estado
        if ($soporte_tecnicos->estado_anulado=='0') {
          $soporte_tecnicos=SoporteTecnico::find($soporte_tecnicos->id);
          $soporte_tecnicos->estado=$estado;
          $soporte_tecnicos-> save();
        }

      }
      // return $testdate;
      /*Clientes*/
      if ($user_logeado->roles_id==3) {
        return view('soporte_tecnico.soporte_tecnico.index_cliente',compact('soporte_tecnico','clientes','plan_soporte','moneda','soporte_tecnico_cliente'));
      }else{
        return view('soporte_tecnico.soporte_tecnico.index',compact('soporte_tecnico','clientes','plan_soporte','moneda'));
      }


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $user_logeado=auth()->user()->id;
      $cliente=$request->get('cliente');
      $cliente_existente=SoporteTecnico::where('cliente',$cliente)->where('estado_anulado',0)->first();

      if (isset($cliente_existente)) {
        return Redirect::to('/soporte_tecnico')->withErrors(['El Soporte ya esta registrado']);
      }

      $num_meses=$request->get('fecha_vencimiento');
      $fecha_inicio=$request->get('fecha_inicio');
      $date = $fecha_inicio."+ ".$num_meses."month";
      $fecha_vencimiento = Carbon::createFromDate($date);
      $fecha_vencimiento=substr($fecha_vencimiento, 0, -8);

// return $fecha_vencimiento;

      $soporte_tecnico= new SoporteTecnico;
      $soporte_tecnico->cliente=$request->get('cliente');
      $soporte_tecnico->plan_soporte=$request->get('plan_soporte');
      $soporte_tecnico->fecha_inicio=$request->get('fecha_inicio');
      $soporte_tecnico->cantidad_equipos=$request->get('cantidad_equipos');
      $soporte_tecnico->moneda=$request->get('moneda');
      $soporte_tecnico->precio=$request->get('precio');
      $soporte_tecnico->descripcion=$request->get('descripcion');
      $soporte_tecnico->fecha_vencimiento=$fecha_vencimiento;
      $soporte_tecnico->anos=$num_meses;
      $soporte_tecnico->user_registrado=$user_logeado;
      $soporte_tecnico->save();

      /*config mensaje gmail*/
      $empresa=Empresa::first();
      $asunto_mensaje='NOTA DEUDA SOPORTE TECNICO';
      $nombre_empresa=$empresa->nombre;
      $correo_empresa=$empresa->correo;
      $contraseña_empresa=$empresa->contrasena;
      $encryption=$empresa->encryption;
      $smpt=$empresa->smpt;
      $puerto=$empresa->puerto;

      $cliente=User::where('id',$soporte_tecnico->cliente)->first();

      /* Fin config mensaje gmail*/

       /*Guardando su proximas Notificaciones*/
     $date1 = $fecha_vencimiento."- 15 days";
     $fecha_vencimiento1 = Carbon::createFromDate($date1);
     $fecha_vencimiento1=substr($fecha_vencimiento1, 0, -8);

     $date2 = $fecha_vencimiento."- 7 days";
     $fecha_vencimiento2 = Carbon::createFromDate($date2);
     $fecha_vencimiento2=substr($fecha_vencimiento2, 0, -8);

     $alertas_correo= new AlertasCorreo;
     $alertas_correo->usuario=$soporte_tecnico->cliente;
     $alertas_correo->fecha1=$fecha_vencimiento1;
     $alertas_correo->fecha2=$fecha_vencimiento2;
     $alertas_correo->fecha3=$soporte_tecnico->fecha_vencimiento;
     $alertas_correo->nombre_html_sms='sms_nota_deuda_producto';
     $alertas_correo->nombre_modelo='SoporteTecnico';
     $alertas_correo->id_registro=$soporte_tecnico->id;
     $alertas_correo->save();

     /*Guardando su proximas Notificaciones*/


      $email_envio=$request->get('email_envio');
      if ($email_envio==0) {
        /*Envio de Correo de codigo*/
        $mensaje=  view('html_sms.sms_nota_deuda_producto',compact('empresa','soporte_tecnico','cliente'));
        $transport=(new Swift_SmtpTransport( $smpt ,$puerto,$encryption))->setUsername($correo_empresa)->setPassword($contraseña_empresa);
        $mailer = new Swift_Mailer($transport);
        $message = (new Swift_Message($asunto_mensaje))->setFrom([$correo_empresa=> $nombre_empresa])->setTo([$cliente->email])->setBody($mensaje, 'text/html');
        $result = $mailer->send($message);
        /*Fin Envio de Correo de codigo*/
      }


      return redirect()->route('soporte_tecnico.index');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      $boton=$request->get('boton');

      if ($boton=='Actualizar') {
        $num_anos=$request->get('fecha_vencimiento');
        $fecha_inicio=$request->get('fecha_inicio');
        $date = $fecha_inicio."+ ".$num_anos." month";
        $fecha_vencimiento = Carbon::createFromDate($date);
        $fecha_vencimiento=substr($fecha_vencimiento, 0, -8);

        $soporte=SoporteTecnico::where('id',$id)->first();

        $soporte_tecnico=SoporteTecnico::find($id);
        $soporte_tecnico->plan_soporte=$request->get('plan_soporte');
        $soporte_tecnico->fecha_vencimiento=$fecha_vencimiento;
        $soporte_tecnico->cantidad_equipos=$request->get('cantidad_equipos');

        if ($soporte->moneda!=$request->get('moneda') or $soporte->precio!=$request->get('precio') ) {
          $soporte_tecnico->estado_pagado=0;
        }
        $soporte_tecnico->moneda=$request->get('moneda');
        $soporte_tecnico->precio=$request->get('precio');
        $soporte_tecnico->descripcion=$request->get('descripcion');
        $soporte_tecnico->anos=$num_anos;
        $soporte_tecnico->save();

      }
      elseif ($boton=='Anulado') {
        $soporte=SoporteTecnico::find($id);
        $soporte->estado='1';
        $soporte->estado_anulado='1';
        $soporte->save();

        $equipo_select=Equipos::where('cliente',$soporte->cliente)->get();
        foreach ($equipo_select as $edit_equipo ) {
          $equipo=Equipos::find($edit_equipo->id);
          $equipo->estado_soporte='1';
          $equipo->save();
        }
      }

      elseif ($boton=='Renovar') {
        $soporte_tecnico=SoporteTecnico::where('id',$id)->first();

        $num_anos=$request->get('fecha_vencimiento');
        $date = $soporte_tecnico->fecha_vencimiento."+ ".$num_anos." month";
        $fecha_vencimiento = Carbon::createFromDate($date);
        $fecha_vencimiento=substr($fecha_vencimiento, 0, -8);

        $soporte=SoporteTecnico::find($id);
        $soporte->plan_soporte=$request->get('plan_soporte');
        $soporte->fecha_inicio=$soporte_tecnico->fecha_vencimiento;
        $soporte->fecha_vencimiento=$fecha_vencimiento;
        $soporte->cantidad_equipos=$request->get('cantidad_equipos');
        $soporte->anos=$num_anos;
        $soporte->moneda=$request->get('moneda');
        $soporte->precio=$request->get('precio');
        $soporte->estado_pagado=0;
        $soporte->save();

      }
      elseif ($boton=='Equipos') {

        $id_equipo=$request->get('id_equipo');
        $equipo_select=$request->get('equipo_select');
        $suma=array_sum($equipo_select);


        for($i=0; $i<count($id_equipo); $i++){
          $equipo=Equipos::find($id_equipo[$i]);
          $equipo->estado_soporte=$equipo_select[$i];
          $equipo->save();
        }
        $soporte=SoporteTecnico::find($id);
        $soporte->cantidad_equipos_asignados=count($equipo_select)-$suma;
        $soporte->save();
      }
      return redirect()->route('soporte_tecnico.index');
    }

  }
