<?php

namespace App\Http\Requests;

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
        return [
            //
        ];
    }

    protected function prepareForValidation(): void
    {
        $random_string = Str::random();
        $this->merge([
            'slug' => Str::slug("{$this->name}-{$random_string}"),
            'uuid' => Str::uuid(),
            'signature' => Hash::make(substr(filter_var($this->cpf,FILTER_SANITIZE_NUMBER_INT),0,4))
        ]);
    }
}
