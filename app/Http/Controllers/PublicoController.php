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

        $fecha_ges = new DateTime(NOW());

        $disponibilidad = DB::table('vtagenda_agenda')
            ->join('vtagenda_cliente', 'vtagenda_cliente.idCliente', 'vtagenda_agenda.vtagenda_cliente_idCliente')
            ->where([
                ['codpubCliente', '=', $id],
                ['estadoAgenda', '=', 1],
                ['fechaAgenda', '>=', $fecha_ges]
            ])
            ->count();

        if ($disponibilidad == 0) {

            echo 'Cliente no existe';

        } else {
            $disponibilidad = DB::table('vtagenda_agenda')
                ->join('vtagenda_cliente', 'vtagenda_cliente.idCliente', 'vtagenda_agenda.vtagenda_cliente_idCliente')
                ->where([
                    ['codpubCliente', '=', $id],
                    ['estadoAgenda', '=', 1],
                    ['fechaAgenda', '>=', $fecha_ges]
                ])
                ->get();

            return view('Publico.rut', [
                'cliente' => $disponibilidad
            ]);
        }

    }

    public function agenda_fase_2(Request $request)
    {

        $fecha_ges = new DateTime(NOW());

        $disponibilidad = DB::table('vtagenda_agenda')
            ->join('vtagenda_cliente', 'vtagenda_cliente.idCliente', 'vtagenda_agenda.vtagenda_cliente_idCliente')
            ->where([
                ['codpubCliente', '=', $request->idcliente],
                ['estadoAgenda', '=', 1],
                ['fechaAgenda', '>=', $fecha_ges]
            ])
            ->count();

        if ($disponibilidad == 0) {

            echo 'Cliente no existe';

        } else {
            $disponibilidad = DB::table('vtagenda_agenda')
                ->join('vtagenda_cliente', 'vtagenda_cliente.idCliente', 'vtagenda_agenda.vtagenda_cliente_idCliente')
                ->where([
                    ['codpubCliente', '=', $request->idcliente],
                    ['estadoAgenda', '=', 1],
                    ['fechaAgenda', '>=', $fecha_ges]
                ])
                ->get();

            $horas_tomadas = DB::table('vtagenda_contacto')
                ->join('vtagenda_cliente', 'vtagenda_cliente.idCliente', 'vtagenda_contacto.vtagenda_agenda_vtagenda_cliente_idCliente')
                ->where([
                    ['rutContacto', $request->rut],
                    ['fechaAtencion', '>=', $fecha_ges]
                ])
                ->get();

            $contacto_run = DB::table('vtagenda_contacto')
                ->where('rutContacto', $request->rut)
                ->first();

            if ($contacto_run == null) {
                return view('Publico.agenda', [
                    'cliente' => $disponibilidad,
                    'run' => $request->rut,
                    'horas' => $horas_tomadas
                ]);
            } else {
                return view('Publico.agenda2', [
                    'cliente' => $disponibilidad,
                    'contacto' => $contacto_run,
                    'run' => $request->rut,
                    'horas' => $horas_tomadas
                ]);
            }

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

        $dispo = DB::table('vtagenda_agenda')
            ->where('idAgenda', '=', $request->dispo)
            ->pluck('estadoAgenda');

        if ($dispo[0] == 1) {
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

            DB::table('vtagenda_contacto')->insert([
                'rutContacto' => $request->runcontacto,
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
        }

        return view('Publico.clientes');

    }


}
