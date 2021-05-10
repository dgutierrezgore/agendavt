<?php

namespace App\Http\Controllers;

use App\Mail\ConfirmarHora;
use Illuminate\Http\Request;
use DateTime;
use DB;
use Illuminate\Support\Facades\Mail;

class AvisoPublico extends Controller
{

    static function confirmacion_pormail($id)
    {

        $hora = DB::table('vtagenda_contacto')
            ->where([
                ['idContacto', $id],
                ['confContacto', null]
            ])
            ->count();

        if ($hora == 0) {

            return view('Publico.clientes_yaconfirmados');

        } else {
            DB::table('vtagenda_contacto')
                ->where('idContacto', $id)
                ->update([
                    'confContacto' => 'SI',
                    'fecconfContacto' => date('Y-m-d H:i:s')
                ]);

            return view('Publico.clientes_confirmados');
        }

    }

    static function cancelacion_pormail($id)
    {

        $hora = DB::table('vtagenda_contacto')
            ->where([
                ['idContacto', $id],
                ['confContacto', null]
            ])
            ->count();

        if ($hora == 0) {

            return view('Publico.clientes_yaconfirmados');

        } else {

            $id_agenda = DB::table('vtagenda_contacto')
                ->where('idContacto', $id)
                ->first();

            $id = $id_agenda->vtagenda_agenda_idAgenda;

            dd($id);

            DB::table('vtagenda_contacto')
                ->where('idContacto', $id)
                ->update([
                    'estadoContacto' => 2, //1 Ingresado - //2 Anulada
                    'fechaAtencion' => null,
                    'horaAtencion' => null,
                    'confContacto' => null,
                    'fecconfContacto' => date('Y-m-d H:i:s'),
                    'vtagenda_agenda_idAgenda' => null,
                    'vtagenda_agenda_vtagenda_cliente_idCliente' => null,
                ]);
        }

    }

}
