@extends('layouts.cliente')

@section('content')
<div class="dashboard-main" style="padding: 30px; width: 100%;">
    <div style="max-width: 1200px; margin: 0 auto;">
        
        @if(session('success'))
            <div class="alert alert-success mb-4">
                <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error mb-4">
                <i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}
            </div>
        @endif

        <!-- Header -->
        <div class="chart-container" style="text-align: center; margin-bottom: 30px;">
            <i class="fas fa-check-circle" style="font-size: 4rem; color: #51cf66; margin-bottom: 1rem;"></i>
            <h1 class="title-primary" style="margin-bottom: 10px;">¡Pedido Confirmado!</h1>
            <p style="color: #cccccc; font-size: 1.1rem;">Tu pedido ha sido recibido y asignado a un empleado</p>
        </div>

        <!-- Detalles del pedido -->
        <div class="chart-container" style="margin-bottom: 30px;">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                <!-- Información del pedido -->
                <div>
                    <h2 class="chart-title" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                        <i class="fas fa-receipt"></i>
                        Pedido #{{ $pedido->id }}
                    </h2>
                    
                    <div class="space-y-3">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                            <span style="font-weight: 600; color: #ffd700;">Cliente:</span>
                            <span style="color: #ffffff;">{{ $pedido->user->name }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                            <span style="font-weight: 600; color: #ffd700;">Fecha:</span>
                            <span style="color: #ffffff;">{{ $pedido->created_at->format('d/m/Y H:i') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                            <span style="font-weight: 600; color: #ffd700;">Estado:</span>
                            <span class="status-badge status-{{ strtolower($pedido->estado) }}">
                                {{ $pedido->estado }}
                            </span>
                        </div>
                        @if($pedido->empleado)
                            <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                                <span style="font-weight: 600; color: #ffd700;">Empleado asignado:</span>
                                <span style="color: #ffffff;">{{ $pedido->empleado->name }}</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Tiempo para cancelar -->
                @if($puedeCancelar)
                    <div style="background: rgba(255, 165, 0, 0.2); border: 2px solid #ffa500; border-radius: 15px; padding: 20px;">
                        <h3 style="color: #ffa500; font-weight: 600; margin-bottom: 10px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-clock"></i>Tiempo para cancelar
                        </h3>
                        <p style="color: #cccccc; font-size: 0.9rem; margin-bottom: 15px;">
                            Tienes 10 minutos desde la confirmación para cancelar tu pedido.
                        </p>
                        <div id="countdown" style="font-size: 1.2rem; font-weight: bold; color: #ffa500;"></div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Productos del pedido -->
        <div class="chart-container" style="margin-bottom: 30px;">
            <h3 class="chart-title" style="margin-bottom: 20px;">Productos del pedido</h3>
            <div style="overflow-x: auto;">
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
                        @foreach($pedido->detalles as $detalle)
                            <tr>
                                <td>{{ $detalle->producto->nombre }}</td>
                                <td class="text-center">{{ $detalle->cantidad }}</td>
                                <td class="text-right">${{ number_format($detalle->producto->precio, 2) }}</td>
                                <td class="text-right font-semibold">${{ number_format($detalle->producto->precio * $detalle->cantidad, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr style="border-top: 2px solid #ffd700;">
                            <td colspan="3" style="text-align: right; font-weight: bold; color: #ffd700;">Total:</td>
                            <td style="text-align: right; font-weight: bold; font-size: 1.1rem; color: #ffd700;">${{ number_format($total, 2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Acciones -->
        <div style="text-align: center;">
            <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
                @if($pedido->estado === 'Pendiente')
                    @if($puedeCancelar)
                        <form action="{{ route('pedidos.cancelar', $pedido) }}" method="POST" 
                              onsubmit="return confirm('¿Estás seguro de que quieres cancelar este pedido?')">
                            @csrf
                            <button type="submit" class="btn" style="background: #ff4757; color: #fff;">
                                <i class="fas fa-times"></i>Cancelar Pedido
                            </button>
                        </form>
                    @endif

                    @if(!$pedido->pago)
                        <a href="{{ route('pagos.create', $pedido) }}" class="btn" style="background: #51cf66; color: #000;">
                            <i class="fas fa-credit-card"></i>Pagar Pedido
                        </a>
                    @else
                        <div style="background: rgba(74, 144, 226, 0.2); border: 2px solid #4a90e2; color: #4a90e2; padding: 15px; border-radius: 8px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-info-circle"></i>Pago ya procesado
                        </div>
                    @endif
                @endif

                <a href="{{ route('menu.index') }}" class="btn" style="background: #666; color: #fff;">
                    <i class="fas fa-utensils"></i>Volver al Menú
                </a>

                <a href="{{ route('pedidos.index') }}" class="btn btn-primary">
                    <i class="fas fa-list"></i>Mis Pedidos
                </a>
            </div>
        </div>
    </div>
</div>

@if($puedeCancelar)
<script>
// Countdown timer para cancelación
const createdAt = new Date('{{ $pedido->created_at->toISOString() }}');
const now = new Date();
const timeLimit = 10 * 60 * 1000; // 10 minutos en milisegundos
const elapsed = now.getTime() - createdAt.getTime();
const remaining = timeLimit - elapsed;

if (remaining > 0) {
    const countdownElement = document.getElementById('countdown');
    
    function updateCountdown() {
        const now = new Date();
        const elapsed = now.getTime() - createdAt.getTime();
        const remaining = timeLimit - elapsed;
        
        if (remaining <= 0) {
            countdownElement.innerHTML = 'Tiempo agotado';
            location.reload();
            return;
        }
        
        const minutes = Math.floor(remaining / 60000);
        const seconds = Math.floor((remaining % 60000) / 1000);
        
        countdownElement.innerHTML = `${minutes}:${seconds.toString().padStart(2, '0')}`;
    }
    
    updateCountdown();
    setInterval(updateCountdown, 1000);
}
</script>
@endif

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
<style>
.status-badge {
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
    text-transform: uppercase;
}

.status-pendiente {
    background: #ffa500;
    color: #000;
}

.status-pagado {
    background: #51cf66;
    color: #000;
}

.status-cancelado {
    background: #ff4757;
    color: #fff;
}

@media (max-width: 768px) {
    .dashboard-main {
        padding: 15px !important;
    }
    
    div[style*="grid-template-columns: 1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endpush
@endsection
