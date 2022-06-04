<?php

namespace App\Http\Requests;


use Anik\Form\FormRequest;

class CompanyStoreRequest extends FormRequest
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
            'title'       => 'required|string',
            'phone'       => 'required|string',
            'description' => 'required|string',
        ];
    }


    public function messages(): array
    {
        return [
           //
        ];
    }
}
