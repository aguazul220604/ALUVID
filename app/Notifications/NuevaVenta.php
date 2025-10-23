<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NuevaVenta extends Notification
{
    use Queueable;

    public $venta;

    public function __construct($venta)
    {
        $this->venta = $venta;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'mensaje' => 'Se ha registrado una nueva venta',
            'folio' => $this->venta->id,
            'fecha' => now()->toDateTimeString(),
        ];
    }
}
