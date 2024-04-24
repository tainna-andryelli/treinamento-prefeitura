<?php

namespace App\Http\Requests;

use App\Models\AttachedFile;
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
    //$totalFiles = $existingFilesCount + count($this->file('files', []));
    public function rules(): array
    {
        $existingFilesCount = $this->route('id') ? AttachedFile::where('protocol_number', $this->route('id'))->count() :0;
        $maxFiles = 5 - $existingFilesCount;
        return [
            'files' => 'max:' . $maxFiles, 
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
