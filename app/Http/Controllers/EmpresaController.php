<?php
namespace App\Http\Controllers;
use App\Empresa;
use Illuminate\Http\Request;

class EmpresaController extends Controller
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
        return view('empresa.index',compact('empresa'));

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
      $encryption=$request->get('encryption');
      if ($boton=="correo") {
        $empresa=Empresa::find($id);
        $empresa->correo=$request->get('correo');
        $empresa->puerto=$request->get('puerto');
        $empresa->smpt=$request->get('smpt');
        if (empty($encryption)) {$empresa->encryption=" "; }
        else{ $empresa->encryption=$encryption;}
        $empresa->save();
        // return $empresa->encryption;
        return redirect()->route('empresa.index');
      }
      elseif ($boton=="empresa") {

        if($request->hasfile('foto')){
          $image1 =$request->file('foto');
          $nombre_foto =time().$image1->getClientOriginalName();
          $destinationPath = public_path('/multimedia/empresa/');
          $image1->move($destinationPath,$nombre_foto);
        }else{
          $nombre_foto=$request->get('foto_original');
        }
        $empresa=Empresa::find($id);
        $empresa->foto=$nombre_foto;
        $empresa->nombre=$request->get('nombre');
        $empresa->ruc=$request->get('ruc');
        $empresa->pais=$request->get('pais');
        $empresa->descripcion=$request->get('descripcion');
        $empresa->departamento=$request->get('departamento');
        $empresa->distrito=$request->get('distrito');
        $empresa->celular=$request->get('celular');
        $empresa->telefono=$request->get('telefono');
        $empresa->pagina_web=$request->get('pagina_web');
        $empresa->save();
        return redirect()->route('empresa.index');
      }

    }

  }
