<?php

namespace App\Http\Controllers;

use App\Models\Producto;

class MenuController extends Controller
{
    public function index()
    {
        $productos = Producto::with('categoria')->where('stock', '>', 0)->get();
        return view('menu.index', compact('productos'));
    }
}
