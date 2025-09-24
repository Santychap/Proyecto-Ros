@extends('layouts.cliente')

@section('content')
<div class="pagos-container">
    <div class="pagos-header">
        <h1 class="pagos-title">
            <i class="fas fa-history"></i>
            Mi Historial de Pagos
        </h1>
        <p class="pagos-subtitle" style="color: #000000 !important;">
            Revisa todos tus pagos realizados
        </p>
    </div>

    @if($pagos->count() > 0)
        <div class="pagos-grid">
            @foreach($pagos as $pago)
                <div class="pago-card">
                    <div class="pago-header">
                        <div class="pago-id">Pedido #{{ $pago->pedido_id }}</div>
                        <div class="pago-status status-{{ $pago->estado }}">
                            {{ ucfirst($pago->estado) }}
                        </div>
                    </div>
                    
                    <div class="pago-info">
                        <div class="info-row">
                            <span class="label">Fecha:</span>
                            <span class="value">{{ $pago->fecha_pago->format('d/m/Y H:i') }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Monto:</span>
                            <span class="value precio">${{ number_format($pago->monto, 2) }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Método:</span>
                            <span class="value">{{ ucfirst($pago->metodo) }}</span>
                        </div>
                    </div>

                    
                    <div class="pago-productos">
                        <h4><i class="fas fa-utensils"></i> Productos:</h4>
                        @foreach($pago->pedido->detalles as $detalle)
                            <div class="producto-item">
                                <span class="producto-nombre">{{ $detalle->producto->nombre }}</span>
                                <span class="producto-cantidad">x{{ $detalle->cantidad }}</span>
                                <span class="producto-precio">${{ number_format($detalle->producto->precio * $detalle->cantidad, 2) }}</span>
                            </div>
                        @endforeach
                    </div>
                    
                    <div class="pago-actions">
                        <a href="{{ route('pagos.show', $pago) }}" class="btn-ver">
                            <i class="fas fa-eye"></i> Ver Detalle
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        

    @else
        <div class="empty-state">
            <i class="fas fa-receipt empty-icon"></i>
            <h3 class="empty-title">No tienes pagos registrados</h3>
            <p class="empty-description">Cuando realices tu primer pago, aparecerá aquí</p>
            <a href="{{ route('menu.index') }}" class="btn-menu">
                <i class="fas fa-utensils"></i> Explorar Menú
            </a>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.pagos-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.pagos-header {
    text-align: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    border-radius: 20px;
    border: 2px solid var(--color-primary);
}

.pagos-title {
    font-size: 2.5rem;
    color: #000000 !important;
    margin-bottom: 0.5rem;
    font-weight: bold;
    text-shadow: 1px 1px 2px rgba(255,255,255,0.3);
}

.pagos-title i {
    color: #000000 !important;
}

.pagos-subtitle {
    font-size: 1.1rem;
    color: #000000 !important;
    font-weight: 600;
    text-shadow: 1px 1px 2px rgba(255,255,255,0.3);
}

.pagos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
}

.pago-card {
    background: #000000 !important;
    border: 3px solid #ffd700 !important;
    border-radius: 20px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
}

.pago-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 30px rgba(255, 215, 0, 0.5), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
}

.pago-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid rgba(255, 215, 0, 0.3);
}

.pago-id {
    font-weight: bold;
    color: var(--color-primary);
    font-size: 1.1rem;
}

.pago-status {
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
    text-transform: uppercase;
}

.status-pagado {
    background: #51cf66;
    color: #000;
}

.status-pendiente {
    background: #ffa500;
    color: #000;
}

.pago-info {
    margin-bottom: 1rem;
}

.info-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.info-row .label {
    color: #cccccc !important;
    font-weight: 600;
}

.info-row .value {
    color: #ffffff !important;
    font-weight: 700;
}

.precio {
    color: #ffd700 !important;
    font-size: 1.2rem;
}

.pago-productos {
    background: rgba(255, 215, 0, 0.1);
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1rem;
}

.pago-productos h4 {
    color: var(--color-primary);
    margin-bottom: 0.5rem;
}

.producto-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.3rem 0;
    border-bottom: 1px solid rgba(255, 215, 0, 0.2);
}

.producto-nombre {
    flex: 1;
    color: #ffffff !important;
}

.producto-cantidad {
    color: var(--color-primary);
    font-weight: 600;
    margin: 0 1rem;
}

.producto-precio {
    color: #ffffff !important;
    font-weight: 600;
}

.pago-actions {
    text-align: center;
    padding-top: 1rem;
    border-top: 1px solid rgba(255, 215, 0, 0.3);
}

.btn-ver {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.8rem 1.5rem;
    background: var(--color-primary);
    color: #000;
    text-decoration: none;
    border-radius: 15px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-ver:hover {
    background: #ffed4e;
    transform: translateY(-2px);
}

.empty-state {
    text-align: center;
    padding: 4rem 2rem;
    background: #000000 !important;
    border: 3px solid #ffd700 !important;
    border-radius: 20px;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
}

.empty-icon {
    font-size: 5rem;
    color: var(--color-primary);
    margin-bottom: 1rem;
}

.empty-title {
    color: #ffffff !important;
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.empty-description {
    color: #cccccc !important;
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

.btn-menu {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 2rem;
    background: var(--color-primary);
    color: #000;
    text-decoration: none;
    border-radius: 15px;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
}

.btn-menu:hover {
    background: #ffed4e;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .pagos-grid {
        grid-template-columns: 1fr;
    }
    
    .pagos-container {
        padding: 1rem;
    }
    
    .pagos-title {
        font-size: 2rem;
    }
}
</style>
@endpush