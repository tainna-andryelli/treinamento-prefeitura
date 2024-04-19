<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AttachedFilesRequest extends FormRequest
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
            'files' => 'max:5', 
            'files.*' => 'mimes:jpg,jpeg,png,pdf|max:3072',
        ];
    }

    public function messages(): array
    {
        return [
            'files.*.mimes' => 'Formato de arquivos permitidos: JPG, JPEG, PNG e PDF.',
            'files.*.max' => 'O arquivo não pode ser maior que 3MB.',
            'files.max' => 'São permitidos no máximo 5 arquivos por protocolo.',
        ];
    }
}
