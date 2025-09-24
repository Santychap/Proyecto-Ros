<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Inventario extends Model
{
    protected $table = 'inventario';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'categoria',
        'unidad_medida',
        'stock_inicial',
        'stock_actual',
        'stock_minimo',
        'stock_maximo',
        'precio_unitario',
        'proveedor',
        'fecha_vencimiento',
        'estado'
    ];

    protected $casts = [
        'fecha_vencimiento' => 'date',
        'stock_inicial' => 'decimal:2',
        'stock_actual' => 'decimal:2',
        'stock_minimo' => 'decimal:2',
        'stock_maximo' => 'decimal:2',
        'precio_unitario' => 'decimal:2'
    ];

    // Verificaciones de estado
    public function isAgotado()
    {
        return $this->stock_actual <= 0;
    }

    public function isBajoStock()
    {
        return $this->stock_actual <= $this->stock_minimo && $this->stock_actual > 0;
    }

    public function isSobreStock()
    {
        return $this->stock_actual >= $this->stock_maximo;
    }

    public function isPorVencer()
    {
        if (!$this->fecha_vencimiento) return false;
        return $this->fecha_vencimiento->diffInDays(now()) <= 7 && $this->fecha_vencimiento->isFuture();
    }

    // Obtener estado visual
    public function getEstadoStockAttribute()
    {
        if ($this->isAgotado()) return 'agotado';
        if ($this->isBajoStock()) return 'bajo_stock';
        if ($this->isSobreStock()) return 'sobre_stock';
        return 'normal';
    }

    // Obtener color del estado
    public function getColorEstadoAttribute()
    {
        switch ($this->estado_stock) {
            case 'agotado': return '#ff4757';
            case 'bajo_stock': return '#ffa502';
            case 'sobre_stock': return '#3742fa';
            default: return '#2ed573';
        }
    }

    // Obtener color de categoría
    public function getCategoriaColorAttribute()
    {
        $colores = [
            'proteina' => '#ff6b6b',
            'verdura' => '#51cf66',
            'condimento' => '#ffd43b',
            'lacteo' => '#74c0fc',
            'cereal' => '#d0bfff',
            'bebida' => '#4dabf7',
            'limpieza' => '#868e96',
            'otro' => '#495057'
        ];
        return $colores[$this->categoria] ?? '#495057';
    }

    // Valor total del stock
    public function getValorTotalStockAttribute()
    {
        return $this->stock_actual * $this->precio_unitario;
    }

    // Generar código automático
    public static function generarCodigo()
    {
        $ultimo = self::orderBy('id', 'desc')->first();
        $numero = $ultimo ? (intval(substr($ultimo->codigo, 3)) + 1) : 1;
        return 'INV' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    // Actualizar estado automáticamente
    public function actualizarEstado()
    {
        if ($this->isAgotado()) {
            $this->estado = 'agotado';
        } elseif ($this->isPorVencer()) {
            $this->estado = 'por_vencer';
        } else {
            $this->estado = 'disponible';
        }
        $this->save();
    }

    // Registrar movimiento de stock
    public function registrarMovimiento($tipo, $cantidad, $motivo, $observaciones = null, $precio = null)
    {
        $stockAnterior = $this->stock_actual;
        
        switch ($tipo) {
            case 'entrada':
                $this->stock_actual += $cantidad;
                break;
            case 'salida':
                $this->stock_actual = max(0, $this->stock_actual - $cantidad);
                break;
            case 'ajuste':
                $this->stock_actual = $cantidad;
                break;
        }
        
        $this->save();
        $this->actualizarEstado();
        
        // Aquí podrías registrar en una tabla de log si quisieras historial
        // Por ahora solo actualizamos el stock
        
        return true;
    }
}