<?php

namespace App\Http\Controllers;

use App\Models\Inventario;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventario::query();
        
        // Filtros
        if ($request->filled('codigo')) {
            $query->where('codigo', 'like', '%' . $request->codigo . '%');
        }
        
        if ($request->filled('nombre')) {
            $query->where('nombre', 'like', '%' . $request->nombre . '%');
        }
        
        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }
        
        if ($request->filled('estado_stock')) {
            switch ($request->estado_stock) {
                case 'agotado':
                    $query->where('stock_actual', '<=', 0);
                    break;
                case 'bajo_stock':
                    $query->whereRaw('stock_actual <= stock_minimo AND stock_actual > 0');
                    break;
                case 'sobre_stock':
                    $query->whereRaw('stock_actual >= stock_maximo');
                    break;
            }
        }
        
        $productos = $query->where('estado', '!=', 'inactivo')->orderBy('nombre')->paginate(15);
        
        // Estadísticas
        $stats = [
            'total' => Inventario::where('estado', '!=', 'inactivo')->count(),
            'agotados' => Inventario::where('estado', '!=', 'inactivo')->where('stock_actual', '<=', 0)->count(),
            'bajo_stock' => Inventario::where('estado', '!=', 'inactivo')->whereRaw('stock_actual <= stock_minimo AND stock_actual > 0')->count(),
            'sobre_stock' => Inventario::where('estado', '!=', 'inactivo')->whereRaw('stock_actual >= stock_maximo')->count(),
            'por_vencer' => Inventario::where('estado', '!=', 'inactivo')->whereDate('fecha_vencimiento', '<=', now()->addDays(7))->count()
        ];
        
        return view('inventario.index', compact('productos', 'stats'));
    }

    public function create()
    {
        $codigo = Inventario::generarCodigo();
        return view('inventario.create', compact('codigo'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|unique:inventario,codigo',
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria' => 'required|in:proteina,verdura,condimento,lacteo,cereal,bebida,limpieza,otro',
            'unidad_medida' => 'required|string|max:50',
            'stock_inicial' => 'required|numeric|min:0',
            'stock_minimo' => 'required|numeric|min:0',
            'stock_maximo' => 'required|numeric|min:0',
            'precio_unitario' => 'required|numeric|min:0',
            'proveedor' => 'nullable|string|max:255',
            'fecha_vencimiento' => 'nullable|date|after:today',
        ]);

        Inventario::create([
            'codigo' => $request->codigo,
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'categoria' => $request->categoria,
            'unidad_medida' => $request->unidad_medida,
            'stock_inicial' => $request->stock_inicial,
            'stock_actual' => $request->stock_inicial,
            'stock_minimo' => $request->stock_minimo,
            'stock_maximo' => $request->stock_maximo,
            'precio_unitario' => $request->precio_unitario,
            'proveedor' => $request->proveedor,
            'fecha_vencimiento' => $request->fecha_vencimiento,
        ]);

        return redirect()->route('inventario.index')->with('success', 'Producto agregado correctamente.');
    }

    public function show(Inventario $inventario)
    {
        return view('inventario.show', compact('inventario'));
    }

    public function edit(Inventario $inventario)
    {
        return view('inventario.edit', compact('inventario'));
    }

    public function update(Request $request, Inventario $inventario)
    {
        $request->validate([
            'codigo' => 'required|string|unique:inventario,codigo,' . $inventario->id,
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria' => 'required|in:proteina,verdura,condimento,lacteo,cereal,bebida,limpieza,otro',
            'unidad_medida' => 'required|string|max:50',
            'stock_minimo' => 'required|numeric|min:0',
            'stock_maximo' => 'required|numeric|min:0',
            'precio_unitario' => 'required|numeric|min:0',
            'proveedor' => 'nullable|string|max:255',
            'fecha_vencimiento' => 'nullable|date|after:today',
        ]);

        $inventario->update($request->only([
            'codigo', 'nombre', 'descripcion', 'categoria', 'unidad_medida',
            'stock_minimo', 'stock_maximo', 'precio_unitario', 'proveedor', 'fecha_vencimiento'
        ]));

        return redirect()->route('inventario.index')->with('success', 'Producto actualizado correctamente.');
    }

    public function destroy(Inventario $inventario)
    {
        $inventario->update(['estado' => 'inactivo']);
        return redirect()->route('inventario.index')->with('success', 'Producto desactivado.');
    }

    public function ajustarStock(Request $request, Inventario $inventario)
    {
        $request->validate([
            'cantidad' => 'required|numeric|min:0.01',
            'tipo' => 'required|in:entrada,salida,ajuste',
            'motivo' => 'required|string|max:255'
        ]);

        $inventario->registrarMovimiento(
            $request->tipo,
            $request->cantidad,
            $request->motivo
        );

        return redirect()->route('inventario.index')->with('success', 'Stock ajustado correctamente.');
    }
}