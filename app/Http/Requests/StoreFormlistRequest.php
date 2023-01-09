<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreFormlistRequest extends FormRequest
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
            "name" => "required|min:5",
            "description" => "required|min:5"
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "O campo nome é obrigatório",
            "description.required" => "O campo descrição é obrigatório",
            "name.min" => "O nome deve ter no mínimo 5 caracteres",
            "description.min" => "O campo descrição deve conter no mínimo 5 caracteres",
        ];
    }

    public function prepareForValidation()
    {
        return $this->merge([
            'uuid' => Str::uuid(),
            'revision' => "00"
        ]);
    }
}
