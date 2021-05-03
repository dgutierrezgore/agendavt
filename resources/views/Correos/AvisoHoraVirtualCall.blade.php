<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title>Notificación Plataforma Agenda VirtualCALL</title>
</head>
<body>


<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td style="padding: 10px 0 30px 0;">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="600"
                   style="border: 0px solid #cccccc; border-collapse: collapse;">
                <tr>
                    <td align="center"
                        style="padding: 40px 0 30px 0; color: #1f1f1f; font-size: 20px; font-weight: bold; font-family: Arial, sans-serif;"
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
                                </h1><br>
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
                        <h3>
                            CLIENTE / PACIENTE
                        </h3>
                    </td>
                </tr>
                <tr>
                    <td style="width: 140px">Fecha</td>
                    <td style="width: 15px">:</td>
                    <td>{{ date('d-m-Y') }}</td>
                </tr>
                <tr>
                    <td>Hora</td>
                    <td>:</td>
                    <td>{{ date('H:i:s') }}</td>
                </tr>
                <tr>
                    <td>Nombre</td>
                    <td>:</td>
                    <td>{{ strtoupper($data['nombre_contacto']) }}</td>
                </tr>
                <tr>
                    <td>Teléfono</td>
                    <td>:</td>
                    <td>+56 9 {{ strtoupper($data['telefono_contacto']) }}</td>
                </tr>
                <tr>
                    <td>Correo Electrónico</td>
                    <td>:</td>
                    <td>{{ strtoupper($data['mail_contacto']) }}</td>
                </tr>

                <tr>
                    <td colspan="3">
                        <h3>
                            INFORMACIÓN
                        </h3>
                    </td>
                </tr>

                <tr>
                    <td>Tipo de Atención</td>
                    <td>:</td>
                    <td>{{ strtoupper($data['tipo_atencion']) }}</td>
                </tr>

                <tr>
                    <td>Fecha y Hora</td>
                    <td>:</td>
                    <td>{{ strtoupper($data['fecha_hora']) }}</td>
                </tr>

                <tr>
                    <td>Dirección</td>
                    <td>:</td>
                    <td>{{ strtoupper($data['direccion']) }}</td>
                </tr>

                <tr>
                    <td>Teléfono</td>
                    <td>:</td>
                    <td>+56 {{ strtoupper($data['fono']) }}</td>
                </tr>
                <tr>
                    <td colspan="3"><br></td>
                </tr>
                <tr>
                    <td><strong>OBSERVACIONES:</strong></td>
                    <td>:</td>
                    <td>{{ strtoupper($data['observaciones']) }}</td>
                </tr>

                <br><br>
                <tr>
                    <td bgcolor="#FFFFFF" style="padding: 20px 20px 30px 30px;" colspan="3">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td style="color: #001F3F; font-family: Arial, sans-serif; font-size: 14px;"
                                    width="75%">
                                    <center><small><strong>Notificación de Agenda a Clientes</strong></small>
                                    </center>
                                    <center><strong>Notificación Toma de Hora por Sistema</strong> - VirtualCall Sys.
                                    </center>
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
