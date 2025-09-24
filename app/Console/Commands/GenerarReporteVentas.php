<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\RestauranteService;

class GenerarReporteVentas extends Command
{
    protected $signature = 'restaurante:reporte-ventas {fecha?}';
    protected $description = 'Generar reporte de ventas del día';

    public function handle(RestauranteService $service)
    {
        $fecha = $this->argument('fecha') ?? now()->toDateString();
        
        $this->info("Generando reporte de ventas para: {$fecha}");
        
        $ventas = $service->calcularVentasDelDia($fecha);
        $productos = $service->obtenerProductosMasVendidos();
        
        $this->table(['Métrica', 'Valor'], [
            ['Ventas del día', '$' . number_format($ventas, 2)],
            ['Productos más vendidos', $productos->pluck('nombre')->implode(', ')],
        ]);
        
        $this->info('Reporte generado exitosamente');
    }
}