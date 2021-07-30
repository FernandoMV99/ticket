           <div style="padding-left: 80px;padding-right: 80px;">

            <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
              <tbody>

                <tr>
                  <td align="left">
                    <img  style="width: 50%;height:auto;background-size: contain;border-radius: 5px; padding: 10px;" name="foto"  src="{{ asset('/multimedia/empresa/')}}/{{$empresa->foto}}"  />
                  </td>
                  <td align="right">
                    <div class="form-control" align="center" style="color: grey;background-color: #def7e8;padding:5px;width:200px;border-radius: 10px" >
                      <b><h2>Nota de Venta <br><span style="color: red; font-size: 13px">No Pagado</span></h2></b>
                    </div>
                  </td>
                </tr>

                <tr>
                  <td align="left" >
                    <b>Facturado a</b> <br>
                    {{$cliente->empresa}}<br>
                    Sr(a): {{$cliente->name}} {{$cliente->last_name}} <br>
                    {{$empresa->ruc}}<br>
                    {{$cliente->pais}}<br>
                  </td>

                  <td align="right" >
                   {{$empresa->nombre}} <br>
                   {{$empresa->pais}}-{{$empresa->departamento}}-{{$empresa->distrito}} <br>
                   ID: {{$empresa->ruc}}
                 </td>
               </tr>



               <tr> <td height="5"></td> </tr>
               <tr><td style="width:50%;text-align:left;font-weight:bold">Descripcion</td><td style="width:50%;text-align:right;font-weight:bold">Total</td></tr>
               <tr><td style="background: #00000045;height:2px;margin:8px 0;" colspan="3"></td></tr>
               <tr> <td width="1" height="10"></td></tr>
               {{-- Dominio  --}}
               @if(isset($dominios))
               <tr >
                 <td style="width:50%;text-align:left;padding-left:15px">
                  <b>Dominio:</b> {{$dominios->nombre_dominio}} <br>
                  <b>Años:</b> {{$dominios->anos}} <br>
                  <b>FechaVencimiento:</b> {{$dominios->fecha_vencimiento}}</td>
                  <td style="width:50%;text-align:right;font-weight:bold">{{$dominios->moneda}}{{$dominios->precio}}</td>
                </tr>
                @endif
                {{--Fin Dominio  --}}

                {{-- Hosting  --}}
                @if(isset($hosting))
                <tr >
                 <td style="width:50%;text-align:left;padding-left:15px">
                  <b>Plan Hosting:</b> {{$hosting->plan_hostings->nombre}}<br>
                  <b>Dominio:</b> {{$hosting->dominio}} <br>
                  <b>Años:</b> {{$hosting->anos}} <br>
                  <b>FechaVencimiento:</b> {{$hosting->fecha_vencimiento}}</td>
                  <td style="width:50%;text-align:right;font-weight:bold">{{$hosting->moneda}}{{$hosting->precio}}</td>
                </tr>
                @endif
                {{--Fin Hosting  --}}

                {{-- certificados_ssl  --}}
                @if(isset($certificados_ssl))
                <tr >
                 <td style="width:50%;text-align:left;padding-left:15px">
                  <b>Plan SSL:</b> {{$certificados_ssl->planes_ssl->nombre}}<br>
                  <b>Dominio:</b> {{$certificados_ssl->nombre_dominio}} <br>
                  <b>Años:</b> {{$certificados_ssl->anos}} <br>
                  <b>FechaVencimiento:</b> {{$certificados_ssl->fecha_vencimiento}}</td>
                  <td style="width:50%;text-align:right;font-weight:bold">{{$certificados_ssl->moneda}}{{$certificados_ssl->precio}}</td>
                </tr>
                @endif
                {{--Fin certificados_ssl  --}}

                {{-- Soporte  --}}
                @if(isset($soporte_tecnico))
                <tr >
                 <td style="width:50%;text-align:left;padding-left:15px">
                   <b> Plan Soporte:</b> {{$soporte_tecnico->plansoporte->nombre}}<br>
                   <b> Valido Por:</b> {{$soporte_tecnico->anos}} Mes(es)<br>
                   <b>FechaVencimiento:</b> {{$soporte_tecnico->fecha_vencimiento}}
                   <td style="width:50%;text-align:right;font-weight:bold">{{$soporte_tecnico->moneda}}{{$soporte_tecnico->precio}}</td>
                 </tr>
                 @endif
                 {{--Fin Soporte  --}}

                 {{-- Licencia  --}}
                 @if(isset($licencia))
                 <tr >
                   <td style="width:50%;text-align:left;padding-left:15px">
                    <b>Tipo de Licencia:</b> {{$licencia->categoria->nombre}}<br>
                    <b>Equipo:</b> {{$licencia->equipos->marcas->nombre}} - {{$licencia->equipos->codigo_equipo}} - {{$licencia->equipos->usuario}} <br>
                    <b>FechaVencimiento:</b> {{$licencia->fecha_vencimiento}}</td>
                    <td style="width:50%;text-align:right;font-weight:bold">{{$licencia->moneda}}{{$licencia->precio}}</td>
                  </tr>
                  @endif
                  {{--Fin Licencia  --}}

                  <tr><td style="height:15px"></td></tr>
                  <tr><td style="background: #00000045;height:2px;margin:8px 0;" colspan="3"></td></tr>

                  <tr> <td width="1" height="15"></td></tr>
                  <tr>
                    <td align="left" style="width:50%;text-align:left;padding-left:15px" > Total: </td>
                    <td style="text-align:right">
                      @if(isset($dominios)){{$dominios->moneda}}{{$dominios->precio}}@endif
                      @if(isset($hosting)){{$hosting->moneda}}{{$hosting->precio}}@endif
                      @if(isset($certificados_ssl)){{$certificados_ssl->moneda}}{{$certificados_ssl->precio}}@endif
                      @if(isset($soporte_tecnico)){{$soporte_tecnico->moneda}}{{$soporte_tecnico->precio}}@endif
                      @if(isset($licencia)){{$licencia->moneda}}{{$licencia->precio}}@endif
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>


            <style>
            .form-control, .single-line {
              background-color: #FFFFFF;
              background-image: none;
              border: 1px solid #e5e6e7;
              border-radius: 1px;
              color: inherit;
              display: block;
              padding: 6px 12px;
              transition: border-color 0.15s ease-in-out 0s, box-shadow 0.15s ease-in-out 0s;
              width: 100%;
            }
          </style>