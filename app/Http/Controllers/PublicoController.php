<?php

namespace App\Http\Controllers;

use App\Mail\AvisoTomaDeHora;
use Illuminate\Http\Request;
use DateTime;
use DB;
use Illuminate\Support\Facades\Mail;

class PublicoController extends Controller
{

    static function agenda_publico($id)
    {

        $disponibilidad = DB::table('vtagenda_agenda')
            ->join('vtagenda_cliente', 'vtagenda_cliente.idCliente', 'vtagenda_agenda.vtagenda_cliente_idCliente')
            ->where([
                ['codpubCliente', '=', $id],
                ['estadoAgenda', '=', 1]
            ])
            ->count();

        if ($disponibilidad == 0) {

            echo 'Cliente no existe';

        } else {
            $disponibilidad = DB::table('vtagenda_agenda')
                ->join('vtagenda_cliente', 'vtagenda_cliente.idCliente', 'vtagenda_agenda.vtagenda_cliente_idCliente')
                ->where([
                    ['codpubCliente', '=', $id],
                    ['estadoAgenda', '=', 1]
                ])
                ->get();

            return view('Publico.agenda', [
                'cliente' => $disponibilidad
            ]);
        }

    }

    public function agendar_hora(Request $request)
    {

        $datos_cliente = DB::table('vtagenda_cliente')
            ->where('idCliente', $request->idcliente)
            ->first();

        $h_f_at = DB::table('vtagenda_agenda')
            ->where('idAgenda', $request->dispo)
            ->first();

        $data_correo = array(
            'nombre_contacto' => $request->nombrecontacto,
            'nombre_cliente' => $datos_cliente->nombreCliente,
            'telefono_contacto' => $request->fonocontacto,
            'mail_contacto' => $request->mailcontacto,
            'tipo_atencion' => 'SOLICITADA VÍA WEB',
            'observaciones' => $request->obsc,
            'fecha_hora' => date('d-m-Y', strtotime($h_f_at->fechaAgenda)) . ', a las ' . $h_f_at->horaAgenda . ' horas.',
            'direccion' => $datos_cliente->direccionCliente,
            'fono' => $datos_cliente->fonoClienteVT,
        );

        Mail::to($request->mailcontacto)
            ->cc($datos_cliente->correoCliente)
            ->bcc('soporte@virtualcall.cl')
            ->send(new AvisoTomaDeHora($data_correo));

        $min_cliente = DB::table('vtagenda_cliente')
            ->where('idCliente', '=', $request->idcliente)
            ->pluck('tipoAgenda');

        $intervarlo = $min_cliente;

        $trae_fecha = DB::table('vtagenda_agenda')
            ->where('idAgenda', '=', $request->dispo)
            ->pluck('fechaAgenda');

        $trae_hora = DB::table('vtagenda_agenda')
            ->where('idAgenda', '=', $request->dispo)
            ->pluck('horaAgenda');

        $hora_fin = $trae_hora[0];

        $fechaFin = new DateTime($hora_fin);
        $fechaFin = $fechaFin->modify('+' . $intervarlo[0] . 'minutes');

        DB::table('vtagenda_contacto')->insert([
            'nombreContacto' => $request->nombrecontacto,
            'celularContacto' => $request->fonocontacto,
            'correoContacto' => $request->mailcontacto,
            'tipoAtencion' => 'VIA WEB',
            'obsContacto' => $request->obs,
            'estadoContacto' => 1,
            'fechaRegistro' => date('Y-m-d H:i:s'),
            'fechaAtencion' => $trae_fecha[0],
            'horaAtencion' => $trae_hora[0],
            'horaFinAtencion' => $fechaFin->format('H:i'),
            'vtagenda_agenda_idAgenda' => $request->dispo,
            'vtagenda_agenda_vtagenda_cliente_idCliente' => $request->idcliente
        ]);

        // Update
        DB::table('vtagenda_agenda')
            ->where('idAgenda', $request->dispo)
            ->update(['estadoAgenda' => 2]);

        return back()->with('status', '¡Hora registrada con éxito, le llegará un email con la confirmación.!');
    }

}
