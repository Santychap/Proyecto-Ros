<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function estadisticas()
    {
        // Aquí puedes pasar datos a la vista o solo retornar la vista del dashboard/admin
        return view('reportes.estadisticas'); // crea esta vista luego
    }
}
