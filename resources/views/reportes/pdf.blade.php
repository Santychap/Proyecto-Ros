<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $data['titulo'] ?? 'Reporte' }} - Olla y Sazón</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #ffd700;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .logo {
            font-size: 24px;
            font-weight: bold;
            color: #ffd700;
            margin-bottom: 10px;
        }
        .title {
            font-size: 20px;
            color: #333;
            margin: 10px 0;
        }
        .date {
            color: #666;
            font-size: 12px;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #ffd700;
            border-bottom: 1px solid #ffd700;
            padding-bottom: 5px;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #ffd700;
            color: #000;
            font-weight: bold;
        }
        .summary-box {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            padding: 15px;
            margin-bottom: 20px;
        }
        .summary-item {
            display: inline-block;
            width: 48%;
            margin-bottom: 10px;
        }
        .total {
            font-size: 18px;
            font-weight: bold;
            color: #ffd700;
            text-align: right;
            margin-top: 20px;
        }
        .footer {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            text-align: center;
            font-size: 10px;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">🍲 Olla y Sazón</div>
        <div class="title">{{ $data['titulo'] ?? 'Reporte' }}</div>
        @if(isset($data['fecha']))
            <div class="date">Fecha: {{ $data['fecha'] }}</div>
        @elseif(isset($data['periodo']))
            <div class="date">Período: {{ $data['periodo'] }}</div>
        @endif
        <div class="date">Generado el: {{ date('d/m/Y H:i:s') }}</div>
    </div>

    @if($tipo === 'general')
        <div class="section">
            <div class="section-title">Resumen General - Todos los Módulos</div>
            <div class="summary-box">
                <div class="summary-item"><strong>Total de Pedidos:</strong> {{ $data['pedidos_total'] ?? 0 }}</div>
                <div class="summary-item"><strong>Total de Clientes:</strong> {{ $data['clientes_total'] ?? 0 }}</div>
                <div class="summary-item"><strong>Total de Empleados:</strong> {{ $data['empleados_total'] ?? 0 }}</div>
                <div class="summary-item"><strong>Total de Productos:</strong> {{ $data['productos_total'] ?? 0 }}</div>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">Módulo de Reservas</div>
            <div class="summary-box">
                <div class="summary-item"><strong>Total de Reservas:</strong> {{ $data['reservas_total'] ?? 0 }}</div>
                <div class="summary-item"><strong>Reservas Hoy:</strong> {{ $data['reservas_hoy'] ?? 0 }}</div>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">Módulo de Mesas</div>
            <div class="summary-box">
                <div class="summary-item"><strong>Total de Mesas:</strong> {{ $data['mesas_total'] ?? 0 }}</div>
                <div class="summary-item"><strong>Mesas Disponibles:</strong> {{ $data['mesas_disponibles'] ?? 0 }}</div>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">Módulo de Pedidos</div>
            <div class="summary-box">
                <div class="summary-item"><strong>Pedidos Pendientes:</strong> {{ $data['pedidos_pendientes'] ?? 0 }}</div>
                <div class="summary-item"><strong>Pedidos Completados:</strong> {{ $data['pedidos_completados'] ?? 0 }}</div>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">Módulo de Productos</div>
            <div class="summary-box">
                <div class="summary-item"><strong>Total de Categorías:</strong> {{ $data['categorias_total'] ?? 0 }}</div>
                <div class="summary-item"><strong>Ingresos Totales:</strong> ${{ number_format($data['ingresos_total'] ?? 0, 2) }}</div>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">Módulo de Usuarios</div>
            <div class="summary-box">
                <div class="summary-item"><strong>Total de Clientes:</strong> {{ $data['clientes_total'] ?? 0 }}</div>
                <div class="summary-item"><strong>Total de Empleados:</strong> {{ $data['empleados_total'] ?? 0 }}</div>
            </div>
        </div>
    @else
        <div class="section">
            <div class="section-title">Resumen General del Período</div>
            <div class="summary-box">
                <div class="summary-item"><strong>Total de Pedidos:</strong> {{ $data['pedidos_total'] ?? 0 }}</div>
                <div class="summary-item"><strong>Ingresos del Período:</strong> ${{ number_format($data['total_ingresos'] ?? 0, 2) }}</div>
                <div class="summary-item"><strong>Total de Clientes:</strong> {{ $data['clientes_total'] ?? 0 }}</div>
                <div class="summary-item"><strong>Total de Empleados:</strong> {{ $data['empleados_total'] ?? 0 }}</div>
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">Módulo de Reservas - {{ $data['titulo'] }}</div>
            <div class="summary-box">
                @if($tipo === 'diario')
                    <div class="summary-item"><strong>Reservas Hoy:</strong> {{ $data['reservas_hoy'] ?? 0 }}</div>
                @elseif($tipo === 'semanal')
                    <div class="summary-item"><strong>Reservas Esta Semana:</strong> {{ $data['reservas_semana'] ?? 0 }}</div>
                @elseif($tipo === 'mensual')
                    <div class="summary-item"><strong>Reservas Este Mes:</strong> {{ $data['reservas_mes'] ?? 0 }}</div>
                @endif
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">Módulo de Usuarios - {{ $data['titulo'] }}</div>
            <div class="summary-box">
                @if($tipo === 'diario')
                    <div class="summary-item"><strong>Usuarios Registrados Hoy:</strong> {{ $data['usuarios_registrados_hoy'] ?? 0 }}</div>
                @elseif($tipo === 'semanal')
                    <div class="summary-item"><strong>Usuarios Registrados Esta Semana:</strong> {{ $data['usuarios_registrados_semana'] ?? 0 }}</div>
                @elseif($tipo === 'mensual')
                    <div class="summary-item"><strong>Usuarios Registrados Este Mes:</strong> {{ $data['usuarios_registrados_mes'] ?? 0 }}</div>
                @endif
            </div>
        </div>
        
        <div class="section">
            <div class="section-title">Módulo de Productos y Mesas</div>
            <div class="summary-box">
                <div class="summary-item"><strong>Total de Productos:</strong> {{ $data['productos_total'] ?? 0 }}</div>
                <div class="summary-item"><strong>Total de Categorías:</strong> {{ $data['categorias_total'] ?? 0 }}</div>
                <div class="summary-item"><strong>Total de Mesas:</strong> {{ $data['mesas_total'] ?? 0 }}</div>
            </div>
        </div>

        @if(isset($data['pedidos']) && count($data['pedidos']) > 0)
            <div class="section">
                <div class="section-title">Detalle de Pedidos del Período</div>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Cliente</th>
                            <th>Fecha</th>
                            <th>Estado</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['pedidos'] as $pedido)
                            <tr>
                                <td>{{ $pedido->id }}</td>
                                <td>{{ $pedido->user->name ?? 'N/A' }}</td>
                                <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                                <td>{{ ucfirst($pedido->estado) }}</td>
                                <td>${{ number_format($pedido->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    @endif

    <div class="total">
        Total General: ${{ number_format($data['total_ingresos'] ?? $data['ingresos_total'] ?? 0, 2) }}
    </div>

    <div class="footer">
        Restaurante Olla y Sazón - Reporte generado automáticamente
    </div>
</body>
</html>