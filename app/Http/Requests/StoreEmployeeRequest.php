<?php

namespace App\Http\Requests;

use App\Rules\Cpf;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StoreEmployeeRequest extends FormRequest
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
        $cpf = new Cpf;
        return [
            "slug" => "required|unique:employees,slug,{$this->uuid},uuid|max:60",
            "profession_id" => "required|exists:professions,id",
            "user_id" => "required|exists:users,id",
            'registration' => "required|min:4|unique:employees,registration,{$this->uuid},uuid",
            "cpf" => ['required','unique:employees,cpf,{$this->uuid},uuid', new Cpf],
            "admission" => "required|date"
        ];
    }

    public function messages()
    {
        return [
            "slug,unique" => "O campo slug gerado já existe, tente novamente",
            "slug.max" => "tamnho do slug maior que o esperado",
            "profession_id.exists" => "Profissão não encontrada",
            "profession_id.required" => "O campo Profissão é obrigatório",
            "user_id.exists" => "Usuário não localizado",
            "user_id.required" => "O campo usuário é obrigatório",
            'registration.min' => "A matrícula deve ter pelo menos 4 caracteres",
            'registration.unique' => "A matrícula já existe",
            'registration.required' => "O campo matrícula é obrigatório",
            "cpf.required" => "O campo CPF é obrigatório",
            "cpf.cpf" => "O campo CPF não é valido",
            "cpf.digits" => "O campo CPF deve conter 11 digitos",
            "cpf.unique" => "CPF já cadastrado",
            "admission.date" => "Campo data não válido",
            "admission.required" => "O campo Adimissão é obrigatório",
        ];
    }

    protected function prepareForValidation(): void
    {
        $random_string = Str::random();
        $this->merge([
            'slug' => Str::slug("{$this->name}-{$random_string}"),
            'uuid' => Str::uuid(),
        ]);
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
