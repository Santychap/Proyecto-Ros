<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function welcome()
    {
        // Aquí puedes pasar datos dinámicos luego
        return view('welcome');
    }
}
