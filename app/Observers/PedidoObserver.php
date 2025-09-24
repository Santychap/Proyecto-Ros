<?php

namespace App\Observers;

use App\Models\Pedido;

class PedidoObserver
{
    public function creating(Pedido $pedido)
    {
        if (!$pedido->user_id) {
            $pedido->user_id = auth()->id();
        }
    }

    public function updated(Pedido $pedido)
    {
        if ($pedido->wasChanged('estado') && $pedido->estado === 'Completado') {
            // Lógica cuando un pedido se completa
            \Log::info("Pedido {$pedido->id} completado");
        }
    }

    public function deleted(Pedido $pedido)
    {
        // Eliminar detalles relacionados
        $pedido->detalles()->delete();
    }
}