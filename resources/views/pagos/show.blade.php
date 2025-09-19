@extends('layouts.menu')

@section('content')
<div class="container-fluid py-4 pagos-theme">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">
                                <i class="fas fa-eye me-2"></i>Detalles del Pago
                            </h4>
                            <p class="mb-0 opacity-8">Información completa del pago</p>
                        </div>
                        <div>
                            <a href="{{ route('pagos.edit', $pago) }}" class="btn btn-warning btn-sm me-2">
                                <i class="fas fa-edit me-1"></i>Editar
                            </a>
                            <a href="{{ route('pagos.index') }}" class="btn btn-light btn-sm">
                                <i class="fas fa-arrow-left me-1"></i>Volver
                            </a>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="info-group mb-4">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-receipt me-2"></i>INFORMACIÓN DEL PEDIDO
                                </h6>
                                <div class="panel-dark p-3 rounded">
                                    <p class="mb-2"><strong>Número:</strong> #{{ $pago->pedido->numero }}</p>
                                    <p class="mb-2"><strong>Cliente:</strong> {{ $pago->pedido->cliente }}</p>
                                    <p class="mb-2"><strong>Mesa:</strong> {{ $pago->pedido->mesa->numero }}</p>
                                    <p class="mb-0"><strong>Total Pedido:</strong> 
                                        <span class="amount-gold fw-bold">${{ number_format($pago->pedido->total, 2) }}</span>
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="info-group mb-4">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-credit-card me-2"></i>INFORMACIÓN DEL PAGO
                                </h6>
                                <div class="panel-dark p-3 rounded">
                                    <p class="mb-2"><strong>Monto:</strong> 
                                        <span class="amount-gold fw-bold fs-5">${{ number_format($pago->monto, 2) }}</span>
                                    </p>
                                    <p class="mb-2"><strong>Método:</strong> 
                                        <span class="badge badge-method-{{ $pago->metodo }} px-3 py-2 method-pill">
                                            <i class="fas fa-{{ $pago->metodo == 'efectivo' ? 'money-bill' : ($pago->metodo == 'tarjeta' ? 'credit-card' : ($pago->metodo == 'transferencia' ? 'exchange-alt' : 'qrcode')) }} me-1"></i>
                                            {{ ucfirst($pago->metodo) }}
                                        </span>
                                    </p>
                                    <p class="mb-2"><strong>Estado:</strong> 
                                        <span class="badge status-badge px-3 py-2">Completado</span>
                                    </p>
                                    <p class="mb-0"><strong>Fecha:</strong> {{ $pago->fecha_pago->format('d/m/Y H:i:s') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="info-group mb-4">
                                <h6 class="text-muted mb-2">
                                    <i class="fas fa-clock me-2"></i>REGISTRO DEL SISTEMA
                                </h6>
                                <div class="panel-dark p-3 rounded">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p class="mb-0"><strong>Creado:</strong> {{ $pago->created_at->format('d/m/Y H:i:s') }}</p>
                                        </div>
                                        <div class="col-md-6">
                                            <p class="mb-0"><strong>Actualizado:</strong> {{ $pago->updated_at->format('d/m/Y H:i:s') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4 actions-bar">
                        <a href="{{ route('pagos.index') }}" class="btn btn-secondary">
                            <i class="fas fa-list me-2"></i>Ver Todos los Pagos
                        </a>
                        <a href="{{ route('pagos.edit', $pago) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Editar Pago
                        </a>
                        <form action="{{ route('pagos.destroy', $pago) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este pago?')">
                                <i class="fas fa-trash me-2"></i>Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.pagos-theme { --pagos-bg:#0f1117; --pagos-panel:#111827; --pagos-panel-2:#0b0f1a; --pagos-text:#e5e7eb; --pagos-muted:#9ca3af; --pagos-gold:#f4d03f; --pagos-outline:rgba(244,208,63,0.35); }
.pagos-theme .card { background: linear-gradient(180deg, var(--pagos-panel) 0%, var(--pagos-panel-2) 100%); border-radius: 16px; border: 1px solid rgba(255,255,255,0.04); box-shadow: 0 0 0 1px rgba(255,255,255,0.02) inset, 0 10px 30px rgba(0,0,0,0.35); }
.pagos-theme .card-header { background: linear-gradient(90deg, rgba(244,208,63,0.08), rgba(243,156,18,0.05)); border-bottom: 1px solid var(--pagos-outline); border-top-left-radius: 16px; border-top-right-radius: 16px; padding: 18px 22px; }
.pagos-theme .card-header h4 { color: var(--pagos-text); }
.pagos-theme .opacity-8 { color: var(--pagos-muted) !important; }
.pagos-theme .panel-dark { background: #0b0f1a; border: 1px solid rgba(255,255,255,0.06); color: var(--pagos-text); border-radius: 12px; padding: 14px; }
.pagos-theme .amount-gold { color: var(--pagos-gold); }

/* Pills uniformes negro/dorado */
.method-pill,
.status-badge,
.badge-method-efectivo,
.badge-method-tarjeta,
.badge-method-transferencia,
.badge-method-qr {
    background: rgba(244,208,63,0.12) !important;
    color: var(--pagos-gold) !important;
    border: 1px solid var(--pagos-outline) !important;
    border-radius: 999px !important;
}
.method-pill { display:inline-flex; align-items:center; gap:6px; padding-top:6px; padding-bottom:6px; }
.method-pill i { color: var(--pagos-gold) !important; }
.status-badge { padding-top:6px; padding-bottom:6px; }

/* Botones negro/blanco con acento dorado */
.pagos-theme .btn { border-radius: 10px; }
.pagos-theme .btn-light, .pagos-theme .btn-secondary, .pagos-theme .btn-warning, .pagos-theme .btn-danger { background:#0b0f1a !important; color:#ffffff !important; border:1px solid var(--pagos-outline) !important; }
.pagos-theme .btn-light:hover, .pagos-theme .btn-secondary:hover, .pagos-theme .btn-warning:hover, .pagos-theme .btn-danger:hover { background: var(--pagos-gold) !important; color:#0b0f1a !important; border-color: var(--pagos-gold) !important; }

.info-group h6 { font-weight:700; font-size: .8rem; letter-spacing:.6px; color: var(--pagos-gold); margin: 8px 0 8px !important; display:inline-flex; align-items:center; gap:8px; padding:4px 8px; border:1px solid var(--pagos-outline); border-radius:999px; background: rgba(244,208,63,0.08); }
.info-group + .info-group { margin-top: 8px; }

/* Paneles internos y tipografía */
.panel-dark p { margin-bottom: 8px; color: var(--pagos-text); }
.panel-dark strong { color: var(--pagos-muted); font-weight: 600; }
.panel-dark .amount-gold { font-size: 1.05rem; font-weight: 700; }

/* Footer de acciones */
.actions-bar { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); padding: 14px; border-radius: 12px; }
</style>
@endsection