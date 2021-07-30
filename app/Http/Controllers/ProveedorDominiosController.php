<?php
namespace App\Http\Controllers;
use App\ProveedorDominios;
use Illuminate\Http\Request;

class ProveedorDominiosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provedor_dominios=ProveedorDominios::all();
        return view('productos.dominios.proveedor_dominios.index',compact('provedor_dominios'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user=auth()->user();
        $usuario_logeado=auth()->user()->id;


        $provedor_dominios = new ProveedorDominios;
        $provedor_dominios->nombre=$request->get('nombre');
        $provedor_dominios->descripcion=$request->get('descripcion');
        $provedor_dominios->correo=$request->get('correo');
        $provedor_dominios->estado=1;
        $provedor_dominios->user_registrado=$usuario_logeado;
        $provedor_dominios-> save();


        return redirect()->route('proveedor_dominio.index');

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

        $provedor_dominios=ProveedorDominios::find($id);
        $provedor_dominios->nombre=$request->get('nombre');
        $provedor_dominios->descripcion=$request->get('descripcion');
        $provedor_dominios->correo=$request->get('correo');
        $provedor_dominios->estado=$estado;
        $provedor_dominios-> save();

        return redirect()->route('proveedor_dominio.index');
    }

}
