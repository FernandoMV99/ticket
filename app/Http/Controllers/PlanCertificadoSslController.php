<?php
namespace App\Http\Controllers;
use App\Moneda;
use App\PlanCertificadoSsl;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PlanCertificadoSslController extends Controller

{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (auth()->user()->roles_id == 3){return back();}/*Clientes no entran*/
      $moneda=Moneda::all();
      $plan_ssl=PlanCertificadoSsl::all();

      return view('productos.certificados.plan_certificado_ssl.index',compact('moneda','plan_ssl'));
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

      $plan_certicado_ssl= new PlanCertificadoSsl;
      $plan_certicado_ssl->nombre=$request->get('nombre');
      $plan_certicado_ssl->descripcion=$request->get('descripcion');
      $plan_certicado_ssl->moneda=$request->get('moneda');
      $plan_certicado_ssl->precio=$request->get('precio');
      $plan_certicado_ssl->user_registrado=$usuario_logeado;
      $plan_certicado_ssl->estado=0;
      $plan_certicado_ssl-> save();
      return redirect()->route('plan_certicado_ssl.index');

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
     $estado=$request->get('estado');
     if ($estado=='on') { $estado='0';}
     else{ $estado='1';}

     $plan_certicado_ssl=PlanCertificadoSsl::find($id);
      $plan_certicado_ssl->nombre=$request->get('nombre');
      $plan_certicado_ssl->descripcion=$request->get('descripcion');
      $plan_certicado_ssl->moneda=$request->get('moneda');
      $plan_certicado_ssl->precio=$request->get('precio');
     $plan_certicado_ssl->estado=$estado;
      $plan_certicado_ssl-> save();

     return redirect()->route('plan_certicado_ssl.index');

   }

 }
