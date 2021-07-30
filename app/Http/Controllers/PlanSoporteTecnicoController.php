<?php
namespace App\Http\Controllers;
use App\PlanSoporteTecnico;
use App\User;
use Illuminate\Http\Request;

class PlanSoporteTecnicoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      if (auth()->user()->roles_id == 3){return back();}/*Clientes no entran*/
      $planes=PlanSoporteTecnico::all();
      return view('soporte_tecnico.planes_soporte.index',compact('planes'));
  }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     $this->validate($request,[
        'nombre' => ['required'],
        'descripcion' => ['required'],
    ],[
        'nombre.required' => 'El Nombre es Necesario',
        'descripcion.required' => 'La Descripcion es Necesaria',
    ]);


     $marcas = new PlanSoporteTecnico;
     $marcas->nombre =$request->get('nombre');
     $marcas->descripcion =$request->get('descripcion');
     $marcas->estado=0;
     $marcas-> save();
     return redirect()->route('plan_soporte_tecnico.index');
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
     $this->validate($request,[
        'nombre' => ['required'],
        'descripcion' => ['required'],
    ],[
        'nombre.required' => 'El Nombre es Necesario',
        'descripcion.required' => 'La Descripcion es Necesaria',
    ]);

     $estado=$request->get('estado');
     if (isset($estado)) {$estado=0;}
     else{$estado=1;}
     $marcas=PlanSoporteTecnico::find($id);
     $marcas->nombre=$request->get('nombre');
     $marcas->descripcion=$request->get('descripcion');
     $marcas->estado=$estado;
     $marcas->save();
     return redirect()->route('plan_soporte_tecnico.index');
 }

}
