<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class StoreProviderRequest extends FormRequest
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
            "slug" => "required|unique:providers,slug,{$this->uuid},uuid",
            "email" => "required|email|unique:providers,email,{$this->uuid},uuid",
            "cnpj" => "rrequired|"
        ];
    }

    protected function prepareForValidation()
    {
        return $this->merge([
            "slug" => Str::slug(Str::upper($this->corporate_name) . " " . $this->cnpj)
        ]);
    }
}
