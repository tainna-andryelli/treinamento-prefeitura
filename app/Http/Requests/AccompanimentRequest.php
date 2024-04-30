<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AccompanimentRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'required|string',
            'status' => 'required|in:A,E,S',
            'protocol_number' => 'required|numeric',
        ];
    }

    public function messages():array
    {
        return [
            'description.required' => 'A descrição é obrigatória.', 
            'status.required' => 'A Situação é obrigatória.', 
            'status.in' => 'Valor para Situação é inválido.', 
        ];
    }
}
