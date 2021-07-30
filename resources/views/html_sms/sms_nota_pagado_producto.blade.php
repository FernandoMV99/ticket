           <div style="padding-left: 10px;padding-right: 10px;">
            <span hidden="" style="color: #f9f9f900">{{$suma_hosting = 0}}{{$suma_dominio = 0}}{{$suma_certificado = 0}}{{$suma_soporte = 0}}{{$suma_licencia = 0}}</span>

            <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
             <tbody>
              <tr>
               <td align="left">
                <img  style="width: 30%;height:auto;background-size: contain;border-radius: 5px;" name="foto"  src="{{ asset('/multimedia/empresa/')}}/{{$empresa->foto}}"  />
              </td>
              <td style="width:500px"></td>
              <td  align="right"  >
                <div style="color: grey;background-color: #def7e8;width: 250px;border-radius: 10px;text-align: center">
                  <b><h2>Nota de Venta <br><span style="font-size:13px">{{$codigo_pago}}</span><br> <span style="color:#4679c5">Pagado</span></h2></b>
                </div>
              </td>
            </tr>
            <tr> <td width="1" height="25"></td></tr>
            <tr>
             <td align="left" >
              <b>Facturado a</b> <br>
              {{$cliente->empresa}}<br>
              Sr(a): {{$cliente->name}} {{$cliente->last_name}} <br>
              {{$empresa->ruc}}<br>
              {{$cliente->pais}}<br>
            </td>
            <td style="width: 200px"></td>
            <td align="right" >
              {{$empresa->nombre}} <br>
              {{$empresa->pais}}-{{$empresa->departamento}}-{{$empresa->distrito}} <br>
              ID: {{$empresa->ruc}}
            </td>
          </tr>
          <tr> <td width="1" height="25"></td></tr>
          <tr> <td height="5"></td> </tr>
          <tr><td style="width:50%;text-align:left;font-weight:bold">Descripcion</td><td colspan="2" style="width:50%;text-align:right;font-weight:bold">Total</td></tr>
          <tr><td style="background: #00000045;height:2px;margin:8px 0;" colspan="3"></td></tr>
          <tr> <td width="1" height="10"></td></tr>

          {{-- Hosting  --}}
          @if(isset($hosting_impresion))
          <tr><td colspan="3" align="center">Hosting</td></tr>
          @foreach($hosting_impresion as $index => $hosting_impresion)
          <tr >
           <td style="width:50%;text-align:left;padding-left:15px" colspan="2">
            <b>Plan Hosting:</b> {{$hosting_impresion->plan_hostings->nombre}} <br>
            <b>Dominio:</b> {{$hosting_impresion->dominio}}  <br>
            <b>Años:</b> {{$hosting_impresion->anos}}  <br>
            <b>FechaVencimiento:</b> {{$hosting_impresion->fecha_vencimiento}}
          </td>
          <td style="width:50%;text-align:right;font-weight:bold">{{$hosting_impresion->moneda}}{{$hosting_impresion->precio}}</td>
        </tr>
        <tr><td colspan="3"><hr></td><span hidden="" style="color: #f9f9f900;font-size: 0px">{{$suma_hosting = $suma_hosting+$hosting_impresion->precio}}</span></tr>


        @endforeach
        @endif
        {{--Fin Hosting  --}}
        {{-- Dominio  --}}
        @if(isset($dominio_impresion))
        <tr><td colspan="3" align="center">Dominio</td></tr>
        @foreach($dominio_impresion as $index => $dominio_impresion)
        <tr >
         <td style="width:50%;text-align:left;padding-left:15px" colspan="2">
          <b>Dominio:</b> {{$dominio_impresion->nombre_dominio}} <br>
          <b>Años:</b> {{$dominio_impresion->anos}} <br>
          <b>FechaVencimiento:</b> {{$dominio_impresion->fecha_vencimiento}}
        </td>
        <td style="width:50%;text-align:right;font-weight:bold">{{$dominio_impresion->moneda}}{{$dominio_impresion->precio}}</td>
      </tr>
      <tr><td colspan="3"><hr></td><span hidden=""  style="color: #f9f9f900;font-size: 0px">{{$suma_dominio = $suma_dominio+$dominio_impresion->precio}}</span></tr>
      @endforeach
      @endif
      {{--Fin Dominio  --}}

      {{-- certificado SSl  --}}
      @if(isset($certificadossl_impresion))
      <tr><td colspan="3" align="center">Certificado SSL</td></tr>
      @foreach($certificadossl_impresion as $index => $certificadossl_impresion)
      <tr >
       <td style="width:50%;text-align:left;padding-left:15px" colspan="2">
        <b>Dominio:</b> {{$certificadossl_impresion->nombre_dominio}} <br>
        <b>Años:</b> {{$certificadossl_impresion->anos}} <br>
        <b>FechaVencimiento:</b> {{$certificadossl_impresion->fecha_vencimiento}}
      </td>
      <td style="width:50%;text-align:right;font-weight:bold">{{$certificadossl_impresion->moneda}}{{$certificadossl_impresion->precio}}</td>
    </tr>
    <tr><td colspan="3"><hr></td><span hidden=""  style="color: #f9f9f900;font-size: 0px">{{$suma_certificado = $suma_certificado+$certificadossl_impresion->precio}}</span></tr>
    @endforeach
    @endif
    {{--Fin certificado SSl  --}}

    {{-- Soporte--}}
    @if(isset($soporte_imprension))
    <tr><td colspan="3" align="center">Soporte Tecnico</td></tr>
    @foreach($soporte_imprension as $index => $soporte_imprension)
    <tr >
     <td style="width:50%;text-align:left;padding-left:15px" colspan="2">
      <b> Plan Soporte:</b> {{$soporte_imprension->plansoporte->nombre}}<br>
      <b> Valido Por:</b> {{$soporte_imprension->anos}} Mes(es)<br>
      <b>FechaVencimiento:</b> {{$soporte_imprension->fecha_vencimiento}}
    </td>
    <td style="width:50%;text-align:right;font-weight:bold">{{$soporte_imprension->moneda}}{{$soporte_imprension->precio}}</td>
  </tr>
  <tr><td colspan="3"><hr></td><span hidden=""  style="color: #f9f9f900;font-size: 0px">{{$suma_soporte = $suma_soporte+$soporte_imprension->precio}}</span></tr>
  @endforeach
  @endif
  {{--Fin Soporte--}}

   {{-- Licencia--}}
    @if(isset($licencia_impresion))
    <tr><td colspan="3" align="center">Licencias</td></tr>
    @foreach($licencia_impresion as $index => $licencia_impresion)
    <tr >

    <td  style="width:50%;text-align:left;padding-left:15px" colspan="2">
      <b>Categoria:</b> {{$licencia_impresion->categoria->nombre}} <br>
      <b>Equipo:</b> {{$licencia_impresion->equipos->marcas->nombre}} /  {{$licencia_impresion->equipos->tipoequipo->nombre}} /{{$licencia_impresion->equipos->usuario}} <br>
       <b>Años:</b> {{$licencia_impresion->anos}} <br>
        <b>FechaVencimiento:</b> {{$licencia_impresion->fecha_vencimiento}}<br>
      </td>
    <td style="width:50%;text-align:right;font-weight:bold">{{$licencia_impresion->moneda}}{{$licencia_impresion->precio}}</td>
  </tr>
  <tr><td colspan="3"><hr></td><span hidden=""  style="color: #f9f9f900;font-size: 0px">{{$suma_licencia = $suma_licencia+$licencia_impresion->precio}}</span></tr>
  @endforeach
  @endif
  {{--Fin Licencia--}}

  <tr><td style="height:15px"></td></tr>

  <tr> <td width="1" height="15"></td></tr>
  <tr>
   <td align="right" style="width:50%;text-align:left;padding-left:15px" colspan="2"> Total: </td>
   <td style="text-align:right">
    <span hidden="hidden" style="color: #f9f9f900;font-size: 0px"> {{$suma=$suma_hosting+$suma_dominio+$suma_certificado+$suma_soporte+$suma_licencia}}</span>
    S/.{{$suma}}
  </td>
</tr>
</tbody>
</table>
</div>
