<!DOCTYPE html>
<html lang="en-US">
  <head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>Solicitud de Premio</title>
    <style type="text/css">
      a:hover {text-decoration: underline !important;}
    </style>
  </head>
  <body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8" style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: 'Open Sans', sans-serif;">
      <tr>
        <td>
          <table style="background-color: #f2f3f8; max-width:670px;  margin:0 auto;" width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
            <tr>
              <td style="text-align:center;">
                <a href="#" title="toyo" target="_blank">
                  <img src="{{url('/images/logo.png')}}" style="width:150px;">
                </a>
              </td>
            </tr>
            <tr>
              <td>
                <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" style="max-width:670px;background:#fff; border-radius:3px; text-align:center;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);">
                  <tr>
                    <td style="height:40px;">&nbsp;</td>
                  </tr>
                  <tr>
                    <td style="padding:0 35px;">
                      <h1 style="color:#1e1e2d; font-weight:500; margin:0;font-size:32px;font-family:'Rubik',sans-serif;">Nueva Solicitud De Premio</h1>
                      <span style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; width:100px;"></span>
                      <p style="color:#455056; font-size:15px;line-height:24px; margin:0;">
                        Recibiste una nueva solicitud de premio, éste es un resúmen de los datos proporcionados en el sistema:
                      </p>
                      <hr />
                      <div style="text-align: left;">
                        <div style="margin: 8px;">
                          <span style="font-weight:bold;">Vendedor: </span>{{ $exchange->owner->names }} {{ $exchange->owner->surnames}}
                        </div>
                        <div style="margin: 8px;">
                          <span style="font-weight:bold;">Teléfono: </span>{{ $exchange->owner->phone }}
                        </div>
                        <div style="margin: 8px;">
                          <span style="font-weight:bold;">CI: </span>{{ $exchange->owner->ci }}
                        </div>
                        <div style="margin: 8px;">
                          <span style="font-weight:bold;">Fecha de Solicitud: </span>{{ date('d/m/Y, g:i a', strtotime($exchange->created_at)) }}
                        </div>
                        <div style="margin: 8px;">
                          <span style="font-weight:bold;">Cantidad Solicitada: {{ $exchange->quantity }}</span>
                        </div>
                      </div>
                      <br>
                      <div style="text-align: left;">• Para ver en detalle ésta y otras solicitudes, pulse en el siguiente enlace:</div>
                      <a href="http://localhost:8080/lista-premios" style="background:#375bb5;text-decoration:none!important; font-weight:500; margin-top:35px; color:#fff;text-transform:uppercase; font-size:14px;padding:10px 24px;display:inline-block;border-radius:50px;">Ver Solicitudes</a>
                    </td>
                  </tr>
                  <tr>
                    <td style="height:40px;">&nbsp;</td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
  	        <td style="height:20px;">&nbsp;</td>
  	      </tr>
  	      <tr>
  	        <td style="text-align:center;">
  	          <p style="font-size:14px; color:rgba(69, 80, 86, 0.7411764705882353); line-height:18px; margin:0 0 0;">
  	          	<strong>© 2021 Baterías Toyo Todos los derechos reservados.</strong>
  	          </p>
  	        </td>
  	      </tr>
  	      <tr>
  	        <td style="height:80px;">&nbsp;</td>
  	      </tr>
          </table>
        </td>
      </tr>
    </table>
  </body>
</html>