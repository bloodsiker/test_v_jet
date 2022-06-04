<?php

namespace App\Http\Requests;


use Anik\Form\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|min:3',
            'last_name'  => 'required|min:3',
            'phone'      => 'required|max:50',
            'email'      => 'required|email|unique:users',
            'password'   => 'required|min:6',
        ];
    }


    public function messages(): array
    {
        return [
           //
        ];
    }
}
