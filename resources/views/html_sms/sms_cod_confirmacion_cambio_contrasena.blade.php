<table width="100%" cellpadding="0" cellspacing="0" style="padding:0;margin:0">
  <tbody><tr>
    <td style="font-size:0"><span></span></td>
    <td valign="top" align="left" style="width:640px;max-width:640px">
      <table width="100%" bgcolor="#FFFFFF" cellpadding="0" cellspacing="0" style="padding:0;margin:0;border:0">
        <tbody>
          <tr>
            <td align="left" style="padding:32px 63px 0 63px" >
              <a href="{{$empresa->pagina_web}}" target="_blank" >
                <img alt="" src="{{asset('multimedia/empresa')}}/{{$empresa->foto}}" width="150" class="CToWUd">
                <img style="text-align: right;" align="right" src="{{asset('multimedia/tickets.png')}}" width="120" class="CToWUd"></a>

                <span style="font-family:Helvetica,Arial,sans-serif;font-size:24px;line-height:31px;color:#777777;padding:0;margin:28px 0 32px 0;font-weight:400;text-align:left;text-decoration:none;display:block">{{$usuario_edit->name}} {{$usuario_edit->last_name}}</span>

                <p style="font-family:Helvetica,Arial,sans-serif;font-size:16px;line-height:20px;color:#333333;margin:0;padding:0;margin:0 0 20px 0;text-align:left">
                  Hola! Tu código de Validación para confirmar el usuario al sistema. Este Codigo es confidencial,no la compartas con nadie. Solo ingrésala en el Sistema para continuar con tu confirmacion.
                  <br> <br>
                  <span style="font-size:25px;line-height:31px;color:#777777;padding:5px;margin:28px 0 32px 0;text-align:left;display:block;border-radius:10px;border:2px solid #39e084">Codigo: {{$codigo_confirmacion}}<br></span>
                </p>
                <p style="font-family:Helvetica,Arial,sans-serif;font-size:16px;line-height:20px;color:#333333;padding:0;margin:35px 0 0 0;text-align:left">
                  No comparta con nadie este mensaje<br><br>{{$empresa->nombre}}
                </p>
              </td>
            </tr>
          </tbody></table>
        </td>
        <td style="font-size:0"><span></span></td>
      </tr>
      <tr>
        <td style="font-size:0"><span></span></td>
        <td align="center" style="width:640px;max-width:640px;padding:25px 0 28px 0">
          <p style="font-family:Helvetica,Arial,sans-serif;font-size:14px;line-height:20px;color:#999999;padding:0;margin:4px 0 22px 0">{{$empresa->nombre}}</p>
          <table cellpadding="0" cellspacing="0" style="padding:0;margin:0;border:0">
            <tbody>
              <tr>
                <td style="padding:0 8px"><img src="{{asset('multimedia/empresa')}}/{{$empresa->foto}}" width="80" class="CToWUd"></td>
              </tr>
            </tbody>
          </table>
          <p style="border-bottom:1px solid #dddddd;width:600px;margin:0 0 12px 0">&nbsp;
          </p><p style="font-family:Helvetica,Arial,sans-serif;font-size:13px;line-height:20px;color:#999999;padding:0;margin:0 0 22px 0">Copyright   JyP Perifericos  © 2019-2020</p>
          <p></p>
        </td>
        <td style="font-size:0"><span></span></td>
      </tr>
    </tbody>
  </table>