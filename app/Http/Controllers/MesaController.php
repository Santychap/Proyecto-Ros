<?php

namespace App\Http\Controllers;

use App\Models\Mesa;
use Illuminate\Http\Request;

class MesaController extends Controller
{
    //public function __construct()
   // {
    //    $this->middleware(['auth', 'rol:admin']);
    //}

    public function index(Request $request)
    {
        $search = $request->input('search');

        $mesas = Mesa::query()
            ->when($search, function ($query, $search) {
                $query->where('codigo', 'like', "%{$search}%")
                      ->orWhere('capacidad', 'like', "%{$search}%");
            })
            ->orderBy('codigo')
            ->paginate(10);

        return view('mesas.index', compact('mesas'));
    }

    public function create()
    {
        return view('mesas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'codigo' => 'required|string|max:10|unique:mesas,codigo',
            'capacidad' => 'required|integer|min:1',
        ]);

        Mesa::create($data);

        return redirect()->route('mesas.index')->with('success', 'Mesa creada correctamente.');
    }

    public function edit(Mesa $mesa)
    {
        return view('mesas.edit', compact('mesa'));
    }

    public function update(Request $request, Mesa $mesa)
    {
        $data = $request->validate([
            'codigo' => 'required|string|max:10|unique:mesas,codigo,' . $mesa->id,
            'capacidad' => 'required|integer|min:1',
        ]);

        $mesa->update($data);

        return redirect()->route('mesas.index')->with('success', 'Mesa actualizada correctamente.');
    }

    public function destroy(Mesa $mesa)
    {
        $mesa->delete();

        return redirect()->route('mesas.index')->with('success', 'Mesa eliminada correctamente.');
    }
}
