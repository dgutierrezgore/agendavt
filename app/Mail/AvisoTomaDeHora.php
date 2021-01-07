<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AvisoTomaDeHora extends Mailable
{
    use Queueable, SerializesModels;
    protected $mailData;

    public function __construct($mailData)
    {
        $this->mailData = $mailData;
    }


    public function build()
    {
        $mailData = array(
            'nombre_contacto' => $this->mailData['nombre_contacto'],
            'nombre_cliente' => $this->mailData['nombre_cliente'],
            'telefono_contacto' => $this->mailData['telefono_contacto'],
            'mail_contacto' => $this->mailData['mail_contacto'],
            'tipo_atencion' => $this->mailData['tipo_atencion'],
            'observaciones' => $this->mailData['observaciones'],
            'fecha_hora' => $this->mailData['fecha_hora'],
            'direccion' => $this->mailData['direccion'],
            'fono' => $this->mailData['fono'],
        );

        return $this->view('Correos.AvisoHoraVirtualCall')
            ->with([
                'data' => $mailData
            ]);

    }
}
