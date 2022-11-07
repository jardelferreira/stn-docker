<?php

namespace App\Http\Requests;

use App\Models\Provider;
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
        $departament = intVal($this->departament_cost_id);
        return [
            'slug' => "required|unique:invoices,slug,{$departament},departament_cost_id"
        ];
    }

    // Form request class...
    protected function prepareForValidation(): void
    {
        $provider = Provider::where('id',$this->provider_id)->first();
        $this->merge([
            'slug' => Str::upper("{$this->invoice_type}-{$this->number}-{$provider->uuid}")
        ]);
    }
}
