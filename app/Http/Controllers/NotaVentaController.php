<?php
namespace App\Http\Controllers;
use App\CertificadoSsl;
use App\Dominios;
use App\Empresa;
use App\Hosting;
use App\Licencia;
use App\NotasPago;
use App\SoporteTecnico;
use App\TicketsAgregado;
use App\User;
use Barryvdh\DomPDF\Facade as PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Swift_Attachment;
use Swift_MailTransport;
use Swift_Mailer;
use Swift_Message;
use Swift_Preferences;
use Swift_SmtpTransport;

class NotaVentaController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

       public function index()
       {
        if (auth()->user()->roles_id == 3){return back();}/*Clientes no entran*/

        $empresa=Empresa::first();
        $clientes=User::where('roles_id',3)->get();
        return view('nota_venta.index',compact('clientes','empresa'));

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
      $usuario_logeado=auth()->user()->id;
      $empresa=Empresa::first();
      $cliente=User::where('id',$id)->first();


      $ticket=$request->get('ticket');
      $hosting=$request->get('hosting');
      $dominio=$request->get('dominio');
      $certificadossl=$request->get('certificadossl');
      $soporte=$request->get('soporte');
      $licencia=$request->get('licencia');
      $cantidad_hosting=0;
      $cantidad_dominio=0;
      $cantidad_certi_ssl=0;
      $cantidad_soporte=0;
      $cantidad_licencia=0;

      if (empty($ticket) & empty($hosting) & empty($soporte) & empty($dominio) & empty($certificadossl) & empty($licencia))/*Si ninguno esta Seleccionado*/
        {return Redirect::to('/nota_venta')->withErrors(['No has Seleccionado Ninguna Nota de Venta']);}
      else{

        /*Hosting Pregunta si ya esta Pagado*/
        if (isset($hosting))
        {
         $hosting_count = count($hosting);
         for ($i=0; $i <  $hosting_count ; $i++)
           {$hosting_impresion[] = Hosting::where('id',$hosting[$i])->first();}
         foreach ($hosting_impresion as $index => $hosting_impresions) {
          if ($hosting_impresions->estado_pagado==1){$cantidad_hosting=1;}
        }
      }

      /*Dominio Pregunta si ya esta Pagado*/
      if (isset($dominio)) {
        $dominio_count = count($dominio);

        for ($i=0; $i <  $dominio_count ; $i++) {
          $dominio_impresion[] = Dominios::where('id',$dominio[$i])->first();
        }
        foreach ($dominio_impresion as $index => $dominio_impresions) {
          if ($dominio_impresions->estado_pagado==1){$cantidad_dominio=1;}
        }
      }

      /*Certificado Pregunta si ya esta Pagado*/
      if (isset($certificadossl)) {
        $certificadossl_count = count($certificadossl);

        for ($i=0; $i <  $certificadossl_count ; $i++) {
          $certificadossl_impresion[] = CertificadoSsl::where('id',$certificadossl[$i])->first();
        }
        foreach ($certificadossl_impresion as $index => $certificadossl_impresions) {
          if ($certificadossl_impresions->estado_pagado==1){$cantidad_certi_ssl=1;}

        }
      }

      /*Soporte Pregunta si ya esta Pagado*/
      if (isset($soporte)) {
        $soporte_count = count($soporte);

        for ($i=0; $i <  $soporte_count ; $i++) {
          $soporte_imprension[] = SoporteTecnico::where('id',$soporte[$i])->first();
        }
        foreach ($soporte_imprension as $index => $soporte_imprensions) {
          if ($soporte_imprensions->estado_pagado==1){$cantidad_soporte=1;}

        }
      }
      /*Certificado Pregunta si ya esta Pagado*/
      if (isset($licencia)) {
        $licencia_count = count($licencia);

        for ($i=0; $i <  $licencia_count ; $i++) {
          $licencia_impresion[] = Licencia::where('id',$licencia[$i])->first();
        }
        foreach ($licencia_impresion as $index => $licencia_impresions) {
          if ($licencia_impresions->estado_pagado==1){$cantidad_licencia=1;}

        }
      }

      $repetidos=$cantidad_hosting+$cantidad_dominio+$cantidad_certi_ssl+$cantidad_soporte;

      if ($repetidos>=1) {
        return Redirect::to('/nota_venta')->withErrors(['Los Registros ya fueron Generados']);
      }
      else{

       if (isset($hosting)){
         for ($i=0; $i <  $hosting_count ; $i++)
         {
          $cambio_hosting=Hosting::find($hosting[$i]);
          $cambio_hosting->estado_pagado=1;
          $cambio_hosting->save();
        }

      }

      if (isset($dominio)) {
       for ($i=0; $i <  $dominio_count ; $i++) {
        $cambio_dominio=Dominios::find($dominio[$i]);
        $cambio_dominio->estado_pagado=1;
        $cambio_dominio->save();
      }

    }

    if (isset($certificadossl)) {
      for ($i=0; $i <  $certificadossl_count ; $i++) {
        $cambio_certificadossl=CertificadoSsl::find($certificadossl[$i]);
        $cambio_certificadossl->estado_pagado=1;
        $cambio_certificadossl->save();
      }
    }

    if (isset($soporte)) {
      for ($i=0; $i <  $soporte_count ; $i++) {
        $soporte=SoporteTecnico::find($soporte[$i]);
        $soporte->estado_pagado=1;
        $soporte->save();
      }
    }
    if (isset($licencia)) {
      for ($i=0; $i <  $licencia_count ; $i++) {
        $cambio_licencia=Licencia::find($licencia[$i]);
        $cambio_licencia->estado_pagado=1;
        $cambio_licencia->save();
      }
    }


  }
  $boton_venta=$request->get('boton_venta');
  $email_envio=$request->get('email_envio');



  /*Registrar Notas Pago*/
  $notas_p=NotasPago::all()->count();
  $cantidad_registro=str_pad($notas_p+1, 8, "0", STR_PAD_LEFT);
  $codigo_pago='N°'.'-'.$cantidad_registro;

  $notas_pago= new NotasPago;
  $notas_pago->codigo_nota=$codigo_pago;
  $notas_pago->cliente=$cliente->id;
  $notas_pago->nombre_archivo=$codigo_pago;
  $notas_pago->user_registrado=$usuario_logeado;
  $notas_pago->estado=0;
  if ($boton_venta=='productos') {
    $notas_pago-> save();
    /*Registrar Notas Pago*/

    if ($email_envio=='0') {
      $archivo=$codigo_pago.".pdf";
      $pdf=PDF::loadView('nota_venta.producto_pago_pdf',compact('cliente','empresa','hosting_impresion','dominio_impresion','certificadossl_impresion','soporte_imprension','licencia_impresion','codigo_pago'));
      $content=$pdf->download();
      Storage::disk('notas_pago')->put($archivo,$content);
    }
  }




  /*config mensaje gmail*/
  $empresa=Empresa::first();
  $asunto_mensaje='NOTA DE VENTA';
  $nombre_empresa=$empresa->nombre;
  $correo_empresa=$empresa->correo;
  $contraseña_empresa=$empresa->contrasena;
  $encryption=$empresa->encryption;
  $smpt=$empresa->smpt;
  $puerto=$empresa->puerto;

  /* Fin config mensaje gmail*/

  /*Envio de Correo de codigo*/
  $mensaje=  view('html_sms.sms_nota_pagado_producto',compact('cliente','empresa','hosting_impresion','licencia_impresion','dominio_impresion','certificadossl_impresion','soporte_imprension','codigo_pago'));
  $transport=(new Swift_SmtpTransport( $smpt ,$puerto,$encryption))->setUsername($correo_empresa)->setPassword($contraseña_empresa);
  $mailer = new Swift_Mailer($transport);
  $message = (new Swift_Message($asunto_mensaje))->setFrom([$correo_empresa=> $nombre_empresa])->setTo([$cliente->email])->setBody($mensaje, 'text/html');

  if ($boton_venta=='productos') {
    if ($email_envio=='0') {
      $notas_pago-> save(); $result = $mailer->send($message);
    }
      // return response()->json(['mensaje'=>'Se envio biewn']);
  }
  /*Fin Envio de Correo de codigo*/

  if ($boton_venta=='ticket') {
    // return $ticket;
    $ticket_count = count($ticket);
    for ($i=0; $i <  $ticket_count ; $i++) {
      $ticket=TicketsAgregado::find($ticket[$i]);
      $ticket->estado_pagado=1;
      $ticket->save();
    }
  }



  // return view('nota_venta.producto_pago_pdf',compact('cliente','empresa','hosting_impresion','dominio_impresion','certificadossl_impresion','codigo_pago'));
  // $pdf=PDF::loadView('nota_venta.producto_pago_pdf',compact('cliente','empresa','hosting_impresion','dominio_impresion','certificadossl_impresion','codigo_pago'));
  // return $pdf->download('ss.pdf');
  return redirect()->route('nota_venta.index');


}

}

}
