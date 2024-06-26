<?php

namespace App\Http\Requests\API;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreInvoiceProductsAPIRequest extends FormRequest
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
            'name' => "required",
            'description' => "required",
            'qtd' => "required|numeric",
            'und' => "required|max:10",
            'value_unid' => "required|numeric",
            'image_path' => "nullable",
            'ca_number' => "nullable",
            'product_id' => "required|exists:products,id",
        ];
    }

    public function messages()
    {
        return [
            "name.required" => "O campo nome é obrigatório",
            "qtd.required" => "O campo quantidade é obrigatório",
            "qtd.numeric" => "O campo quantidade deve conter um valor numérico",
            "und.required" => "O campo unidade é obrigatório",
            "und.max" => "O campo und deve ter no máximo 10 caracteres",
            "value_unid.required" => "O campo valor unitário é obrigatório",
            "value_unid.numeric" => "O campo valor unitário deve conter um valor numérico",
            'product_id.required' => "O campo Produto é obrigatório",
            'product_id.exists' => "Produto não encontrado",
        ];
    }

    public function prepareForValidation()
    {
       return $this->merge([
        'value_unid' => str_replace(',','.',$this->value_unid),
       ]);
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();

        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Erro de validação',
            'errors' => $errors
        ], 422));
    }
}
