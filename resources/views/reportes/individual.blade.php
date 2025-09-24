@extends('layouts.admin')

@section('title', $data['titulo'] ?? 'Reporte Individual')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
<style>
.reporte-individual {
    padding: 2rem;
    max-width: 1200px;
    margin: 0 auto;
}

.reporte-header {
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
    text-align: center;
    border: 2px solid var(--color-primary);
}

.reporte-title {
    font-size: 2rem;
    color: #000;
    margin-bottom: 1rem;
}

.btn-descargar {
    background: #000;
    color: #ffd700;
    padding: 1rem 2rem;
    border-radius: 10px;
    text-decoration: none;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin-top: 1rem;
}

.btn-descargar:hover {
    background: #333;
    color: #ffd700;
}

.reporte-content {
    background: var(--bg-glass);
    border: 2px solid var(--color-primary);
    border-radius: 15px;
    padding: 2rem;
    margin-bottom: 2rem;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: rgba(255, 215, 0, 0.1);
    border: 1px solid var(--color-primary);
    border-radius: 10px;
    padding: 1.5rem;
    text-align: center;
}

.stat-number {
    font-size: 2rem;
    font-weight: bold;
    color: var(--color-primary);
}

.stat-label {
    color: var(--text-muted);
    margin-top: 0.5rem;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 1rem;
}

.data-table th,
.data-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid rgba(255, 215, 0, 0.3);
}

.data-table th {
    background: rgba(255, 215, 0, 0.2);
    color: var(--color-primary);
    font-weight: bold;
}

.btn-volver {
    background: var(--color-primary);
    color: #000;
    padding: 0.8rem 1.5rem;
    border-radius: 8px;
    text-decoration: none;
    font-weight: bold;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    margin-bottom: 2rem;
}

.btn-volver:hover {
    background: var(--color-primary-light);
}
</style>
@endpush

@section('content')
<div class="reporte-individual">
    <a href="{{ route('reportes.index') }}" class="btn-volver">
        <i class="fas fa-arrow-left"></i> Volver a Reportes
    </a>

    <div class="reporte-header">
        <h1 class="reporte-title">{{ $data['titulo'] }}</h1>
        <p>Generado el {{ date('d/m/Y H:i:s') }}</p>
        <a href="{{ route('reportes.pdf', $tipo) }}" class="btn-descargar" target="_blank">
            <i class="fas fa-file-pdf"></i> Descargar PDF
        </a>
    </div>

    <div class="reporte-content">
        @if($tipo === 'reservas')
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $data['total_reservas'] ?? 0 }}</div>
                    <div class="stat-label">Total Reservas</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $data['reservas_hoy'] ?? 0 }}</div>
                    <div class="stat-label">Reservas Hoy</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $data['reservas_mes'] ?? 0 }}</div>
                    <div class="stat-label">Reservas Este Mes</div>
                </div>
            </div>

            @if(isset($data['reservas']) && count($data['reservas']) > 0)
                <h3>Lista de Reservas</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Personas</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['reservas'] as $reserva)
                        <tr>
                            <td>{{ $reserva->nombre ?? 'N/A' }}</td>
                            <td>{{ $reserva->fecha ? \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') : 'N/A' }}</td>
                            <td>{{ $reserva->personas ?? 'N/A' }}</td>
                            <td>Confirmada</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        @elseif($tipo === 'pedidos')
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $data['total_pedidos'] ?? 0 }}</div>
                    <div class="stat-label">Total Pedidos</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $data['pedidos_pendientes'] ?? 0 }}</div>
                    <div class="stat-label">Pedidos Pendientes</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $data['pedidos_completados'] ?? 0 }}</div>
                    <div class="stat-label">Pedidos Completados</div>
                </div>
            </div>

            @if(isset($data['pedidos']) && count($data['pedidos']) > 0)
                <h3>Lista de Pedidos</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['pedidos'] as $pedido)
                        <tr>
                            <td>{{ $pedido->id }}</td>
                            <td>{{ $pedido->user->name ?? 'N/A' }}</td>
                            <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                            <td>${{ number_format($pedido->total, 2) }}</td>
                            <td>{{ ucfirst($pedido->estado) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        @elseif($tipo === 'productos')
        @elseif($tipo === 'ventas')
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">${{ number_format($data['total_ventas'] ?? 0, 2) }}</div>
                    <div class="stat-label">Total Ventas</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ count($data['pedidos'] ?? []) }}</div>
                    <div class="stat-label">Total Pedidos</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">${{ number_format($data['promedio_venta'] ?? 0, 2) }}</div>
                    <div class="stat-label">Promedio por Venta</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">${{ number_format($data['ventas_mes'] ?? 0, 2) }}</div>
                    <div class="stat-label">Ventas Este Mes</div>
                </div>
            </div>

            @if(isset($data['pedidos']) && count($data['pedidos']) > 0)
                <h3>Detalle de Ventas</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['pedidos'] as $pedido)
                        <tr>
                            <td>{{ $pedido->id }}</td>
                            <td>{{ $pedido->user->name ?? 'N/A' }}</td>
                            <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                            <td>${{ number_format($pedido->total, 2) }}</td>
                            <td>{{ ucfirst($pedido->estado) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        @elseif($tipo === 'horarios')
            <h3>Actividad por Horas</h3>
            @if(isset($data['pedidos_por_hora']) && count($data['pedidos_por_hora']) > 0)
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Hora</th>
                            <th>Total Pedidos</th>
                            <th>Nivel de Actividad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['pedidos_por_hora'] as $hora)
                        <tr>
                            <td>{{ $hora->hora }}:00</td>
                            <td>{{ $hora->total }}</td>
                            <td>
                                @if($hora->total > 10)
                                    <span style="color: #ff4757;">Alto</span>
                                @elseif($hora->total > 5)
                                    <span style="color: #ffa500;">Medio</span>
                                @else
                                    <span style="color: #51cf66;">Bajo</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p>No hay datos de horarios disponibles.</p>
            @endif

        @elseif($tipo === 'usuarios')
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $data['total_usuarios'] ?? 0 }}</div>
                    <div class="stat-label">Total Usuarios</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $data['usuarios_activos'] ?? 0 }}</div>
                    <div class="stat-label">Usuarios Activos</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $data['usuarios_inactivos'] ?? 0 }}</div>
                    <div class="stat-label">Usuarios Inactivos</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $data['registros_mes'] ?? 0 }}</div>
                    <div class="stat-label">Registros Este Mes</div>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">{{ $data['clientes'] ?? 0 }}</div>
                    <div class="stat-label">Clientes</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $data['empleados'] ?? 0 }}</div>
                    <div class="stat-label">Empleados</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ $data['administradores'] ?? 0 }}</div>
                    <div class="stat-label">Administradores</div>
                </div>
            </div>

            @if(isset($data['usuarios']) && count($data['usuarios']) > 0)
                <h3>Lista de Usuarios</h3>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Email</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Fecha Registro</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['usuarios'] as $usuario)
                        <tr>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>{{ ucfirst($usuario->rol) }}</td>
                            <td>
                                @if($usuario->estado === 'activo')
                                    <span style="color: #51cf66;">Activo</span>
                                @else
                                    <span style="color: #ff4757;">Inactivo</span>
                                @endif
                            </td>
                            <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif

        @elseif($tipo === 'financiero')
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-number">${{ number_format($data['ingresos_totales'] ?? 0, 2) }}</div>
                    <div class="stat-label">Ingresos Totales</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">{{ count($data['pedidos_mes'] ?? []) }}</div>
                    <div class="stat-label">Pedidos Este Mes</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">${{ number_format($data['promedio_mensual'] ?? 0, 2) }}</div>
                    <div class="stat-label">Promedio Mensual</div>
                </div>
                <div class="stat-card">
                    <div class="stat-number">${{ number_format($data['ingresos_diarios'] ?? 0, 2) }}</div>
                    <div class="stat-label">Promedio Diario</div>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection