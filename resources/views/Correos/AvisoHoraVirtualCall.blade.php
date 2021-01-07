<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Notificación Gobierno Regional del Biobío</title>
</head>
<body>


<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td style="padding: 10px 0 30px 0;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600"
                   style="border: 0px solid #cccccc; border-collapse: collapse;">
                <tr>
                    <td align="center"
                        style="padding: 40px 0 30px 0; color: #fffcf9; font-size: 20px; font-weight: bold; font-family: Arial, sans-serif;"
                        colspan="3">
                        <img src="http://virtualcall.cl/img/bannervc.jpg" alt="">
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div>
                            <center>
                                <h1>
                                    AVISO HORA DE ATENCIÓN
                                </h1>
                            </center>
                            <p><strong>¡HOLA!, {{ strtoupper($data['nombre_contacto']) }}.</strong> <br><br>
                                Queremos informarte que se ha reservado exitosamente la hora con:
                                <strong>{{ strtoupper($data['nombre_cliente']) }}.</strong>
                            </p>
                            <hr>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <h2>Datos del Contacto</h2>
                    </td>
                </tr>
                <tr>
                    <td><h3>Nombre:</h3>
                        <p>{{ strtoupper($data['nombre_contacto']) }}</p>
                    </td>
                    <td><h3>Teléfono:</h3>
                        <p>+56 9 {{ strtoupper($data['telefono_contacto']) }}</p>
                    </td>
                    <td><h3>Correo Electrónico</h3>
                        <p>{{ strtoupper($data['mail_contacto']) }}</p>
                    </td>
                </tr>
                <tr>
                    <td><h3>Tipo de Atención:</h3>
                        <p>{{ strtoupper($data['tipo_atencion']) }}</p>
                    </td>
                    <td colspan="2"><h3>Observaciones:</h3>
                        <p>{{ strtoupper($data['observaciones']) }}</p>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">
                        <h2>Datos de la Atención</h2>
                    </td>
                </tr>
                <tr>
                    <td><h3>Fecha y Hora:</h3>
                        <p>{{ strtoupper($data['fecha_hora']) }}</p>
                    </td>
                    <td><h3>Dirección:</h3>
                        <p>{{ strtoupper($data['direccion']) }}</p>
                    </td>
                    <td><h3>Teléfono</h3>
                        <p>+56 {{ strtoupper($data['fono']) }}</p>
                    </td>
                </tr>
                <br><br>
                <tr>
                    <td bgcolor="#FFFFFF" style="padding: 20px 20px 30px 30px;" colspan="3">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #001F3F; font-family: Arial, sans-serif; font-size: 14px;"
                                    width="75%">
                                    <center><strong>Notificación Toma de Hora por Sistema</strong> - VirtualCall Sys.
                                    </center>
                                    <center><small>® {{ date('Y') }} Plataforma VirtualSys.</small></center>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    <tr/>
</table>
</body>
</html>
