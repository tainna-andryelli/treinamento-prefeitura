<?php

namespace App\Http\Requests;

use App\Rules\ContributorAgeValidateRule;
use Illuminate\Foundation\Http\FormRequest;

class ProtocolsRequest extends FormRequest
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
        return [
            'description' => 'required',
            'created_date' => 'required|date',
            'deadline_days' => 'required|numeric|between:5,30',
            'contributor_id' => ['required', 'exists:people,id', new ContributorAgeValidateRule],
        ];
    }

    public function messages(): array
    {
        return [
            'description.required' => 'A descrição é obrigatória.',
            'created_date.required' => 'Especifique a data de criação.',
            'deadline_days.required' => 'O prazo é obrigatório',
            'deadline_days.numeric' => 'O prazo deve ser um número.',
            'deadline_days.between' => 'O prazo deve estar entre 5 e 30 dias.',
            'contributor_id.required' => 'O contribuinte é obrigatório.',
            'contributor_id.exists' => 'O contribuinte selecionado não está cadastrado no sistema.'
            
        ];
    }
}
