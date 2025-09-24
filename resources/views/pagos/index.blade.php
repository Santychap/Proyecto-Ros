{{-- Debug: Rol actual = {{ auth()->user()->rol ?? 'NO_ROL' }} --}}
@if(in_array(auth()->user()->rol, ['admin', 'administrador', 'Admin', 'ADMIN']))
    @extends('layouts.admin')
@elseif(in_array(auth()->user()->rol, ['empleado', 'Empleado', 'EMPLEADO']))
    @extends('layouts.empleado')
@else
    @extends('layouts.cliente')
@endif

@push('styles')
@if(auth()->user()->rol === 'admin')
<link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
@endif
@endpush

@section('content')
<div class="dashboard-main" style="padding: 30px; width: 100%;">
    <!-- Header -->
    <div style="margin-bottom: 30px;">
        <h1 class="title-primary" style="display: flex; align-items: center; gap: 15px; margin-bottom: 10px;">
            <i class="fas fa-credit-card"></i>
            @if(auth()->user()->rol === 'admin')
                Gestión de Pagos
            @elseif(auth()->user()->rol === 'empleado')
                Pagos de Mis Pedidos
            @else
                Mis Pagos
            @endif
        </h1>
        <p style="color: #cccccc; font-size: 1.1rem; margin: 0;">
            @if(auth()->user()->rol === 'admin')
                Administra todos los pagos del sistema
            @elseif(auth()->user()->rol === 'empleado')
                Pagos de los pedidos asignados a ti
            @else
                Historial de tus pagos realizados
            @endif
        </p>
    </div>

    @if(session('success'))
        <div style="background: rgba(76, 175, 80, 0.2); border: 1px solid #4caf50; color: #4caf50; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-check-circle"></i>{{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: rgba(244, 67, 54, 0.2); border: 1px solid #f44336; color: #f44336; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-exclamation-circle"></i>{{ session('error') }}
        </div>
    @endif

    @if($pagos->count() > 0)
        <!-- Filtros -->
        @if(auth()->user()->rol === 'admin')
            <div class="chart-container" style="margin-bottom: 30px;">
                <form method="GET" style="display: flex; flex-wrap: wrap; gap: 20px; align-items: end;">
                    <div>
                        <label style="display: block; color: #ffd700; font-weight: 600; margin-bottom: 5px; font-size: 0.9rem;">Estado</label>
                        <select name="estado" style="background: #181828; color: #ffd700; border: 1px solid #ffd700; padding: 8px 12px; border-radius: 6px; font-size: 0.9rem;">
                            <option value="">Todos</option>
                            <option value="pendiente" {{ request('estado') === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="pagado" {{ request('estado') === 'pagado' ? 'selected' : '' }}>Pagado</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; color: #ffd700; font-weight: 600; margin-bottom: 5px; font-size: 0.9rem;">Método</label>
                        <select name="metodo" style="background: #181828; color: #ffd700; border: 1px solid #ffd700; padding: 8px 12px; border-radius: 6px; font-size: 0.9rem;">
                            <option value="">Todos</option>
                            <option value="efectivo" {{ request('metodo') === 'efectivo' ? 'selected' : '' }}>Efectivo</option>
                            <option value="pse" {{ request('metodo') === 'pse' ? 'selected' : '' }}>PSE</option>
                            <option value="nequi" {{ request('metodo') === 'nequi' ? 'selected' : '' }}>Nequi</option>
                            <option value="daviplata" {{ request('metodo') === 'daviplata' ? 'selected' : '' }}>Daviplata</option>
                            <option value="bancolombia" {{ request('metodo') === 'bancolombia' ? 'selected' : '' }}>Bancolombia</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-filter"></i>Filtrar
                    </button>
                    <a href="{{ route('pagos.index') }}" class="btn" style="background: #666; color: #fff;">
                        <i class="fas fa-times"></i>Limpiar
                    </a>
                </form>
            </div>
        @endif

        <!-- Lista de pagos -->
        <div class="chart-container">
            <div class="chart-header" style="margin-bottom: 20px;">
                <h3 class="chart-title">Lista de Pagos</h3>
            </div>
            <div style="overflow-x: auto;">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Pedido</th>
                            <th>Cliente</th>
                            <th>Monto</th>
                            <th>Método</th>
                            <th>Estado</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pagos as $pago)
                            <tr>
                                <td>
                                    <span style="font-weight: 600; color: #ffd700;">
                                        #{{ $pago->pedido->numero ?? $pago->pedido->id }}
                                    </span>
                                </td>
                                <td>{{ $pago->pedido->user->name }}</td>
                                <td>
                                    <span style="font-weight: 600; color: #4caf50;">
                                        ${{ number_format($pago->monto, 2) }}
                                    </span>
                                </td>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 8px;">
                                        @if($pago->metodo === 'efectivo')
                                            <i class="fas fa-money-bill-wave" style="color: #4caf50;"></i>
                                        @elseif($pago->metodo === 'pse')
                                            <i class="fas fa-university" style="color: #2196f3;"></i>
                                        @elseif($pago->metodo === 'nequi')
                                            <i class="fas fa-mobile-alt" style="color: #9c27b0;"></i>
                                        @elseif($pago->metodo === 'daviplata')
                                            <i class="fas fa-wallet" style="color: #f44336;"></i>
                                        @elseif($pago->metodo === 'bancolombia')
                                            <i class="fas fa-building" style="color: #ffd700;"></i>
                                        @endif
                                        <span>{{ ucfirst($pago->metodo) }}</span>
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge @if($pago->estado === 'pagado') status-confirmed @else" style="background: rgba(255, 193, 7, 0.2); color: #ffc107;" @endif">
                                        {{ ucfirst($pago->estado) }}
                                    </span>
                                </td>
                                <td>{{ $pago->fecha_pago->format('d/m/Y H:i') }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <a href="{{ route('pagos.show', $pago) }}" class="btn-action btn-edit" title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        
                                        @if(in_array(auth()->user()->rol, ['admin', 'empleado']) && $pago->metodo === 'efectivo')
                                            <form action="{{ route('pagos.cambiarEstado', $pago) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('PUT')
                                                @if($pago->estado === 'pendiente')
                                                    <input type="hidden" name="estado" value="pagado">
                                                    <button type="submit" class="btn-action" style="background: rgba(76, 175, 80, 0.2); color: #4caf50;" title="Marcar como pagado">
                                                        <i class="fas fa-check-circle"></i>
                                                    </button>
                                                @else
                                                    <input type="hidden" name="estado" value="pendiente">
                                                    <button type="submit" class="btn-action" style="background: rgba(255, 193, 7, 0.2); color: #ffc107;" title="Marcar como pendiente">
                                                        <i class="fas fa-clock"></i>
                                                    </button>
                                                @endif
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Paginación -->
        <div style="margin-top: 30px; display: flex; justify-content: center;">
            {{ $pagos->links() }}
        </div>
    @else
        <!-- Estado vacío -->
        <div class="chart-container" style="text-align: center; padding: 60px 40px;">
            <div class="empty-state">
                <i class="fas fa-credit-card"></i>
                <h3>No hay pagos registrados</h3>
                <p style="margin-bottom: 30px;">
                    @if(auth()->user()->rol === 'cliente')
                        Cuando realices tu primer pago, aparecerá aquí
                    @else
                        No hay pagos que mostrar con los filtros actuales
                    @endif
                </p>
                @if(auth()->user()->rol === 'cliente')
                    <a href="{{ route('menu.index') }}" class="btn btn-primary">
                        <i class="fas fa-utensils"></i>Explorar Menú
                    </a>
                @endif
            </div>
        </div>
    @endif

    <!-- Navegación -->
    <div style="display: flex; justify-content: center; margin-top: 40px; gap: 20px;">
        @if(auth()->user()->rol === 'cliente')
            <a href="{{ route('pedidos.index') }}" class="btn" style="background: #666; color: #fff;">
                <i class="fas fa-list"></i>Mis Pedidos
            </a>
            <a href="{{ route('menu.index') }}" class="btn" style="background: #4caf50; color: #fff;">
                <i class="fas fa-utensils"></i>Volver al Menú
            </a>
        @else
            <a href="{{ route('dashboard') }}" class="btn" style="background: #666; color: #fff;">
                <i class="fas fa-tachometer-alt"></i>Dashboard
            </a>
            <a href="{{ route('pedidos.index') }}" class="btn btn-primary">
                <i class="fas fa-list"></i>Pedidos
            </a>
        @endif
    </div>
</div>
@endsection