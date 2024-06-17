<?php

namespace App\Http\Requests\API;

use App\Models\Invoice;
use App\Models\Provider;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreInvoiceAPIRequest extends FormRequest
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
        $cost_id = $this->departament_cost_id;
        return [
            'name' => ["min:5",function($attribute,$value,$fail) use ($cost_id){
                if((Invoice::where($attribute,$value)
                ->where('departament_cost_id',$cost_id)
                ->count() > 0)){
                    $fail("A nota já está cadastrada para este departamento de custo");
                }
            }],
            'slug' => "required|unique:invoices,slug,{$this->slug}",
            'invoice_type' => "required",
            'provider_id' => "required|exists:providers,id",
            'issue' => 'required|date|before_or_equal:due_date',
            'due_date' => 'required|date',
            'departament_cost_id' => "required|exists:departament_costs,id",
            'number' => "required",
            'value_departament' => "required|numeric",
            'value' => "required|numeric",
            'file_invoice' => "mimes:pdf|required",
        ];
    }

    // Form request class...
    protected function prepareForValidation(): void
    {

        $this->merge([
            'slug' => Str::random(30),
            'name' => $this->setName($this->provider_id,$this->invoice_type,$this->number),
            // 'value' => floatval($this->value),
            // 'value_departament' => floatval($this->value_departament),
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
            "value.numeric" => "O valor total não é um decimal válido",
            "value.required" => "O campo valor total é Obrigatório" ,
            "value_departament.numeric" => "O valor para departamento não é um decimal válido",
            "value_departament.required" => "O campo valor para departamento é Obrigatório",
            "invoice_type.required" => "O campo tipo é obrigatório",
            "file_invoice.required" => "É necessário enviar a nota no formato PDF" ,
            "file_invoice.mimes" => "Tipo de arquivo não suportado",
            "issue.date" => "Data de emissão tem um formato inválido.",
            "issue.required" => "O campo emissão é obrigatório",
            "due_date.date" => "Data de emissão tem um formato inválido.",
            "due_date.required" => "O campo emissão é obrigatório",
            "issue.before_or_equal" => "A data de emissão não pode ser maior que o vencimento",
        ];
    }

    public function setName($id,$type,$number){
        if($id != "" && $type != "" && $number != ""){

            $provider = Provider::where("id",$id)->first();
            $name = "{$type}-{$this->number}-{$provider->fantasy_name}";

            return Str::upper($name);
        }
        return "";
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
