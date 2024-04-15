<?php

namespace App\Http\Requests;

use App\Rules\CpfValidateRule;
use Illuminate\Foundation\Http\FormRequest;

class PeopleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $personId = $this->route('id');

        $rules = [
            'name' => 'required|min:3',
            'birthday' => 'required|date',
            'sex' => 'required'
        ];

        //valida o cpf se for cadastro
        if(!$personId){
            $rules['cpf'] = ['required', 'unique:people,cpf', new CpfValidateRule];
        }

        return $rules;
    }

    public function messages():array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.min' => 'O nome deve ter no mínimo :min caracteres.',
            'birthday.required' => 'Digite sua data de Nascimento.',
            'birthday.date' => 'A data de Nascimento deve ser uma data válida.',
            'cpf.required' => 'O CPF é obrigatório.',
            'cpf.unique' => 'CPF já cadastrado.',
            'sex.required' => 'Selecione o sexo.',
            'CpfValidateRule' => 'CPF inválido.',
        ];
    }
}
