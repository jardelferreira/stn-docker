<?php

namespace App\Http\Requests;

use App\Rules\Cpf;
use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
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
            "slug" => "unique:employees,slug,{$this->uuid},uuid|max:60",
            "profession_id" => "exists:professions,id",
            "user_id" => "exists:users,id",
            'registration' => "min:4|unique:employees,registration,{$this->uuid},uuid",
            "cpf" => ["unique:employees,cpf,{$this->uuid},uuid", new Cpf],
            "admission" => "date"
        ];
    }

    protected function prepareForValidation(): void
    {
        $random_string = Str::random();
        $this->merge([
            'slug' => Str::slug("{$this->name}-{$random_string}"),
            // 'cpf' => intval($this->cpf),
        ]);
    }

    public function messages()
    {
        return [
            "slug,unique" => "O campo slug gerado já existe, tente novamente",
            "slug.max" => "tamnho do slug maior que o esperado",
            "profession_id.exists" => "Profissão não encontrada",
            "user_id" => "Usuário não localizado",
            'registration.min' => "A matrícula deve ter pelo menos 4 caracteres",
            'registration.unique' => "A matrícula já existe",
            "cpf.required" => "O campo CPF é obrigatório",
            "cpf.digits" => "O campo CPF deve conter 11 digitos",
            "cpf.unique" => "CPF já cadastrado",
            "admission.date" => "Campo data não válido",
        ];
    }

    public function validaCPF($cpf) { 
        // Extrai somente os números
        $cpf = preg_replace( '/[^0-9]/is', '', $cpf );
         
        // Verifica se foi informado todos os digitos corretamente
        if (strlen($cpf) != 11) {
            return false;
        }
    
        // Verifica se foi informada uma sequência de digitos repetidos. Ex: 111.111.111-11
        if (preg_match('/(\d)\1{10}/', $cpf)) {
            return false;
        }
    
        // Faz o calculo para validar o CPF
        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }
}
