<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $primaryKey = 'id';

    protected $timestamp = true;

    protected $fillable = [
        'nome',
        'cpf_cnpj',
        'image'
    ];


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rulesStore()
    {
        return [
            'nome' => 'required|min:11|max:150',
            'cpf_cnpj' => 'required|min:11|max:15|unique:clientes',
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',
            
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rulesUpdate($id = null)
    {
        return [
            'nome' => 'required|min:11|max:150',
            'cpf_cnpj' => 'required|min:11|max:15'.Rule::unique('clientes')->ignore($id),
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
