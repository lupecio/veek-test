<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
            'name' => 'required|max:30',
            'email'  => 'required|max:50|unique:users,email,' . $this->user['id']
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Nome é obrigatório',
            'email.required'  => 'Email é obrigatóro',
            'email.unique' => 'O email já está em uso',
            'name.max' => 'O máximo de caracteres para o campo nome é 30',
            'email.max' => 'O máximo de caracteres para o campo email é 50'
        ];
    }
}
