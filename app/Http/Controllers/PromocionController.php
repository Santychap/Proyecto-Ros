<?php

namespace App\Http\Controllers;

use App\Models\Promocion;
use Illuminate\Http\Request;

class PromocionController extends Controller
{
    // Mostrar la lista paginada de promociones para la vista pública
    public function publicIndex()
    {
        $promociones = Promocion::latest()->paginate(10);
        return view('promociones.index', compact('promociones'));
    }

    // Métodos para administración (CRUD)
    public function index()
    {
        $promociones = Promocion::latest()->paginate(10);
        return view('promociones.index', compact('promociones'));
    }

    public function create()
    {
        return view('promociones.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255', // Cambiado de 'nombre' a 'titulo'
            'descripcion' => 'nullable|string',
            'descuento' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
            'imagen' => 'nullable|image|max:2048', // valida que sea imagen y tamaño máximo 2MB
        ]);

        Promocion::create($request->all());

        return redirect()->route('promociones.index')
            ->with('success', 'Promoción creada correctamente.');
    }

    public function edit(Promocion $promocion) // Asegúrate que el parámetro coincida
    {
        return view('promociones.edit', compact('promocion'));
    }

    public function update(Request $request, Promocion $promocion)
    {
        $request->validate([
            'titulo' => 'required|string|max:255', // Cambiado de 'nombre' a 'titulo'
            'descripcion' => 'nullable|string',
            'descuento' => 'required|numeric|min:0',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        $promocion->update($request->all());

        return redirect()->route('promociones.index')
            ->with('success', 'Promoción actualizada correctamente.');
    }

    public function destroy(Promocion $promocion)
    {
        $promocion->delete();
        return redirect()->route('promociones.index')
            ->with('success', 'Promoción eliminada correctamente.');
    }
}
