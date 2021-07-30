<?php
namespace App\Http\Controllers;
use App\Hosting;
use App\HostingCorreos;
use App\Motivo;
use Illuminate\Http\Request;

class HostingCorreosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (auth()->user()->roles_id == 3){return back();}/*Clientes no entran*/
      $motivos=Motivo::all();
      return view('tickets.motivos.index',compact('motivos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

      $usuario_logeado=auth()->user()->id;

      $hosting_id=$request->get('hosting_id');
      $hosting=Hosting::where('id',$hosting_id)->first();
      $servidor='mail.'.substr($hosting->dominio, 4);

      $email=$request->get('email');
      $password=$request->get('password');

      for($i=0; $i<count($email); $i++){
        $motivos= new HostingCorreos;
        $motivos->hosting_id=$hosting_id;
        $motivos->correo=$email[$i].'@'.substr($hosting->dominio, 4);
        $motivos->contrasena=$password[$i];
        $motivos->servidor_entrante=$servidor;
        $motivos->servidor_salida=$servidor;
        $motivos->user_registrado=$usuario_logeado;
        $motivos-> save();
      }

      return redirect()->route('hosting.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
     // $tickets_agregado=TicketsAgregado::find($id);
     // $tickets_agregado->estado_id='2';
     // $tickets_agregado->save();
     // $tickets_agregado=TicketsAgregado::where('id',$id)->first();
     // $tickets_respuesta=TicketsRespuesta::where('ticket_agregado_id',$id)->get();
     // $archivos_agregados=Archivos::where('tabla_id_bd',$id)->where('tabla_bd','tickets_agregado')->get();
     // $archivos_respuesta=Archivos::where('tabla_bd','tickets_respuesta')->get();
     // return view('tickets.show',compact('tickets_agregado','tickets_respuesta','archivos_agregados','archivos_respuesta'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(Request $request, $id)
    {
      $correos=HostingCorreos::find($id);
      $correos->contrasena=$request->get('contrasena');
      $correos->servidor_entrante=$request->get('servidor_entrante');
      $correos->servidor_entrante_imap=$request->get('servidor_entrante_imap');
      $correos->servidor_entrante_pop=$request->get('servidor_entrante_pop');
      $correos->servidor_salida=$request->get('servidor_salida');
      $correos->servidor_salida_smptp=$request->get('servidor_salida_smptp');
      $correos->save();
      return redirect()->route('hosting.index');
    }


  }
