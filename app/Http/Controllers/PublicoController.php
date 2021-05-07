<?php

namespace App\Http\Controllers;

use App\Mail\AvisoCancelaHora;
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
                ['fechaAgenda', '>=', $fecha_ges->modify('-1 day')]
            ])
            ->count();

        //dd($disponibilidad);

        if ($disponibilidad == 0) {

            return view('Publico.nodisponible');

        } else {
            $disponibilidad = DB::table('vtagenda_agenda')
                ->join('vtagenda_cliente', 'vtagenda_cliente.idCliente', 'vtagenda_agenda.vtagenda_cliente_idCliente')
                ->where([
                    ['codpubCliente', '=', $id],
                    ['estadoAgenda', '=', 1],
                    ['fechaAgenda', '>=', $fecha_ges->modify('-1 day')]
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
                ['fechaAgenda', '>=', $fecha_ges->modify('-1 day')]
            ])
            ->count();

        if ($disponibilidad == 0) {

            return view('Publico.nodisponible');

        } else {

            $cliente = DB::table('vtagenda_agenda')
                ->join('vtagenda_cliente', 'vtagenda_cliente.idCliente', 'vtagenda_agenda.vtagenda_cliente_idCliente')
                ->where('codpubCliente', '=', $request->idcliente)
                ->get();

            $disponibilidad = DB::table('vtagenda_agenda')
                ->join('vtagenda_cliente', 'vtagenda_cliente.idCliente', 'vtagenda_agenda.vtagenda_cliente_idCliente')
                ->where([
                    ['codpubCliente', '=', $request->idcliente],
                    ['estadoAgenda', '=', 1],
                    ['fechaAgenda', '>=', $fecha_ges->modify('-1 day')]
                ])
                ->distinct()
                ->select('fechaAgenda', 'fechaunica')
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
                    'cliente' => $cliente,
                    'dispo' => $disponibilidad,
                    'contacto' => $contacto_run,
                    'run' => $request->rut,
                    'horas' => $horas_tomadas
                ]);
            } else {
                return view('Publico.agenda2', [
                    'cliente' => $cliente,
                    'dispo' => $disponibilidad,
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
            ->where('idAgenda', $request->dispo_hora)
            ->first();

        $min_cliente = DB::table('vtagenda_cliente')
            ->where('idCliente', '=', $request->idcliente)
            ->pluck('tipoAgenda');

        $intervarlo = $min_cliente;

        $trae_fecha = DB::table('vtagenda_agenda')
            ->where('idAgenda', '=', $request->dispo_hora)
            ->pluck('fechaAgenda');

        $trae_hora = DB::table('vtagenda_agenda')
            ->where('idAgenda', '=', $request->dispo_hora)
            ->pluck('horaAgenda');

        $hora_fin = $trae_hora[0];

        $fechaFin = new DateTime($hora_fin);
        $fechaFin = $fechaFin->modify('+' . $intervarlo[0] . 'minutes');

        $dispo = DB::table('vtagenda_agenda')
            ->where('idAgenda', '=', $request->dispo_hora)
            ->pluck('estadoAgenda');

        if ($dispo[0] == 1) {
            DB::table('vtagenda_contacto')->insert([
                'rutContacto' => $request->runcontacto,
                'nombreContacto' => $request->nombrecontacto,
                'celularContacto' => $request->fonocontacto,
                'correoContacto' => $request->mailcontacto,
                'tipoAtencion' => 'Por Secretaria Virtual',
                'obsContacto' => $request->obs,
                'estadoContacto' => 1,
                'fechaRegistro' => date('Y-m-d H:i:s'),
                'fechaAtencion' => $trae_fecha[0],
                'horaAtencion' => $trae_hora[0],
                'horaFinAtencion' => $fechaFin->format('H:i'),
                'vtagenda_agenda_idAgenda' => $request->dispo_hora,
                'vtagenda_agenda_vtagenda_cliente_idCliente' => $request->idcliente
            ]);

            // Update
            DB::table('vtagenda_agenda')
                ->where('idAgenda', $request->dispo_hora)
                ->update(['estadoAgenda' => 2]);

            $data_correo = array(
                'nombre_contacto' => $request->nombrecontacto,
                'nombre_cliente' => $datos_cliente->nombreCliente,
                'telefono_contacto' => $request->fonocontacto,
                'mail_contacto' => $request->mailcontacto,
                'tipo_atencion' => 'Por Secretaria Virtual',
                'observaciones' => $request->obsc,
                'fecha_hora' => date('d-m-Y', strtotime($h_f_at->fechaAgenda)) . ', a las ' . $h_f_at->horaAgenda . ' horas.',
                'direccion' => $datos_cliente->direccionCliente,
                'fono' => $datos_cliente->fonoClienteVT,
            );

            Mail::to($request->mailcontacto)
                ->cc($datos_cliente->correoCliente)
                ->bcc('soporte@virtualcall.cl')
                ->send(new AvisoTomaDeHora($data_correo));
        }

        return view('Publico.clientes');

    }

    public function traedispodia(Request $request)
    {

        $retorno = DB::table('vtagenda_agenda')
            ->where([
                ['fechaunica', $_POST['id']],
                ['estadoAgenda', 1,]
            ])
            ->get();

        return $retorno;

    }

    public function confirmar_hora_web(Request $request)
    {

        DB::table('vtagenda_contacto')
            ->where('idContacto', decrypt($request->idcont))
            ->update([
                'confContacto' => 'SI',
                'fecconfContacto' => date('Y-m-d H:i:s')
            ]);

        return view('Publico.clientes');

    }

    public function cancelar_hora_web(Request $request)
    {

        $datos_cliente = DB::table('vtagenda_cliente')
            ->where('idCliente', $request->idcli)
            ->first();

        $h_f_at = DB::table('vtagenda_contacto')
            ->where('vtagenda_agenda_idAgenda', $request->idcont)
            ->first();

        $data_correo = array(
            'nombre_contacto' => $h_f_at->nombreContacto,
            'nombre_cliente' => $datos_cliente->nombreCliente,
            'telefono_contacto' => $h_f_at->celularContacto,
            'mail_contacto' => $h_f_at->correoContacto,
            'tipo_atencion' => $h_f_at->tipoAtencion,
            'observaciones' => $h_f_at->obsContacto,
            'fecha_hora' => date('d-m-Y', strtotime($h_f_at->fechaAtencion)) . ', a las ' . $h_f_at->horaAtencion . ' horas.',
            'fono' => $datos_cliente->fonoClienteVT,
        );

        Mail::to($h_f_at->correoContacto)
            ->cc($datos_cliente->correoCliente)
            ->bcc('soporte@virtualcall.cl')
            ->send(new AvisoCancelaHora($data_correo));

        //OK

        DB::table('vtagenda_agenda')
            ->where('idAgenda', $request->idcont)
            ->update(['estadoAgenda' => 1]);

        DB::table('vtagenda_contacto')
            ->where('vtagenda_agenda_idAgenda', $request->idcont)
            ->update([
                'estadoContacto' => 2, //1 Ingresado - //2 Anulada
                'fechaAtencion' => null,
                'horaAtencion' => null,
                'confContacto' => null,
                'fecconfContacto' => date('Y-m-d H:i:s'),
                'vtagenda_agenda_idAgenda' => null,
                'vtagenda_agenda_vtagenda_cliente_idCliente' => null,
            ]);

        return view('Publico.clientes');

    }


}
