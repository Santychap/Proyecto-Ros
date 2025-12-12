<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pedido;
use App\Models\Pago;

class SincronizarPedidosPagos extends Command
{
    protected $signature = 'pedidos:sincronizar';
    protected $description = 'Sincroniza estados de pedidos y pagos desincronizados';

    public function handle()
    {
        $this->info('Iniciando sincronización de pedidos y pagos...');
        
        // Buscar pagos marcados como "pagado" pero con pedidos "Pendiente"
        $pagosDesincronizados = Pago::where('estado', 'pagado')
            ->whereHas('pedido', function($query) {
                $query->where('estado', 'Pendiente');
            })
            ->with('pedido')
            ->get();
            
        foreach ($pagosDesincronizados as $pago) {
            $pago->pedido->update(['estado' => 'Pagado']);
            $this->info("Pedido #{$pago->pedido->id} actualizado a Pagado");
        }
        
        // Buscar pedidos marcados como "Pagado" pero con pagos "pendiente"
        $pedidosDesincronizados = Pedido::where('estado', 'Pagado')
            ->whereHas('pago', function($query) {
                $query->where('estado', 'pendiente');
            })
            ->with('pago')
            ->get();
            
        foreach ($pedidosDesincronizados as $pedido) {
            $pedido->pago->update(['estado' => 'pagado']);
            $this->info("Pago del pedido #{$pedido->id} actualizado a pagado");
        }
        
        $this->info('Sincronización completada.');
        $this->info("Pagos sincronizados: " . $pagosDesincronizados->count());
        $this->info("Pedidos sincronizados: " . $pedidosDesincronizados->count());
        
        return 0;
    }
}