@extends('layouts.menu')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">
                                <i class="fas fa-credit-card me-2"></i>Registrar Nuevo Pago
                            </h4>
                            <p class="mb-0 opacity-8">Completa la información del pago</p>
                        </div>
                        <a href="{{ route('pagos.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Volver
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('pagos.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pedido_id" class="form-label fw-bold">
                                    <i class="fas fa-receipt me-2 text-primary"></i>Pedido
                                </label>
                                <select name="pedido_id" id="pedido_id" class="form-select @error('pedido_id') is-invalid @enderror" required>
                                    <option value="">Seleccionar pedido...</option>
                                    @foreach($pedidos as $pedido)
                                    <option value="{{ $pedido->id }}" {{ old('pedido_id') == $pedido->id ? 'selected' : '' }}>
                                        Pedido #{{ $pedido->numero }} - {{ $pedido->cliente }} - Mesa {{ $pedido->mesa->numero }} (${{ number_format($pedido->total, 2) }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('pedido_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="monto" class="form-label fw-bold">
                                    <i class="fas fa-dollar-sign me-2 text-success"></i>Monto
                                </label>
                                <input type="number" step="0.01" name="monto" id="monto" 
                                       class="form-control @error('monto') is-invalid @enderror" 
                                       value="{{ old('monto') }}" placeholder="0.00" required>
                                @error('monto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="metodo" class="form-label fw-bold">
                                    <i class="fas fa-credit-card me-2 text-info"></i>Método de Pago
                                </label>
                                <select name="metodo" id="metodo" class="form-select @error('metodo') is-invalid @enderror" required>
                                    <option value="">Seleccionar método...</option>
                                    <option value="efectivo" {{ old('metodo') == 'efectivo' ? 'selected' : '' }}>
                                        <i class="fas fa-money-bill"></i> Efectivo
                                    </option>
                                    <option value="tarjeta" {{ old('metodo') == 'tarjeta' ? 'selected' : '' }}>
                                        <i class="fas fa-credit-card"></i> Tarjeta
                                    </option>
                                    <option value="transferencia" {{ old('metodo') == 'transferencia' ? 'selected' : '' }}>
                                        <i class="fas fa-exchange-alt"></i> Transferencia
                                    </option>

                                </select>
                                @error('metodo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha" class="form-label fw-bold">
                                    <i class="fas fa-calendar me-2 text-warning"></i>Fecha y Hora
                                </label>
                                <input type="datetime-local" name="fecha_pago" id="fecha_pago" 
                                       class="form-control @error('fecha_pago') is-invalid @enderror" 
                                       value="{{ old('fecha_pago', now()->format('Y-m-d\TH:i')) }}" required>
                                @error('fecha_pago')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">

                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('pagos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Registrar Pago
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('pedido_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    if (selectedOption.value) {
        const text = selectedOption.text;
        const match = text.match(/\$([0-9,]+\.?[0-9]*)\)/);
        if (match) {
            document.getElementById('monto').value = match[1].replace(',', '');
        }
    }
});
</script>
@endsection