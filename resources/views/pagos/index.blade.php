@extends('layouts.menu')

@section('content')
<div class="container-fluid py-4 pagos-theme">
    <div class="row">
        <div class="col-12">
            <div class="header-pagos">
                <div class="header-content">
                    <div class="header-info">
                        <div class="header-icon">
                            <i class="fas fa-credit-card"></i>
                        </div>
                        <div>
                            <h1 class="header-title">Gestión de Pagos</h1>
                            <p class="header-subtitle">Administra los pagos del restaurante</p>
                        </div>
                    </div>
                    <button onclick="window.location.href='{{ route('pagos.create') }}'" class="btn-nuevo-pago">
                        <i class="fas fa-plus"></i>
                        <span>Nuevo Pago</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        @forelse($pagos as $pago)
        <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
            <div class="card pagos-card h-100 shadow-sm border-0 hover-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3 card-toprow">
                        <div class="badge badge-method-{{ $pago->metodo }} px-3 py-2 method-pill">
                            <i class="fas fa-{{ $pago->metodo == 'efectivo' ? 'money-bill' : ($pago->metodo == 'tarjeta' ? 'credit-card' : 'exchange-alt') }} me-1"></i>
                            {{ ucfirst($pago->metodo) }}
                        </div>
                        <span class="badge status-badge px-3 py-2">Completado</span>
                    </div>

                    <div class="card-heading">
                        <h5 class="card-title mb-1">Pedido #{{ $pago->pedido->numero }}</h5>
                        <p class="card-subtitle">{{ $pago->pedido->cliente }}</p>
                    </div>

                    <div class="meta-row">
                        <span class="meta-item"><i class="fas fa-table"></i>Mesa {{ $pago->pedido->mesa->numero }}</span>
                        <span class="meta-item"><i class="fas fa-calendar"></i>{{ $pago->fecha_pago->format('d/m/Y H:i') }}</span>
                    </div>

                    <div class="d-flex justify-content-between align-items-center amount-row">
                        <h4 class="mb-0">
                            ${{ number_format($pago->monto, 2) }}
                        </h4>
                        <div class="btn-group">
                            <a href="{{ route('pagos.show', $pago) }}" class="btn btn-outline-primary btn-sm">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('pagos.edit', $pago) }}" class="btn btn-outline-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('pagos.destroy', $pago) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('¿Estás seguro?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body text-center py-5">
                    <i class="fas fa-credit-card fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">No hay pagos registrados</h4>
                    <p class="text-muted">Comienza registrando el primer pago</p>
                    <a href="{{ route('pagos.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Registrar Pago
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    @if($pagos->hasPages())
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-center">
                {{ $pagos->links() }}
            </div>
        </div>
    </div>
    @endif
</div>

<style>
.pagos-theme {
    --pagos-bg: #0f1117;
    --pagos-panel: #111827;
    --pagos-panel-2: #0b0f1a;
    --pagos-text: #e5e7eb;
    --pagos-muted: #9ca3af;
    --pagos-gold: #f4d03f;
    --pagos-gold-2: #f39c12;
    --pagos-outline: rgba(244, 208, 63, 0.35);
}

.pagos-theme .header-pagos {
    background: linear-gradient(90deg, rgba(244,208,63,0.08), rgba(243,156,18,0.05));
    border: 1px solid var(--pagos-outline);
    box-shadow: 0 0 0 1px rgba(243,156,18,0.15) inset, 0 8px 30px rgba(0,0,0,0.35);
    border-radius: 16px;
}

.pagos-theme .header-content {
    display: flex; justify-content: space-between; align-items: center;
    padding: 18px 22px;
}

.pagos-theme .header-info { display: flex; gap: 14px; align-items: center; }
.pagos-theme .header-icon { color: var(--pagos-gold); font-size: 28px; }
.pagos-theme .header-title { color: var(--pagos-text); margin: 0; }
.pagos-theme .header-subtitle { color: var(--pagos-muted); margin: 0; }

.pagos-theme .btn-nuevo-pago {
    background: #0b0f1a;
    border: 1px solid var(--pagos-gold);
    color: #ffffff;
    padding: 10px 14px; border-radius: 12px; font-weight: 600;
}

.pagos-theme .btn-nuevo-pago i { margin-right: 6px; color: inherit; }
.pagos-theme .btn-nuevo-pago:hover { background: var(--pagos-gold); color: #0b0f1a; box-shadow: 0 0 18px rgba(244,208,63,0.35); }

.pagos-theme .card {
    background: linear-gradient(180deg, var(--pagos-panel) 0%, var(--pagos-panel-2) 100%);
    border-radius: 16px;
    border: 1px solid rgba(255,255,255,0.04);
    box-shadow: 0 0 0 1px rgba(255,255,255,0.02) inset, 0 10px 30px rgba(0,0,0,0.35);
}

.pagos-theme .card-title { color: var(--pagos-text) !important; }
.pagos-theme .text-muted { color: var(--pagos-muted) !important; }

.pagos-theme .hover-card { position: relative; }
.pagos-theme .hover-card::before {
    content: ""; position: absolute; inset: 0; border-radius: 16px; pointer-events: none;
    box-shadow: 0 0 0 1px rgba(244,208,63,0.12), 0 0 22px rgba(244,208,63,0.05);
}

/* Maquetación tipo tarjeta de menú */
.pagos-theme .card-body { display: flex; flex-direction: column; gap: 14px; }
.pagos-theme .pagos-card .card-body { padding: 22px !important; }
.pagos-theme .d-flex.justify-content-between.align-items-start { margin-bottom: 8px !important; }
.pagos-theme .amount-row { display: flex; justify-content: space-between; align-items: center; margin-top: 8px; }
.pagos-theme .amount-row h4 { color: var(--pagos-gold) !important; letter-spacing: 0.3px; }
.pagos-theme .btn-group { margin-top: 6px; gap: 10px; }
.pagos-theme .btn-group .btn { width: 46px; height: 46px; display: inline-flex; align-items: center; justify-content: center; }
.pagos-theme .btn-group .btn i { font-size: 16px; }

.pagos-theme .card-heading .card-title { font-size: 1.15rem; font-weight: 700; color: var(--pagos-text); }
.pagos-theme .card-heading .card-subtitle { font-size: 0.95rem; color: var(--pagos-muted); margin: 0; }
.pagos-theme .meta-row { display: flex; gap: 14px; flex-wrap: wrap; color: var(--pagos-muted); }
.pagos-theme .meta-row .meta-item { display: inline-flex; align-items: center; gap: 8px; }
.pagos-theme .meta-row .meta-item i { color: var(--pagos-gold); }

/* Badge método como pill, no franja */
.pagos-theme .badge[class^="badge-method-"] {
    display: inline-flex; align-items: center; gap: 6px; border-radius: 999px; line-height: 1; width: auto; min-width: 0; box-shadow: 0 0 0 1px rgba(0,0,0,0.15) inset;
}
.pagos-theme .badge.bg-success { border-radius: 999px; }

/* Card tipo menú: bordes internos y espaciado */
.pagos-theme .pagos-card { overflow: hidden; }
.pagos-theme .pagos-card .card-toprow { padding-bottom: 10px; border-bottom: 1px solid rgba(255,255,255,0.06); }
.pagos-theme .method-pill i { margin-right: 4px; }
.pagos-theme .status-badge { background: rgba(244,208,63,0.15); color: var(--pagos-gold); border: 1px solid var(--pagos-outline); border-radius: 999px; }
.hover-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 16px 38px rgba(0,0,0,0.35) !important;
}

.badge-method-efectivo { background: linear-gradient(45deg, #22c55e, #16a34a); color: #0b0f1a; box-shadow: 0 0 12px rgba(34,197,94,0.25); }
.badge-method-tarjeta { background: linear-gradient(45deg, #60a5fa, #7c3aed); color: #0b0f1a; box-shadow: 0 0 12px rgba(96,165,250,0.25); }
.badge-method-transferencia { background: linear-gradient(45deg, #f59e0b, #ef4444); color: #0b0f1a; box-shadow: 0 0 12px rgba(245,158,11,0.25); }

.pagos-theme .btn-group .btn {
    background: #0b0f1a;
    border: 1px solid rgba(244,208,63,0.35);
    color: #ffffff;
    border-radius: 10px;
}
.pagos-theme .btn-group .btn i { color: inherit; }
.pagos-theme .btn-group .btn:hover { background: var(--pagos-gold); border-color: var(--pagos-gold); color: #0b0f1a; }

/* Asegurar que ningún outline de Bootstrap vuelva el botón blanco */
.pagos-theme .btn-outline-danger,
.pagos-theme .btn-outline-warning,
.pagos-theme .btn-outline-primary {
    background: #0b0f1a !important;
    color: #ffffff !important;
    border-color: rgba(244,208,63,0.35) !important;
}
.pagos-theme .btn-outline-danger:hover,
.pagos-theme .btn-outline-warning:hover,
.pagos-theme .btn-outline-primary:hover {
    background: var(--pagos-gold) !important;
    color: #0b0f1a !important;
    border-color: var(--pagos-gold) !important;
}

</style>
@endsection