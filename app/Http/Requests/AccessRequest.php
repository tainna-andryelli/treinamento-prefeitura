<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AccessRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'department_id' => ['required', 'exists:departments,id',
            Rule::unique('accesses')->where(function ($query) {
                return $query->where('user_id', $this->user_id)
                             ->where('department_id', $this->department_id);
            })],
        ];
    }

    public function messages(): array
    {
        return [
        'user_id.required' => 'O usuário é obrigatório.',
        'user_id.exists' => 'O usuário não é válido.',
        'department_id.required' => 'O departamento é obrigatório.',
        'department_id.exists' => 'O departamento fornecido não é válido.',
        'department_id.unique' => 'Este usuário já possui acesso.'
        ];
    }
}
