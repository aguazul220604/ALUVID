<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class Inventario extends Notification
{
    use Queueable;

    public $inventario;
    public $categoria;

    public function __construct($inventario, $categoria)
    {
        $this->inventario = $inventario;
        $this->categoria = $categoria;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $data = [
            'mensaje' => 'Se ha actualizado el inventario',
            'categoria' => $this->categoria,
            'fecha' => now()->toDateTimeString(),
        ];

        if ($this->categoria === 'Vidrios') {
            $data['tonalidad'] = $this->inventario->tonalidad;
            $data['mm'] = $this->inventario->mm;
        } else {
            $data['producto'] = $this->inventario->producto ?? 'Producto no definido';
        }

        return $data;
    }
}
