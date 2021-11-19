<?php
namespace App\Http\Controllers;
use App\Dominios;
use App\Moneda;
use App\Motivo;
use App\PlanDominio;
use App\PlanHosting;
use App\ProveedorDominios;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PlanDominioController extends Controller

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
      $plan_dominio=PlanDominio::all();

      return view('productos.dominios.plan_dominio.index',compact('moneda','plan_dominio'));
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

      $plan_dominio= new PlanDominio;
      $plan_dominio->nombre=$request->get('nombre');
      $plan_dominio->moneda=$request->get('moneda');
      $plan_dominio->precio=$request->get('precio');
      $plan_dominio->estado='0';
      $plan_dominio->user_registrado=$usuario_logeado;
      $plan_dominio-> save();
      return redirect()->route('plan_dominio.index');

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
     if ($estado=='on') { $estado='1';}
     else{ $estado='2';}

     $plan_hosting=PlanDominio::find($id);
     // $plan_hosting->nombre=$request->get('nombre');
     // $plan_hosting->descripcion=$request->get('descripcion');
     $plan_hosting->moneda=$request->get('moneda');
     $plan_hosting->precio=$request->get('precio');
     $plan_hosting->estado=$estado;
     $plan_hosting->save();
     return redirect()->route('plan_dominio.index');

   }

 }
