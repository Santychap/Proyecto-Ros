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
                                <i class="fas fa-edit me-2"></i>Editar Pago
                            </h4>
                            <p class="mb-0 opacity-8">Modifica la información del pago</p>
                        </div>
                        <a href="{{ route('pagos.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Volver
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('pagos.update', $pago) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6 mb-3 info-group">
                                <h6 class="chip-title"><i class="fas fa-receipt me-2"></i>Pedido</h6>
                                <label for="pedido_id" class="form-label fw-bold">
                                    
                                </label>
                                <select name="pedido_id" id="pedido_id" class="form-select @error('pedido_id') is-invalid @enderror" required>
                                    <option value="">Seleccionar pedido...</option>
                                    @foreach($pedidos as $pedido)
                                    <option value="{{ $pedido->id }}" {{ (old('pedido_id', $pago->pedido_id) == $pedido->id) ? 'selected' : '' }}>
                                        Pedido #{{ $pedido->numero }} - {{ $pedido->cliente }} - Mesa {{ $pedido->mesa->numero }} (${{ number_format($pedido->total, 2) }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('pedido_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3 info-group">
                                <h6 class="chip-title"><i class="fas fa-dollar-sign me-2"></i>Monto</h6>
                                <label for="monto" class="form-label fw-bold">
                                    
                                </label>
                                <input type="number" step="0.01" name="monto" id="monto" 
                                       class="form-control @error('monto') is-invalid @enderror" 
                                       value="{{ old('monto', $pago->monto) }}" placeholder="0.00" required>
                                @error('monto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3 info-group">
                                <h6 class="chip-title"><i class="fas fa-credit-card me-2"></i>Método de Pago</h6>
                                <label for="metodo" class="form-label fw-bold">
                                    
                                </label>
                                <select name="metodo" id="metodo" class="form-select @error('metodo') is-invalid @enderror" required>
                                    <option value="">Seleccionar método...</option>
                                    <option value="efectivo" {{ (old('metodo', $pago->metodo) == 'efectivo') ? 'selected' : '' }}>Efectivo</option>
                                    <option value="tarjeta" {{ (old('metodo', $pago->metodo) == 'tarjeta') ? 'selected' : '' }}>Tarjeta</option>
                                    <option value="transferencia" {{ (old('metodo', $pago->metodo) == 'transferencia') ? 'selected' : '' }}>Transferencia</option>

                                </select>
                                @error('metodo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3 info-group">
                                <h6 class="chip-title"><i class="fas fa-calendar me-2"></i>Fecha y Hora</h6>
                                <label for="fecha" class="form-label fw-bold">
                                    
                                </label>
                                <input type="datetime-local" name="fecha_pago" id="fecha_pago" 
                                       class="form-control @error('fecha_pago') is-invalid @enderror" 
                                       value="{{ old('fecha_pago', $pago->fecha_pago->format('Y-m-d\TH:i')) }}" required>
                                @error('fecha_pago')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>



                        <div class="d-flex justify-content-end gap-2 mt-4 actions-bar">
                            <a href="{{ route('pagos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-warning text-white">
                                <i class="fas fa-save me-2"></i>Actualizar Pago
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
.pagos-theme {
    --pagos-bg: #0f1117;
    --pagos-panel: #111827;
    --pagos-panel-2: #0b0f1a;
    --pagos-text: #e5e7eb;
    --pagos-muted: #9ca3af;
    --pagos-gold: #f4d03f;
    --pagos-outline: rgba(244, 208, 63, 0.35);
}
.pagos-theme .card { background: linear-gradient(180deg, var(--pagos-panel) 0%, var(--pagos-panel-2) 100%); border-radius: 16px; border: 1px solid rgba(255,255,255,0.04); box-shadow: 0 0 0 1px rgba(255,255,255,0.02) inset, 0 10px 30px rgba(0,0,0,0.35); }
.pagos-theme .card-header { background: linear-gradient(90deg, rgba(244,208,63,0.08), rgba(243,156,18,0.05)); border-bottom: 1px solid var(--pagos-outline); border-top-left-radius: 16px; border-top-right-radius: 16px; padding: 18px 22px; }
.pagos-theme .card-header h4 { color: var(--pagos-text); }
.pagos-theme .opacity-8 { color: var(--pagos-muted) !important; }

/* Inputs/selects modo oscuro */
.pagos-theme .form-control, .pagos-theme .form-select { background: #0b0f1a; border: 1px solid rgba(255,255,255,0.08); color: var(--pagos-text); border-radius: 10px; height: 44px; }
.pagos-theme input[type="datetime-local"].form-control { height: 44px; }
.pagos-theme .form-control:focus, .pagos-theme .form-select:focus { border-color: var(--pagos-gold); box-shadow: 0 0 0 0.2rem rgba(244,208,63,0.15); }
.pagos-theme label { color: var(--pagos-text); }

.chip-title { font-weight:700; font-size:.8rem; letter-spacing:.6px; color: var(--pagos-gold); margin:0 0 6px; display:inline-flex; align-items:center; gap:8px; padding:4px 8px; border:1px solid var(--pagos-outline); border-radius:999px; background: rgba(244,208,63,0.08); }
.info-group label { color: var(--pagos-muted); margin-top: 4px; }

/* Botones negro/blanco con acento dorado */
.pagos-theme .btn { border-radius: 10px; }
.pagos-theme .btn-light, .pagos-theme .btn-secondary, .pagos-theme .btn-warning { background: #0b0f1a !important; color: #ffffff !important; border: 1px solid var(--pagos-outline) !important; }
.pagos-theme .btn-light:hover, .pagos-theme .btn-secondary:hover, .pagos-theme .btn-warning:hover { background: var(--pagos-gold) !important; color: #0b0f1a !important; border-color: var(--pagos-gold) !important; }

.actions-bar { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.06); padding: 14px; border-radius: 12px; }

</style>
@endsection