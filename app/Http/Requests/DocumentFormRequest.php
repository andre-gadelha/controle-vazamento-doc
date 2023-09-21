<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocumentFormRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            //
            'autor' => 'required',
            'funcao' => 'required',
            'identidade' => 'required',
            'document' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'autor' => 'Informe o autor;',
            'funcao' => 'Informe a função;',
            'identidade' => 'Informe a Identidade;',
            'document' => 'Adicione o documento;',
        ];
    }
}
