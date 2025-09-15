<?php

namespace App\Http\Controllers;

use App\Models\Producto;

class MenuController extends Controller
{
    public function index()
    {
        $productos = Producto::all();
        return view('menu.index', compact('productos'));
    }
}
