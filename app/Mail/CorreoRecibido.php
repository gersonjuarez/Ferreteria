<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class CorreoRecibido extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
        public $subject="Recibo";
        public $detalles;
        public $venta;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( $detalles,$venta)
    {
        $this->detalles=json_decode($detalles);
        $this->venta=json_decode($venta);

        
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.recibido');
    }
}
