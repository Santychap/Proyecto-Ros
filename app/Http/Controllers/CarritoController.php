<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\User;

class CarritoController extends Controller
{
    // Agregar producto al carrito
    public function agregar(Request $request)
    {
        try {
            $producto = Producto::find($request->producto_id);
            
            if (!$producto) {
                return response()->json(['success' => false, 'message' => 'Producto no encontrado']);
            }
            
            $carrito = session()->get('carrito', []);
            
            if (isset($carrito[$producto->id])) {
                $carrito[$producto->id]['cantidad']++;
            } else {
                $carrito[$producto->id] = [
                    'nombre' => $producto->nombre,
                    'precio' => $producto->precio,
                    'cantidad' => 1
                ];
            }
            
            session()->put('carrito', $carrito);
            
            return response()->json([
                'success' => true,
                'message' => 'Producto agregado',
                'cartCount' => count($carrito)
            ]);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Mostrar carrito
    public function mostrar()
    {
        $carrito = session()->get('carrito', []);
        $total = 0;
        
        foreach($carrito as $item) {
            $total += $item['precio'] * $item['cantidad'];
        }
        
        return view('carrito.index', compact('carrito', 'total'));
    }

    // Vaciar carrito completo
    public function vaciar()
    {
        session()->forget('carrito');
        return redirect()->route('carrito.mostrar')->with('success', 'Carrito vaciado correctamente');
    }
    
    // Método para mostrar la página principal del carrito
    public function index()
    {
        return $this->mostrar();
    }

    // Actualizar cantidades del carrito
    public function actualizar(Request $request)
    {
        try {
            $carrito = session()->get('carrito', []);
            
            if ($request->id && $request->cantidad && isset($carrito[$request->id])) {
                $carrito[$request->id]['cantidad'] = max(1, (int)$request->cantidad);
                session()->put('carrito', $carrito);
                
                if ($request->ajax() || $request->expectsJson()) {
                    return response()->json([
                        'success' => true, 
                        'message' => 'Carrito actualizado',
                        'cartCount' => count($carrito)
                    ]);
                }
                return redirect()->route('carrito.mostrar')->with('success', 'Carrito actualizado');
            }
            
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Error al actualizar el carrito']);
            }
            return redirect()->route('carrito.mostrar')->with('error', 'Error al actualizar el carrito');
            
        } catch (\Exception $e) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
            return redirect()->route('carrito.mostrar')->with('error', 'Error al actualizar el carrito');
        }
    }

    // Eliminar producto del carrito
    public function eliminar(Request $request)
    {
        try {
            $carrito = session()->get('carrito', []);
            
            if ($request->clear_all) {
                session()->forget('carrito');
                if ($request->ajax() || $request->expectsJson()) {
                    return response()->json(['success' => true, 'message' => 'Carrito vaciado']);
                }
                return redirect()->route('carrito.mostrar')->with('success', 'Carrito vaciado');
            }
            
            if (isset($carrito[$request->id])) {
                unset($carrito[$request->id]);
                session()->put('carrito', $carrito);
                
                if ($request->ajax() || $request->expectsJson()) {
                    return response()->json([
                        'success' => true, 
                        'message' => 'Producto eliminado',
                        'cartCount' => count($carrito)
                    ]);
                }
                return redirect()->route('carrito.mostrar')->with('success', 'Producto eliminado');
            }
            
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Producto no encontrado']);
            }
            return redirect()->route('carrito.mostrar')->with('error', 'Producto no encontrado');
            
        } catch (\Exception $e) {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()]);
            }
            return redirect()->route('carrito.mostrar')->with('error', 'Error al eliminar producto');
        }
    }
    
    // Obtener contador del carrito
    public function count()
    {
        $carrito = session()->get('carrito', []);
        return response()->json([
            'count' => count($carrito)
        ]);
    }

    // Confirmar pedido
    public function confirmarPedido(Request $request)
    {
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para realizar un pedido');
        }

        $carrito = session()->get('carrito', []);
        
        if (empty($carrito)) {
            return redirect()->route('carrito.mostrar')->with('error', 'Tu carrito está vacío');
        }

        return redirect()->route('pedidos.store');
    }
}
