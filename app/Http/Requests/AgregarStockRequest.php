<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AgregarStockRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return
        [
            'cantidad_productos' => 'required|numeric'
        ];
    }

    public function messages()
    {

        return
        [
            'cantidad_productos.required' => 'La cantidad de productos es obligatoria',
            'cantidad_productos.numeric' => 'La cantidad  de productos debe ser numerica'

        ];
        
        
    }



}
