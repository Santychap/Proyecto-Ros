<?php

namespace App\Http\Controllers;

use App\Models\Producto;

class MenuController extends Controller
{
    public function index()
    {
        // Temporalmente comentado hasta crear las tablas
        $productos = collect(); // Producto::with('categoria')->get();
        $categorias = collect(); // \App\Models\Categoria::all();
        return view('menu.index', compact('productos', 'categorias'));
    }
}
