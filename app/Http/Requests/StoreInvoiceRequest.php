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
            'provider_id' => "required",
            'departament_cost_id' => "required",
            'number' => "required|unique:invoices,number,null,{$this->number},invoice_type,{$this->invoice_type},provider_id,{$this->provider_id},departament_cost_id,{$this->departament_cost_id}"
        ];
    }

    // Form request class...
    protected function prepareForValidation(): void
    {
        // $departament_cost = DepartamentCost::where('id',$this->departament_cost_id)->first();
        // $provider = Provider::where('id',$this->provider_id)->first();
        $this->merge([
            'slug' => Str::random(30)
        ]);
    }

    public function messages()
    {
        return [
            'number.unique' => "Esta NF já está cadastrada para este departamento!"
        ];
    }
}
