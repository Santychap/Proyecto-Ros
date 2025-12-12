<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        // Se carga la relación 'categoria' para optimizar consultas
        $productos = Producto::with('categoria')->latest()->get();
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $categorias = Categoria::all();
        return view('productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
            'ingredientes' => 'nullable|string',
            'category_id' => 'required|exists:categorias,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $datos = $request->all();

        if ($request->hasFile('image')) {
            // Guarda la imagen en storage/app/public/productos
            $datos['image'] = $request->file('image')->store('productos', 'public');
        }

        Producto::create($datos);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit(Producto $producto)
    {
        $categorias = Categoria::all();
        return view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'precio' => 'required|numeric',
            'stock' => 'required|integer|min:0',
            'descripcion' => 'nullable|string',
            'ingredientes' => 'nullable|string',
            'category_id' => 'required|exists:categorias,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $datos = $request->all();

        if ($request->hasFile('image')) {
            // Si quieres eliminar la imagen antigua, hazlo aquí antes de guardar la nueva
            $datos['image'] = $request->file('image')->store('productos', 'public');
        }

        $producto->update($datos);

        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Producto $producto)
    {
        // Opcional: elimina la imagen del storage cuando borras el producto
        if ($producto->image) {
            \Storage::disk('public')->delete($producto->image);
        }

        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
