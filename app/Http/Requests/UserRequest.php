<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
            'name' => 'required|min:4|max:55',
            'email' => 'unique:users,email|required',
            'password' => ['required', 'confirmed', Password::min(8)]
        ];
    }

    public function messages()
    {
        return [
            'email.unique' => "O email já está cadastrado",
            'email.required' => "O campo e-mail é obrigatório",
            'name.required' => "O campo nome é obrigatório",
            'name.min' => "O campo nome precisa ter 4 caracteres no mínimo",
            'name.max' => "O campo nome pode ter até 55 caracteres",
            'password.required' => 'A senha é obrigatória',
            'password.confirmed' => 'Os campos senhas não conferem'
        ];
    }
    
}
