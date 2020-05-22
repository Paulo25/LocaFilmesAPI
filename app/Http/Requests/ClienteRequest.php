<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
    public function rules($id = null)
    {
        return [
            'nome' => 'required|min:11|max:150',
            'cpf_cnpj' => 'required|min:11|max:15|'.Rule::unique('clientes')->ignore($id),
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            
        ];
    }

    /**
     * regra validação
     * @return array
     */
    public function messages(){
        return [
            'required' => 'Preencha o campo :attribute.',
            'cpf_cnpj.unique' => 'Este cpf/cnpj já está cadastrado.',
            'image' => 'Arquivo invalido!',
            'min' => 'O campo deve ser no minímo 11 caractéres.',
			'image.max' => 'Este arquivo excedeu o tamanho permitido de 2048.',
            'nome.max' => 'O campo deve ser no máximo 150 caractéres.',
            'cpf_cnpj.max' => 'O campo deve ser no máximo 11 caractéres.',
            'mimes' => 'Tipo de arquivo não corresponde ao campo :attribute.'
        ];
    }
}
