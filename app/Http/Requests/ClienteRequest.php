<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClienteRequest extends FormRequest
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
            'nome' => 'required',
            'cpf_cnpj' => 'required|unique:clientes',
            'image' => 'image'
        ];
    }

    /**
     * regra validação
     * @return array
     */
    public function messages(){
        return [
            'required' => 'Preencha o campo :attribute.',
            'cpf_cnpj.unique' => 'Este cpf/cnpj já existe na nossa base de dados.',
            'image' => 'Arquivo invalido!'
        ];
    }
}
