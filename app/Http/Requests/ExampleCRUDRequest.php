<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExampleCRUDRequest extends FormRequest
{
    /**
    * Determine if the user is authorized to make this request.
    */
    public function authorize(): bool
    {
        return true;
    }

    /**
    * Get the validation rules that apply to the request.
    *
    * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
    */
    public function rules(): array
    {
        $postRules = [];
        $putRules = [];

        $rules = [
            'name' => ['string', 'min:3', 'max:255'],
            'age' => ['min:0', 'numeric'],
            'email' => ['email', 'max:255', 'unique:example_CRUDS,email']
        ];

        if ($this->isMethod('post')) {
            $postRules = [
                'name' => ['required'],
                'age' => ['required'],
                'email' => ['required'],
            ];
        }

        if ($this->isMethod('put')) {
            $putRules = [
                'name' => ['sometimes'],
                'age' => ['sometimes'],
                'email' => ['sometimes'],
            ];
        }

        return array_merge_recursive($rules, $postRules, $putRules);
    }

    public function messages(): array
    {
        return [
            'name.required' => 'O nome é obrigatório.',
            'name.string'   => 'O nome deve ser um texto.',
            'name.min'      => 'O nome deve ter pelo menos :min caracteres.',
            'name.max'      => 'O nome não pode ter mais que :max caracteres.',

            'age.required' => 'A idade é obrigatória.',
            'age.numeric'  => 'A idade deve ser um número.',
            'age.min'      => 'A idade deve ser no mínimo :min.',

            'email.required' => 'O e-mail é obrigatório.',
            'email.email'    => 'O e-mail informado não é válido.',
            'email.max'      => 'O e-mail não pode ter mais que :max caracteres.',
            'email.unique'   => 'Este e-mail já está em uso.',
        ];
    }


}
