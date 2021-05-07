<?php

namespace App\Http\Controllers;

use App\Mail\AvisoCancelaHora;
use App\Mail\AvisoDocumentoInterno;
use App\Mail\AvisoTomaDeHora;
use Illuminate\Http\Request;
use DateTime;
use DatePeriod;
use DateInterval;
use DB;
use Auth;
use Illuminate\Support\Facades\Mail;

class AgendaController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function ver()
    {

        $mi_calendario = DB::table('vtagenda_contacto')
            ->where('vtagenda_agenda_vtagenda_cliente_idCliente', '=', Auth::user()->idCliente)
            ->get();

        //dd($mi_calendario);

        return view('Agenda.Ver', [
            'micalendario' => $mi_calendario
        ]);
    }

    public function contactos()
    {

        $fecha_ges = new DateTime(NOW());

        $disp_hora = DB::table('vtagenda_agenda')
            ->where([
                ['estadoAgenda', '=', 1],
                ['vtagenda_cliente_idCliente', '=', Auth::user()->idCliente],
                ['fechaAgenda', '>=', $fecha_ges->modify('-1 day')]
            ])
            ->get();

        $contactos = DB::table('vtagenda_contacto')
            ->where([
                ['vtagenda_agenda_vtagenda_cliente_idCliente', '=', Auth::user()->idCliente],
                ['fechaAtencion', '>=', $fecha_ges->modify('-1 day')]
            ])
            ->get();

        return view('Contactos.Crear', [
            'dispo' => $disp_hora,
            'contactos' => $contactos
        ]);

    }

    public function crear_contactos(Request $request)
    {

        $datos_cliente = DB::table('vtagenda_cliente')
            ->where('idCliente', Auth::user()->idCliente)
            ->first();

        $h_f_at = DB::table('vtagenda_agenda')
            ->where('idAgenda', $request->hatc)
            ->first();

        $data_correo = array(
            'rutContacto' => $request->rut,
            'nombre_contacto' => $request->nombrec,
            'nombre_cliente' => $datos_cliente->nombreCliente,
            'telefono_contacto' => $request->telefonoc,
            'mail_contacto' => $request->mailc,
            'tipo_atencion' => $request->tat,
            'observaciones' => $request->obsc,
            'fecha_hora' => date('d-m-Y', strtotime($h_f_at->fechaAgenda)) . ', a las ' . $h_f_at->horaAgenda . ' horas.',
            'direccion' => $datos_cliente->direccionCliente,
            'fono' => $datos_cliente->fonoClienteVT,
        );

        Mail::to($request->mailc)
            ->cc($datos_cliente->correoCliente)
            ->bcc('soporte@virtualcall.cl')
            ->send(new AvisoTomaDeHora($data_correo));

        $min_cliente = DB::table('vtagenda_cliente')
            ->where('idCliente', '=', Auth::user()->idCliente)
            ->pluck('tipoAgenda');

        $intervarlo = $min_cliente;

        $trae_fecha = DB::table('vtagenda_agenda')
            ->where('idAgenda', '=', $request->hatc)
            ->pluck('fechaAgenda');

        $trae_hora = DB::table('vtagenda_agenda')
            ->where('idAgenda', '=', $request->hatc)
            ->pluck('horaAgenda');

        $hora_fin = $trae_hora[0];

        $fechaFin = new DateTime($hora_fin);
        $fechaFin = $fechaFin->modify('+' . $intervarlo[0] . 'minutes');

        DB::table('vtagenda_contacto')->insert([
            'rutContacto' => $request->rut,
            'nombreContacto' => $request->nombrec,
            'celularContacto' => $request->telefonoc,
            'correoContacto' => $request->mailc,
            'tipoAtencion' => $request->tat,
            'obsContacto' => $request->obsc,
            'estadoContacto' => 1,
            'fechaRegistro' => date('Y-m-d H:i:s'),
            'fechaAtencion' => $trae_fecha[0],
            'horaAtencion' => $trae_hora[0],
            'horaFinAtencion' => $fechaFin->format('H:i'),
            'vtagenda_agenda_idAgenda' => $request->hatc,
            'vtagenda_agenda_vtagenda_cliente_idCliente' => Auth::user()->idCliente
        ]);

        // Update
        DB::table('vtagenda_agenda')
            ->where('idAgenda', $request->hatc)
            ->update(['estadoAgenda' => 2]);

        return back();
    }

    public function crear()
    {

        $fecha_ges = new DateTime(NOW());

        $cliente = DB::table('vtagenda_cliente')
            ->where('idCliente', '=', Auth::user()->idCliente)
            ->first();

        $fechas_agenda = DB::table('vtagenda_agenda')
            ->select(DB::raw('count(*) as horaAgenda, fechaAgenda'))
            ->where([
                ['vtagenda_cliente_idCliente', '=', Auth::user()->idCliente],
                ['fechaAgenda', '>=', $fecha_ges->modify('-1 day')]
            ])
            ->groupBy('fechaAgenda')
            ->get();

        return view('Agenda.Crear', [
            'cliente' => $cliente,
            'disponibilidad' => $fechas_agenda
        ]);

    }

    public function crear_disponibilidad(Request $request)
    {

        $request->validate([
            'fecha_ini' => 'required|min:3',
            //...
        ]);

        $min_cliente = DB::table('vtagenda_cliente')
            ->where('idCliente', '=', Auth::user()->idCliente)
            ->pluck('tipoAgenda');

        $var1 = $request->hora_ini;
        $var2 = $request->hora_fin;
        $intervarlo = $min_cliente;

        $dias = (strtotime($request->fecha_ini) - strtotime($request->fecha_fin)) / 86400;
        $dias = abs($dias);
        $dias = intval($dias);

        $fechaInicio = new DateTime($var1);
        $fechaFin = new DateTime($var2);
        $fechaFin = $fechaFin->modify('+' . $intervarlo[0] . 'minutes');

        $rangoFechas = new DatePeriod($fechaInicio, new DateInterval('PT' . $intervarlo[0] . 'M'), $fechaFin);

        if ((strtotime($request->fecha_ini)) == (strtotime($request->fecha_fin))) {
            foreach ($rangoFechas as $fecha) {
                DB::table('vtagenda_agenda')->insert([
                    'fechaAgenda' => $request->fecha_ini,
                    'horaAgenda' => $fecha->format('H:i'),
                    'fechahoraunica' => Auth::user()->idCliente . "-" . $request->fecha_ini . "-" . $fecha->format('H:i'),
                    'fechaunica' => Auth::user()->idCliente . "-" . $request->fecha_ini,
                    'estadoAgenda' => 1,
                    'vtagenda_cliente_idCliente' => Auth::user()->idCliente
                ]);
            }
        } else {
            $fecha_ges = new DateTime($request->fecha_ini);
            //dd($fecha_ges);
            for ($i = 0; $i <= $dias; $i++) {
                foreach ($rangoFechas as $fecha) {
                    DB::table('vtagenda_agenda')->insert([
                        'fechaAgenda' => $fecha_ges,
                        'horaAgenda' => $fecha->format('H:i'),
                        'fechahoraunica' => Auth::user()->idCliente . "-" . $fecha_ges->format('Y-m-d') . "-" . $fecha->format('H:i'),
                        'fechaunica' => Auth::user()->idCliente . "-" . $fecha_ges->format('Y-m-d'),
                        'estadoAgenda' => 1,
                        'vtagenda_cliente_idCliente' => Auth::user()->idCliente
                    ]);
                }
                $fecha_ges = $fecha_ges->modify('+1 day');
            }
        }


        return back();
    }

    public function modificar()
    {

        $fecha_ges = new DateTime(NOW());

        $fechas_agenda = DB::table('vtagenda_agenda')
            ->leftjoin('vtagenda_contacto', 'vtagenda_contacto.vtagenda_agenda_idAgenda', 'vtagenda_agenda.idAgenda')
            ->where([
                ['vtagenda_cliente_idCliente', '=', Auth::user()->idCliente],
                ['fechaAgenda', '>=', $fecha_ges->modify('-1 day')],
            ])
            ->orderby('fechaAgenda')
            ->orderby('horaAgenda')
            ->get();

        return view('Agenda.Modificar', [
            'disponibilidad' => $fechas_agenda
        ]);

    }

    public function deshabilitar(Request $request)
    {

        DB::table('vtagenda_agenda')
            ->where('idAgenda', $request->hatc)
            ->update(['estadoAgenda' => 4]);

        return back();

    }

    public function habilitar(Request $request)
    {

        DB::table('vtagenda_agenda')
            ->where('idAgenda', $request->hatc)
            ->update(['estadoAgenda' => 1]);

        return back();

    }

    public function cancelar(Request $request)
    {

        $datos_cliente = DB::table('vtagenda_cliente')
            ->where('idCliente', Auth::user()->idCliente)
            ->first();

        $h_f_at = DB::table('vtagenda_contacto')
            ->where('vtagenda_agenda_idAgenda', $request->hatc)
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

        DB::table('vtagenda_agenda')
            ->where('idAgenda', $request->hatc)
            ->update(['estadoAgenda' => 1]);

        DB::table('vtagenda_contacto')
            ->where('vtagenda_agenda_idAgenda', $request->hatc)
            ->update([
                'estadoContacto' => 2, //1 Ingresado - //2 Anulada
                'fechaAtencion' => null,
                'horaAtencion' => null,
                'confContacto' => null,
                'fecconfContacto' => date('Y-m-d H:i:s'),
                'vtagenda_agenda_idAgenda' => null,
                'vtagenda_agenda_vtagenda_cliente_idCliente' => null,
            ]);

        return back();

    }

    public function trae_datos(Request $request)
    {

        $num_rut = DB::table('vtagenda_contacto')
            ->where('rutContacto', $request->rut)
            ->count();

        $datos_externos = DB::table('vtagenda_contacto')
            ->where('rutContacto', $request->rut)
            ->get();

        if ($num_rut == 0) {
            echo 2;
        } else {
            return $datos_externos;
        }

    }

}
