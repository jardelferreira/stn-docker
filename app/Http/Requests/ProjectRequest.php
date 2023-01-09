<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        
        return [
            'name' => "required|min:3|max:255|unique:projects,name,{$this->uuid},uuid",
            'description' => 'nullable',
            'initials' => "required|min:2|max:255|unique:projects,initials,{$this->uuid},uuid"
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'initials.required' => 'A sigla do projeto é obrigatória',
            'name.min' => "O tamnho mínimo é de 3 caracters",
            'initials.min' => "O tamnho mínimo é de 3 caracters",
            'name.max' => "O tamanho máximo é de 255 caracters",
            'initials.max' => "O tamanho máximo é de 255 caracters",
            'name.unique' => "O nome já está em uso por outro projeto",
            'initials.unique' => "As Iniciais já está em uso por outro projeto",
        ];
    }

     // Form request class...
     protected function prepareForValidation(): void
     {
         $this->merge([
            'initials' => Str::upper($this->initials)
         ]);
     }
}
