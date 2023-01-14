<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFieldRequest extends FormRequest
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
            "stok_id"   => "required|exists:stoks,id",
            "signature_delivered" => "required|exists:signatures,id",
            "qtd_delivered" => "required|numeric",
        ];
    }

    public function messages()
    {
        return [
            'stok_id.required' => "O campo Produto é obrigatório",
            'stok_id.exists' => "Não foi possível localizar o produto em nossa base.",
            'signature_delivered.required' => "É necessário gerar uma assinatura para este evento, tente novamente",
            'signature_delivered.exists' => "Assinatura perdida durante a inserção, recarreque a página.",
            'qtd_delivered.required' => "Favor informar a quantidade",
            'qtd_delivered.required' => "O campo quantidade é obrigatório",
        ];
    }
}
