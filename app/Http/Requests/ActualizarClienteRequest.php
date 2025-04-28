<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActualizarClienteRequest extends FormRequest
{
    /**
     * Determina si el usuario está autorizado a realizar esta solicitud.
     *
     * @return bool
     */
    public function authorize()
    {
        // Retorna true si quieres que cualquier usuario pueda hacer la solicitud
        return true;
    }

    /**
     * Obtener las reglas de validación que se aplicarán a la solicitud.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'nombres_cliente' => 'required|string|max:255',
            'apellidos_cliente' => 'required|string|max:255',
            'dui_cliente' => 'required|string|max:10',
            'telefono_cliente' => 'required|string|max:15',
            'nit_cliente' => 'required|string|max:20',
            'email_cliente' => 'required|email|max:255',
            'monto_max' => 'required|numeric',
            'barrio' => 'nullable|string|max:255',
            'id_clasificacion' => 'required|exists:clasificaciones,id',
            'id_departamento' => 'required|exists:departamentos,id',
            'id_municipio' => 'required|exists:municipios,id',
        ];
    }
}

