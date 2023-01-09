<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class StoreProfessionRequest extends FormRequest
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
            "name" => "required|max:60",
            "description" => "required|max:255"
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "O campo nome é obrigatório",
            "name.max" => "O campo nome deve ter no máximo 60 caracteres",
            "description.required" => "O campo descrição é obrigatório",
            "description.max" => "O campo descrição deve ter no máximo 255 caracteres"
        ];
    }
    // Form request class...
    protected function prepareForValidation(): void
    {
        $random_string = Str::random();
        $this->merge([
            'slug' => Str::slug("{$this->name}-{$random_string}")
        ]);
    }
}
