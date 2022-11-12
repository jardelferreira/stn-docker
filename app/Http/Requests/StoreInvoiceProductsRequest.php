<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceProductsRequest extends FormRequest
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

    public function prepareForValidation()
    {
       
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'name.*' => "required",
            'description.*' => "nullable",
            'qtd.*' => "required|numeric",
            'und.*' => "required|max:10",
            'value_unid.*' => "required|numeric",
            'image_path.*' => "nullable",
            'ca_number.*' => "nullable"
        ];
    }
}
