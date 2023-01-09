<?php

namespace App\Http\Requests;

// use App\Models\Provider;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreInvoiceRequest extends FormRequest
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
            'slug' => "required|unique:invoices,slug,{$this->slug}",
            'invoice_type' => "required",
            'provider_id' => "required|exists:providers",
            'departament_cost_id' => "required|exists:departament_costs",
            'number' => "required|unique:invoices,number,null,{$this->number},invoice_type,{$this->invoice_type},provider_id,{$this->provider_id},departament_cost_id,{$this->departament_cost_id}"
        ];
    }

    // Form request class...
    protected function prepareForValidation(): void
    {
        $this->merge([
            'slug' => Str::random(30)
        ]);
    }

    public function messages()
    {
        return [
            'number.unique' => "Esta NF já está cadastrada para este departamento!",
            "number.required" => "O número da nota é obrigatório",
            "slug.required" => "houve um erro em gerar um slug para esta nota",
            "slug.unique" => "houve o slug gerado não é único",
            "departament_cost_id.required" => "O campo departamento de custo é obrigatório",
            "departament_cost_id.exists" => "O departamento não existe",
            "provider_id.required" => "O campo fornecedor é obrigatório",
            "provider_id.exists" => "O fornecedor não existe",
        ];
    }
}
