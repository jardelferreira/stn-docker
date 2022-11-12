<?php

namespace App\Http\Requests;

use App\Models\Provider;
use Illuminate\Support\Str;
use App\Models\DepartamentCost;
use Illuminate\Foundation\Http\FormRequest;

class UpdateInvoiceRequest extends FormRequest
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
         $departament_cost = DepartamentCost::where('id',$this->departament_cost_id)->first();
         $provider = Provider::where('id',$this->provider_id)->first();
         $this->merge([
             'slug' => "{$this->invoice_type}-{$this->number}-{$provider->slug}-{$departament_cost->slug}"
         ]);
     }
}
