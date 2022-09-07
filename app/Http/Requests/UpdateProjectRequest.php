<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'name' => 'required|min:10|max:60|unique:projects,name',
            'uuid' => 'required|uuid',
            'slug' => 'required|max:60',
            'description' => 'nullable',
            'initials' => 'required|min:2|max:15'
        ];
    }
}
