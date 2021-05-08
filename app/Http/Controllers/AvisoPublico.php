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

}
