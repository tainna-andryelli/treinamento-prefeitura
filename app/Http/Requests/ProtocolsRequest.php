<?php

namespace App\Http\Requests;

use App\Rules\ContributorAgeValidateRule;
use Illuminate\Foundation\Http\FormRequest;

class ProtocolsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'description' => 'required|string|max:2000',
            'created_date' => 'required|date',
            'deadline_days' => 'required|numeric|between:5,30',
            'contributor_id' => ['required', 'exists:people,id', new ContributorAgeValidateRule],
            'department_id' => 'required|exists:departments,id',
            'status' => 'required|string|in:A,E,S',
            'files.*' => 'mimes:jpg,jpeg,png,pdf|max:3072',
            'files' => 'max:5',
        ];
    }

    public function messages(): array
    {
        return [
            'description.required' => 'A descrição é obrigatória.',
            'description.max' => 'A descrição não pode ter mais de 2000 caracteres.',
            'created_date.required' => 'Especifique a data de criação.',
            'deadline_days.required' => 'O prazo é obrigatório.',
            'deadline_days.numeric' => 'O prazo deve ser um número.',
            'deadline_days.between' => 'O prazo deve estar entre 5 e 30 dias.',
            'contributor_id.required' => 'O contribuinte é obrigatório.',
            'contributor_id.exists' => 'O contribuinte selecionado não está cadastrado no sistema.',
            'department_id.required' => 'O departamento é obrigatório.',
            'department_id.exists' => 'O departamento selecionado é inválido.',
            'status.required' => 'A situação atual do protocolo é obrigatória.',
            'files.*.mimes' => 'São permitidos somente arquivos JPG, JPEG, PNG e PDF.',
            'files.*.max' => 'O arquivo não pode ser maior que 3MB.',
            'files.max' => 'São permitidos no máximo 5 arquivos por protocolo.',
        ];
    }
}
