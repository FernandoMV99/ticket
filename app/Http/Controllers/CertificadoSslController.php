<?php
namespace App\Http\Controllers;
use App\AlertasCorreo;
use App\CertificadoSsl;
use App\Dominios;
use App\Empresa;
use App\Moneda;
use App\Motivo;
use App\PlanCertificadoSsl;
use App\ProveedorDominios;
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

class CertificadoSslController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      $user_logeado=auth()->user()->id;
        // $tickets_agregado=TicketsAgregado::all();
      $dominios_cliente=Dominios::where('cliente',auth()->user()->id)->get();
      $dominios=Dominios::all();
      $certificados_ssl_cliente=CertificadoSsl::where('cliente',$user_logeado)->get();
      $certificados_ssl=CertificadoSsl::all();
      $plan_ssl=PlanCertificadoSsl::where('estado',0)->get();
      $monedas=Moneda::all();
      $clientes=User::orderBy('name')->where('roles_id','3')->get();
      $proveedores=ProveedorDominios::orderBy('nombre')->where('estado','1')->get();
      foreach ($certificados_ssl as $certificados_ssls) {
        $date = $certificados_ssls->fecha_vencimiento."+ 1 days";
        $datework = Carbon::createFromDate($date);
        $now = Carbon::now();
        if ($datework>$now) {$testdate=$now->diffInDays($datework);}
        else{$testdate= 0;}

        if ($testdate<1){$estado='1';}
        else{$estado='0';}


           //Cambio de Estado
        if ($certificados_ssls->estado_anulado=='0') {
          $certificados_edit=CertificadoSsl::find($certificados_ssls->id);
          $certificados_edit->estado=$estado;
          $certificados_edit-> save();
        }
            //Cambio de Estado

      }
      if (auth()->user()->roles_id==3) {
        return view('productos.certificados.ssl.index_cliente',compact('dominios','clientes','proveedores','monedas','dominios_cliente','plan_ssl','certificados_ssl','certificados_ssl_cliente'));
      }else{
        return view('productos.certificados.ssl.index',compact('dominios','clientes','proveedores','monedas','dominios_cliente','plan_ssl','certificados_ssl'));
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
     $usuario_logeado=auth()->user()->id;

     $num_años=$request->get('fecha_vencimiento');
     $fecha_compra=$request->get('fecha_compra');
     $date = $fecha_compra."+ ".$num_años." years";
     $fecha_vencimiento = Carbon::createFromDate($date);
     $fecha_vencimiento=substr($fecha_vencimiento, 0, -8);



     $plan_certificado_ssl=$request->get('plan_certificado_ssl');
     $planes=PlanCertificadoSsl::where('id',$plan_certificado_ssl)->first();

     $this->validate($request,[
      'nombre_dominio' => ['required','unique:certificado_ssl,nombre_dominio'],
    ],[
      'nombre_dominio.unique' => 'El Dominio ya esta registrado',
      'nombre_dominio.required' => 'Es Necesario el Dominio',
    ]);

     $certificados_ssl= new CertificadoSsl;
     $certificados_ssl->cliente=$request->get('cliente');
     $certificados_ssl->proveedor=$request->get('proveedor');
     $certificados_ssl->fecha_compra=$request->get('fecha_compra');
     $certificados_ssl->fecha_vencimiento=$fecha_vencimiento;
     $certificados_ssl->nombre_dominio=$request->get('nombre_dominio');
     $certificados_ssl->plan_certificado_ssl=$request->get('plan_certificado_ssl');
     $certificados_ssl->precio=$request->get('precio');
     $certificados_ssl->moneda=$request->get('moneda');
     $certificados_ssl->descripcion=$request->get('descripcion');
     $certificados_ssl->estado='0';
     $certificados_ssl->moneda=$planes->moneda;
     $certificados_ssl->precio=$planes->precio*$num_años;
     $certificados_ssl->anos=$num_años;
     $certificados_ssl->estado_anulado=0;
     $certificados_ssl->user_registrado=$usuario_logeado;
     $certificados_ssl-> save();


     /*config mensaje gmail*/
     $empresa=Empresa::first();
     $asunto_mensaje='NOTA DEUDA CERTIFICADO';
     $nombre_empresa=$empresa->nombre;
     $correo_empresa=$empresa->correo;
     $contraseña_empresa=$empresa->contrasena;
     $encryption=$empresa->encryption;
     $smpt=$empresa->smpt;
     $puerto=$empresa->puerto;

     $cliente=User::where('id',$certificados_ssl->cliente)->first();
     /* Fin config mensaje gmail*/

     /*Guardando su proximas Notificaciones*/
     $date1 = $fecha_vencimiento."- 15 days";
     $fecha_vencimiento1 = Carbon::createFromDate($date1);
     $fecha_vencimiento1=substr($fecha_vencimiento1, 0, -8);

     $date2 = $fecha_vencimiento."- 7 days";
     $fecha_vencimiento2 = Carbon::createFromDate($date2);
     $fecha_vencimiento2=substr($fecha_vencimiento2, 0, -8);

     $alertas_correo= new AlertasCorreo;
     $alertas_correo->usuario=$certificados_ssl->cliente;
     $alertas_correo->fecha1=$fecha_vencimiento1;
     $alertas_correo->fecha2=$fecha_vencimiento2;
     $alertas_correo->fecha3=$certificados_ssl->fecha_vencimiento;
     $alertas_correo->nombre_html_sms='sms_nota_deuda_producto';
     $alertas_correo->nombre_modelo='CertificadoSsl';
     $alertas_correo->id_registro=$certificados_ssl->id;
     $alertas_correo->save();

     /*Guardando su proximas Notificaciones*/

     $email_envio=$request->get('email_envio');
     if ($email_envio==0) {
      /*Envio de Correo de codigo*/
      $mensaje=  view('html_sms.sms_nota_deuda_producto',compact('empresa','certificados_ssl','cliente'));
      $transport=(new Swift_SmtpTransport( $smpt ,$puerto,$encryption))->setUsername($correo_empresa)->setPassword($contraseña_empresa);
      $mailer = new Swift_Mailer($transport);
      $message = (new Swift_Message($asunto_mensaje))->setFrom([$correo_empresa=> $nombre_empresa])->setTo([$cliente->email])->setBody($mensaje, 'text/html');
      $result = $mailer->send($message);
      /*Fin Envio de Correo de codigo*/
    }

    return redirect()->route('certificado_ssl.index');

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
     $certificado = CertificadoSsl::where('id',$id)->first();
     // return $certificado->estado_anulado;

     if ($boton=='Renovar') {
      /*No permite hacer cambios si es que antes se a Anulado*/
      if ($certificado->estado_anulado==1) {
       return Redirect::to('/certificado_ssl')->withErrors(['El Registro esta Anulado']);
     }
     /*No permite hacer cambios si es que antes se a Anulado*/

     $plan_certificado_id=$request->get('plan_certificado_id');

     $plan_ssl=PlanCertificadoSsl::where('id',$plan_certificado_id)->first();


     $num_años=$request->get('fecha_vencimiento');
     $date = $certificado->fecha_vencimiento."+ ".$num_años." years";
     $fecha_vencimiento = Carbon::createFromDate($date);
     $fecha_vencimiento=substr($fecha_vencimiento, 0, -8);

     $certificados_ssl=CertificadoSsl::find($id);
     $certificados_ssl->plan_certificado_ssl=$plan_certificado_id;
     $certificados_ssl->fecha_compra=$certificado->fecha_vencimiento;
     $certificados_ssl->fecha_vencimiento=$fecha_vencimiento;
     $certificados_ssl->anos=$num_años;
     $certificados_ssl->precio=$num_años*$plan_ssl->precio;
     $certificados_ssl->estado=0;
     $certificados_ssl->estado_pagado=0;
     $certificados_ssl->save();
   }
   elseif ($boton=='Actualizar') {
    /*No permite hacer cambios si es que antes se a Anulado*/
    if ($certificado->estado_anulado==1) {
     return Redirect::to('/certificado_ssl')->withErrors(['El Registro esta Anulado']);
   }
   /*No permite hacer cambios si es que antes se a Anulado*/

   $plan_ssl=PlanCertificadoSsl::where('id',$request->get('plan_certificado_ssl'))->first();

   $num_años=$request->get('fecha_vencimiento');
   $date = $certificado->fecha_compra."+ ".$num_años." years";
   $fecha_vencimiento = Carbon::createFromDate($date);
   $fecha_vencimiento=substr($fecha_vencimiento, 0, -8);

   $certificados_ssl=CertificadoSsl::find($id);
   $certificados_ssl->fecha_vencimiento=$fecha_vencimiento;
   $certificados_ssl->proveedor= $request->get('proveedor');
   $certificados_ssl->anos= $num_años;
   $certificados_ssl->precio= $plan_ssl->precio*$num_años;
   if ($plan_ssl->id!=$certificado->plan_certificado_ssl or $certificado->anos!=$num_años) {
    $certificados_ssl->estado_pagado=0;
  }
  $certificados_ssl->plan_certificado_ssl= $request->get('plan_certificado_ssl');
  $certificados_ssl->descripcion= $request->get('descripcion');
  $certificados_ssl->save();


}
elseif ($boton=='Anulado') {
  $dominio=CertificadoSsl::find($id);
  $dominio->estado='1';
  $dominio->estado_anulado='1';
  $dominio->save();

}

return redirect()->route('certificado_ssl.index');

}

}
