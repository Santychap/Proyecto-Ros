<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PedidoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'productos' => 'required|array|min:1',
            'productos.*.id' => 'required|exists:productos,id',
            'productos.*.cantidad' => 'required|integer|min:1|max:10',
            'comentario' => 'nullable|string|max:500',
        ];
    }

    public function messages()
    {
        return [
            'productos.required' => 'Debe seleccionar al menos un producto',
            'productos.*.cantidad.max' => 'La cantidad máxima por producto es 10',
            'comentario.max' => 'El comentario no puede exceder 500 caracteres',
        ];
    }
}