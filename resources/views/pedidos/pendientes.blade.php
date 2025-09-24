@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden mb-6">
            <div class="bg-yellow-600 text-white p-6">
                <h1 class="text-2xl font-bold flex items-center">
                    <i class="fas fa-clock mr-3"></i>
                    Pedidos Pendientes de Pago
                </h1>
                <p class="text-yellow-100 mt-2">Pedidos que requieren confirmación de pago</p>
            </div>
        </div>

        @if($pedidosPendientes->count() > 0)
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#Pedido</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado Pago</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($pedidosPendientes as $pedido)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $pedido->numero }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $pedido->user->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $pedido->created_at->format('d/m/Y H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-green-600">${{ number_format($pedido->total, 2) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        @if($pedido->pago)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                @if($pedido->pago->estado === 'pendiente') bg-yellow-100 text-yellow-800
                                                @else bg-green-100 text-green-800 @endif">
                                                {{ ucfirst($pedido->pago->estado) }}
                                            </span>
                                        @else
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                                Sin pago
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            @if($pedido->pago && $pedido->pago->metodo === 'efectivo' && $pedido->pago->estado === 'pendiente')
                                                <a href="{{ route('pagos.show', $pedido->pago) }}" 
                                                   class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded text-xs transition duration-200">
                                                    <i class="fas fa-eye mr-1"></i>Ver Pago
                                                </a>
                                            @elseif(!$pedido->pago)
                                                <span class="text-gray-500 text-xs">Cliente debe pagar</span>
                                            @else
                                                <span class="text-green-600 text-xs">
                                                    <i class="fas fa-check mr-1"></i>Pagado
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @else
            <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                <i class="fas fa-check-circle text-6xl text-green-500 mb-4"></i>
                <h2 class="text-2xl font-semibold text-gray-800 mb-2">¡Excelente!</h2>
                <p class="text-gray-600">No hay pedidos pendientes de pago en este momento.</p>
            </div>
        @endif

        <!-- Botón volver -->
        <div class="mt-6 text-center">
            <a href="{{ route('pedidos.index') }}" 
               class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-3 px-6 rounded-lg transition duration-200">
                <i class="fas fa-arrow-left mr-2"></i>Volver a Pedidos
            </a>
        </div>
    </div>
</div>
@endsection