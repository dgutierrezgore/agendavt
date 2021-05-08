<?php

namespace App\Console\Commands;

use App\Mail\ConfirmarHora;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use DB;

class EnviarMail extends Command
{

    protected $signature = 'enviarmail:task';

    protected $description = 'Envio de Correo de Confirmación';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $mails_aviso = DB::table('vtagenda_contacto')
            ->join('vtagenda_cliente', 'vtagenda_cliente.idCliente', 'vtagenda_contacto.vtagenda_agenda_vtagenda_cliente_idCliente')
            ->where([
                ['confContacto', null],
                ['fecconfContacto', null],
            ])
            ->whereDate('fechaAtencion', date('Y-m-d'))
            ->get();

        foreach ($mails_aviso as $key => $value) {

            $data_correo = array(
                'id_contacto' => $mails_aviso[$key]->idContacto,
                'rutContacto' => $mails_aviso[$key]->rutContacto,
                'nombre_contacto' => $mails_aviso[$key]->nombreContacto,
                'nombre_cliente' => $mails_aviso[$key]->nombreCliente,
                'telefono_contacto' => $mails_aviso[$key]->celularContacto,
                'mail_contacto' => $mails_aviso[$key]->correoContacto,
                'tipo_atencion' => $mails_aviso[$key]->tipoAtencion,
                'observaciones' => $mails_aviso[$key]->obsContacto,
                'fecha_hora' => date('d-m-Y', strtotime($mails_aviso[$key]->fechaAtencion)) . ', a las ' . $mails_aviso[$key]->horaAtencion . ' horas.',
                'direccion' => $mails_aviso[$key]->direccionCliente,
                'fono' => $mails_aviso[$key]->fonoClienteVT,
            );

            Mail::to($mails_aviso[$key]->correoContacto)
                ->bcc('soporte@virtualcall.cl')
                ->send(new ConfirmarHora($data_correo));

        }
    }
}
