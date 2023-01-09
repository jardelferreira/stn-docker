<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBaseRequest extends FormRequest
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
            'name' => "required|max:55",
            'description' => "required|max:255",
            'place' => "required|max:75",
            'project_id' => "required|exists:projects"
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'O campo nome é obrigatório',
            'description.required' => 'A descrição é obrigatória',
            'place.required' => 'A Localização é Obrigatória',
            'project.required' => 'Informe o Projeto da lista',

            'name.max' => "E tamanho máximo é de 55 caracters",
            'description.max' => "E tamanho máximo é de 55 caracters",
            'place.max' => "E tamanho máximo é de 75 caracters",
            'project_id.exists' => "Projeto não localizado"
        ];
    }

    // Form request class...
    protected function prepareForValidation(): void
    {

        $this->merge([]);
    }
}
