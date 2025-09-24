@extends('layouts.cliente')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header -->
        <div class="card mb-6">
            <div class="card-header text-center">
                <h1 class="text-2xl font-bold flex items-center justify-center text-primary">
                    <i class="fas fa-receipt mr-3"></i>
                    Detalle del Pago
                </h1>
                <p class="text-muted mt-2">Información completa del pago realizado</p>
            </div>
        </div>

        <!-- Información del pago -->
        <div class="card mb-6">
            <div class="grid md:grid-cols-2 gap-6">
                <!-- Información básica -->
                <div>
                    <h2 class="text-xl font-semibold mb-4 flex items-center text-primary">
                        <i class="fas fa-info-circle mr-2"></i>
                        Información del Pago
                    </h2>
                    
                    <div class="space-y-3">
                        <div class="info-row">
                            <span class="info-label">ID del Pago:</span>
                            <span class="text-light">#{{ $pago->id }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Pedido:</span>
                            <span class="text-light">#{{ $pago->pedido->id }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Cliente:</span>
                            <span class="text-light">{{ $pago->pedido->user->name }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Fecha del Pago:</span>
                            <span class="text-light">{{ $pago->fecha_pago->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="info-label">Estado:</span>
                            <span class="status-badge status-{{ strtolower($pago->estado) }}">
                                {{ ucfirst($pago->estado) }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Método de pago y monto -->
                <div>
                    <h2 class="text-xl font-semibold mb-4 flex items-center text-primary">
                        <i class="fas fa-credit-card mr-2"></i>
                        Método de Pago
                    </h2>
                    
                    <div class="text-center payment-method-display">
                        <div class="mb-4">
                            @if($pago->metodo === 'efectivo')
                                <i class="fas fa-money-bill-wave text-primary text-4xl"></i>
                                <h3 class="text-lg font-semibold mt-2 text-light">Efectivo</h3>
                            @elseif($pago->metodo === 'pse')
                                <i class="fas fa-university text-primary text-4xl"></i>
                                <h3 class="text-lg font-semibold mt-2 text-light">PSE</h3>
                            @elseif($pago->metodo === 'nequi')
                                <i class="fas fa-mobile-alt text-primary text-4xl"></i>
                                <h3 class="text-lg font-semibold mt-2 text-light">Nequi</h3>
                            @elseif($pago->metodo === 'daviplata')
                                <i class="fas fa-wallet text-primary text-4xl"></i>
                                <h3 class="text-lg font-semibold mt-2 text-light">Daviplata</h3>
                            @elseif($pago->metodo === 'bancolombia')
                                <i class="fas fa-building text-primary text-4xl"></i>
                                <h3 class="text-lg font-semibold mt-2 text-light">Transferencia Bancolombia</h3>
                            @endif
                        </div>
                        
                        <div class="text-3xl font-bold text-primary">
                            ${{ number_format($pago->monto, 2) }}
                        </div>
                        <p class="text-muted mt-1">Monto pagado</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detalles del pedido -->
        <div class="card mb-6">
            <h2 class="text-xl font-semibold mb-4 flex items-center text-primary">
                <i class="fas fa-shopping-bag mr-2"></i>
                Detalles del Pedido
            </h2>
            
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-right">Precio Unit.</th>
                            <th class="text-right">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pago->pedido->detalles as $detalle)
                            <tr>
                                <td>{{ $detalle->producto->nombre }}</td>
                                <td class="text-center">{{ $detalle->cantidad }}</td>
                                <td class="text-right">${{ number_format($detalle->producto->precio, 2) }}</td>
                                <td class="text-right font-semibold">${{ number_format($detalle->producto->precio * $detalle->cantidad, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="total-row">
                            <td colspan="3" class="text-right font-bold">Total:</td>
                            <td class="text-right font-bold text-lg text-primary">${{ number_format($pago->monto, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Datos adicionales del pago -->
        @if($pago->datos_pago && count($pago->datos_pago) > 0)
            <div class="card mb-6">
                <h2 class="text-xl font-semibold mb-4 flex items-center text-primary">
                    <i class="fas fa-file-alt mr-2"></i>
                    Datos Adicionales del Pago
                </h2>
                
                <div class="additional-data">
                    <div class="grid md:grid-cols-2 gap-4">
                        @foreach($pago->datos_pago as $key => $value)
                            @if($value)
                                <div class="info-row">
                                    <span class="info-label">{{ ucfirst(str_replace('_', ' ', $key)) }}:</span>
                                    <span class="text-light">{{ $value }}</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Cambiar estado (solo para admin/empleado y efectivo) -->
        @if(in_array(auth()->user()->rol, ['admin', 'empleado']) && $pago->metodo === 'efectivo')
            <div class="card mb-6">
                <h2 class="text-xl font-semibold mb-4 flex items-center text-primary">
                    <i class="fas fa-cog mr-2"></i>
                    Cambiar Estado del Pago
                </h2>
                
                <form action="{{ route('pagos.cambiarEstado', $pago) }}" method="POST" class="flex items-center space-x-4" 
                      onsubmit="return confirm('¿Estás seguro de cambiar el estado del pago?')">
                    @csrf
                    @method('PUT')
                    
                    <select name="estado" class="form-select" required>
                        <option value="pendiente" {{ $pago->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="pagado" {{ $pago->estado === 'pagado' ? 'selected' : '' }}>Pagado</option>
                    </select>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save mr-2"></i>Actualizar Estado
                    </button>
                </form>
                
                <p class="text-sm text-muted mt-2">
                    <i class="fas fa-info-circle mr-1"></i>
                    Solo se puede cambiar el estado de pagos en efectivo
                </p>
            </div>
        @endif

        <!-- Botones de acción -->
        <div class="text-center">
            <div class="flex justify-center space-x-4">
                <a href="{{ route('pagos.historial') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>Volver a Pagos
                </a>
                
                <a href="{{ route('pedidos.confirmacion', $pago->pedido) }}" class="btn btn-primary">
                    <i class="fas fa-receipt mr-2"></i>Ver Pedido
                </a>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
.info-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.info-label {
    font-weight: 600;
    color: var(--color-primary);
    min-width: 120px;
}

.payment-method-display {
    background: rgba(255, 215, 0, 0.1);
    border-radius: 10px;
    padding: 1.5rem;
}

.additional-data {
    background: rgba(255, 215, 0, 0.1);
    border-radius: 10px;
    padding: 1rem;
}

.total-row {
    background: rgba(255, 215, 0, 0.2);
    border-top: 2px solid var(--color-primary);
}

.form-select {
    background: rgba(255, 255, 255, 0.1);
    border: 2px solid var(--color-primary);
    border-radius: 8px;
    padding: 0.5rem;
    color: var(--text-light);
}

.form-select:focus {
    outline: none;
    border-color: var(--color-primary-light);
    box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.3);
}
</style>
@endpush
@endsection