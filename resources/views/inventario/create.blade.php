@extends('layouts.admin')

@section('title', 'Agregar Ingrediente - Inventario')

@section('content')
<div class="inventario-container">
    <div class="inventario-header">
        <h1 class="inventario-title">
            <i class="fas fa-plus"></i>
            Agregar Ingrediente al Inventario
        </h1>
        <p class="inventario-subtitle" style="color: #000000 !important;">
            Registra un nuevo ingrediente o insumo
        </p>
    </div>

    <div class="form-container">
        <form action="{{ route('inventario.store') }}" method="POST" class="inventario-form">
            @csrf
            
            <div class="form-grid">
                <div class="form-group">
                    <label for="codigo">Código</label>
                    <input type="text" id="codigo" name="codigo" value="{{ $codigo }}" readonly>
                </div>
                
                <div class="form-group">
                    <label for="nombre">Nombre del Ingrediente</label>
                    <input type="text" id="nombre" name="nombre" value="{{ old('nombre') }}" required>
                    @error('nombre')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="categoria">Categoría</label>
                    <select id="categoria" name="categoria" required>
                        <option value="">Seleccionar categoría</option>
                        <option value="proteina" {{ old('categoria') == 'proteina' ? 'selected' : '' }}>Proteína</option>
                        <option value="verdura" {{ old('categoria') == 'verdura' ? 'selected' : '' }}>Verdura</option>
                        <option value="condimento" {{ old('categoria') == 'condimento' ? 'selected' : '' }}>Condimento</option>
                        <option value="lacteo" {{ old('categoria') == 'lacteo' ? 'selected' : '' }}>Lácteo</option>
                        <option value="cereal" {{ old('categoria') == 'cereal' ? 'selected' : '' }}>Cereal</option>
                        <option value="bebida" {{ old('categoria') == 'bebida' ? 'selected' : '' }}>Bebida</option>
                        <option value="limpieza" {{ old('categoria') == 'limpieza' ? 'selected' : '' }}>Limpieza</option>
                        <option value="otro" {{ old('categoria') == 'otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                    @error('categoria')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="unidad_medida">Unidad de Medida</label>
                    <select id="unidad_medida" name="unidad_medida" required>
                        <option value="">Seleccionar unidad</option>
                        <option value="kg" {{ old('unidad_medida') == 'kg' ? 'selected' : '' }}>Kilogramos (kg)</option>
                        <option value="g" {{ old('unidad_medida') == 'g' ? 'selected' : '' }}>Gramos (g)</option>
                        <option value="litros" {{ old('unidad_medida') == 'litros' ? 'selected' : '' }}>Litros</option>
                        <option value="ml" {{ old('unidad_medida') == 'ml' ? 'selected' : '' }}>Mililitros (ml)</option>
                        <option value="unidades" {{ old('unidad_medida') == 'unidades' ? 'selected' : '' }}>Unidades</option>
                        <option value="cajas" {{ old('unidad_medida') == 'cajas' ? 'selected' : '' }}>Cajas</option>
                    </select>
                    @error('unidad_medida')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="stock_inicial">Stock Inicial</label>
                    <input type="number" id="stock_inicial" name="stock_inicial" step="0.01" min="0" value="{{ old('stock_inicial') }}" required>
                    @error('stock_inicial')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="stock_minimo">Stock Mínimo</label>
                    <input type="number" id="stock_minimo" name="stock_minimo" step="0.01" min="0" value="{{ old('stock_minimo') }}" required>
                    @error('stock_minimo')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="stock_maximo">Stock Máximo</label>
                    <input type="number" id="stock_maximo" name="stock_maximo" step="0.01" min="0" value="{{ old('stock_maximo') }}" required>
                    @error('stock_maximo')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="precio_unitario">Precio Unitario</label>
                    <input type="number" id="precio_unitario" name="precio_unitario" step="0.01" min="0" value="{{ old('precio_unitario') }}" required>
                    @error('precio_unitario')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="proveedor">Proveedor</label>
                    <input type="text" id="proveedor" name="proveedor" value="{{ old('proveedor') }}">
                    @error('proveedor')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="fecha_vencimiento">Fecha de Vencimiento</label>
                    <input type="date" id="fecha_vencimiento" name="fecha_vencimiento" value="{{ old('fecha_vencimiento') }}">
                    @error('fecha_vencimiento')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            
            <div class="form-group full-width">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                @error('descripcion')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="form-actions">
                <a href="{{ route('inventario.index') }}" class="btn-cancel">
                    <i class="fas fa-times"></i> Cancelar
                </a>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save"></i> Guardar Ingrediente
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.inventario-container {
    max-width: 1000px;
    margin: 0 auto;
    padding: 2rem;
}

.inventario-header {
    text-align: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    border-radius: 20px;
    border: 2px solid var(--color-primary);
}

.inventario-title {
    font-size: 2.5rem;
    color: #000000 !important;
    margin-bottom: 0.5rem;
    font-weight: bold;
    text-shadow: 1px 1px 2px rgba(255,255,255,0.3);
}

.inventario-title i {
    color: #000000 !important;
}

.inventario-subtitle {
    font-size: 1.1rem;
    color: #000000 !important;
    font-weight: 600;
    text-shadow: 1px 1px 2px rgba(255,255,255,0.3);
}

.form-container {
    background: #000000 !important;
    border: 3px solid #ffd700 !important;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
}

.form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group.full-width {
    grid-column: 1 / -1;
}

.form-group label {
    color: #ffffff !important;
    font-weight: 600;
    margin-bottom: 0.5rem;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 0.75rem;
    border: 2px solid #ffd700;
    border-radius: 8px;
    background: #1a1a1a !important;
    color: #ffffff !important;
    font-weight: 600;
    font-size: 1rem;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #ffed4e;
    box-shadow: 0 0 10px rgba(255, 215, 0, 0.3);
}

.form-group input[readonly] {
    background: #333333 !important;
    color: #cccccc !important;
}

.error {
    color: #ff4757;
    font-size: 0.9rem;
    margin-top: 0.25rem;
    font-weight: 600;
}

.form-actions {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-top: 2rem;
}

.btn-cancel, .btn-submit {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 2rem;
    border: none;
    border-radius: 15px;
    font-weight: 600;
    font-size: 1.1rem;
    cursor: pointer;
    text-decoration: none;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.btn-cancel {
    background: #6c757d;
    color: #ffffff;
}

.btn-cancel:hover {
    background: #5a6268;
    transform: translateY(-2px);
}

.btn-submit {
    background: var(--color-primary);
    color: #000000;
}

.btn-submit:hover {
    background: #ffed4e;
    transform: translateY(-2px);
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .inventario-container {
        padding: 1rem;
    }
    
    .inventario-title {
        font-size: 2rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
}
</style>
@endpush