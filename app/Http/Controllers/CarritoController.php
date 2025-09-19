<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

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
    
    // Método para mostrar la página principal del carrito
    public function index()
    {
        return $this->mostrar();
    }

    // Actualizar cantidades del carrito
    public function actualizar(Request $request)
    {
        if($request->id && $request->cantidad){
            $carrito = session()->get('carrito', []);
            if(isset($carrito[$request->id])){
                $carrito[$request->id]['cantidad'] = $request->cantidad;
                session()->put('carrito', $carrito);
                
                if($request->ajax()) {
                    return response()->json(['success' => true, 'message' => 'Carrito actualizado']);
                }
                return redirect()->route('carrito.mostrar')->with('success', 'Carrito actualizado');
            }
        }
        
        if($request->ajax()) {
            return response()->json(['success' => false, 'message' => 'Error al actualizar el carrito']);
        }
        return redirect()->route('carrito.mostrar')->with('error', 'Error al actualizar el carrito');
    }

    // Eliminar producto del carrito
    public function eliminar(Request $request)
    {
        try {
            $carrito = session()->get('carrito', []);
            
            if ($request->clear_all) {
                session()->forget('carrito');
                return response()->json(['success' => true, 'message' => 'Carrito vaciado']);
            }
            
            if (isset($carrito[$request->id])) {
                unset($carrito[$request->id]);
                session()->put('carrito', $carrito);
                return response()->json(['success' => true, 'message' => 'Producto eliminado']);
            }
            
            return response()->json(['success' => false, 'message' => 'Producto no encontrado']);
            
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
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
}
