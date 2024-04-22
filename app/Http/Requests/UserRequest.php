<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CpfValidateRule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'cpf' => ['required', 'unique:users,cpf', new CpfValidateRule],
            'profile' => 'required|string|in:T,S,A',
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'Este campo é obrigatório.', 
            'name.min' => 'O nome deve ter no mínimo :min caracteres.',
            'name.max' => 'Nome não pode ter mais de 255 caracteres.',
            'email.unique' => 'Email já registrado no sistema.',
            'email.email' => 'Formato de email incorreto. Por favor tente: exemplo@gmail.com',
            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter no mínimo 8 caracteres.',
            'password.confirmed' => 'As senhas não coincidem.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.unique' => 'Este CPF já foi registrado no sistema.',
            'profile.required' => 'O tipo de usuário é obrigatório.',
        ];
    }
}
