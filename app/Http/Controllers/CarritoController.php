<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class CarritoController extends Controller
{
    // Agregar producto al carrito
    public function agregar(Request $request)
    {
        $producto = Producto::findOrFail($request->producto_id);

        $carrito = session()->get('carrito', []);

        if(isset($carrito[$producto->id])) {
            $carrito[$producto->id]['cantidad']++;
        } else {
            $carrito[$producto->id] = [
                "nombre" => $producto->nombre,
                "precio" => $producto->precio,
                "cantidad" => 1,
            ];
        }

        session()->put('carrito', $carrito);

        return redirect()->route('menu.index')->with('success', 'Producto agregado al carrito');
    }

    // Mostrar carrito
    public function mostrar()
    {
        $carrito = session()->get('carrito', []);
        return view('carrito.mostrar', compact('carrito'));
    }

    // Actualizar cantidades del carrito
    public function actualizar(Request $request)
    {
        if($request->id && $request->cantidad){
            $carrito = session()->get('carrito', []);
            if(isset($carrito[$request->id])){
                $carrito[$request->id]['cantidad'] = $request->cantidad;
                session()->put('carrito', $carrito);
                return redirect()->route('carrito.mostrar')->with('success', 'Carrito actualizado');
            }
        }
        return redirect()->route('carrito.mostrar')->with('error', 'Error al actualizar el carrito');
    }

    // Eliminar producto del carrito
    public function eliminar(Request $request)
    {
        $carrito = session()->get('carrito', []);
        if(isset($carrito[$request->id])){
            unset($carrito[$request->id]);
            session()->put('carrito', $carrito);
        }
        return redirect()->route('carrito.mostrar')->with('success', 'Producto eliminado del carrito');
    }
}
