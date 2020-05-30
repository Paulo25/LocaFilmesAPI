<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Filme extends Model
{
    protected $table = 'filmes';

    protected $primaryKey = 'id';

    protected $timestamp = true;

    protected $fillable = [
        'titulo',
        'capa'
    ];

    /**
     * regras de validação
     * @return array
     */
    public function rules($id = null){
        return [
            'titulo' => 'required|max:150|' . Rule::unique('filmes')->ignore($id),
            'capa' => 'nullable|image|mimes:png,jpg,jpeg,svg,gif|max:2048'
        ];
    }

    /**
     * mensagens de validação
     * @return array
     */
    public function messages(){
        return [
            'required' => 'Preencha o campo :attribute.',
            'image' => 'Arquivo invalido!',
            'mimes' => 'A imagem deve ser um arquivo do tipo: png, jpg, jpeg, gif, svg.',
            'titulo.unique' => 'Já existe um filme cadastrado com este :attribute',
            'titulo.max' => 'O campo deve ser no máximo 150 caractéres.',
            'capa.max' => 'O campo deve ser no máximo 2048 caractéres.',
        ];
    }

}
