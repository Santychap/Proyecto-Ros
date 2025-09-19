<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    public function index()
    {
        $pagos = Pago::with('pedido.user')->latest()->paginate(10);
        return view('pagos.index', compact('pagos'));
    }

    public function create()
    {
        $pedidos = Pedido::with('user')->get();
        return view('pagos.create', compact('pedidos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pedido_id' => 'required|exists:pedidos,id',
            'monto' => 'required|numeric|min:0',
            'metodo' => 'required|in:efectivo,tarjeta,transferencia',
            'fecha_pago' => 'required|date'
        ]);

        $data = $request->all();
        $data['user_id'] = auth()->id();
        
        Pago::create($data);

        return redirect()->route('pagos.index')->with('success', 'Pago registrado exitosamente');
    }

    public function show(Pago $pago)
    {
        return view('pagos.show', compact('pago'));
    }

    public function edit(Pago $pago)
    {
        $pedidos = Pedido::all();
        return view('pagos.edit', compact('pago', 'pedidos'));
    }

    public function update(Request $request, Pago $pago)
    {
        $request->validate([
            'pedido_id' => 'required|exists:pedidos,id',
            'monto' => 'required|numeric|min:0',
            'metodo' => 'required|in:efectivo,tarjeta,transferencia',
            'fecha_pago' => 'required|date'
        ]);

        $pago->update($request->all());

        return redirect()->route('pagos.index')->with('success', 'Pago actualizado exitosamente');
    }

    public function destroy(Pago $pago)
    {
        $pago->delete();
        return redirect()->route('pagos.index')->with('success', 'Pago eliminado exitosamente');
    }
}