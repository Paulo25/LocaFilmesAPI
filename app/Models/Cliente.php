<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Documento;
use App\Models\Telefone;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $primaryKey = 'id';

    protected $timestamp = true;

    protected $fillable = [
        'nome',
        'image'
    ];

    /**
     * Get the documento record associated with the cliente.
     */
    public function documento()
    {
        return $this->hasOne(Documento::class, 'cliente_id', 'id');
    }

    /**
     * Get the telefone record associated with the cliente.
     */
    public function telefone()
    {
        return $this->hasMany(Telefone::class, 'cliente_id', 'id');
    }

    /**
     * 
     */
    public function filmesAlugados(){
        return $this->belongsToMany(Filme::class, 'locacaos', 'cliente_id', 'filme_id');
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
            'image' => 'nullable|image|mimes:png,jpg,jpeg,gif,svg|max:2048',

        ];
    }

    /**
     * regra validação
     * @return array
     */
    public function messages()
    {
        return [
            'required' => 'Preencha o campo :attribute.',
            'image' => 'Arquivo invalido!',
            'min' => 'O campo deve ser no minímo 11 caractéres.',
            'image.max' => 'Este arquivo excedeu o tamanho permitido de 2048.',
            'nome.max' => 'O campo deve ser no máximo 150 caractéres.',
            'cpf_cnpj.max' => 'O campo deve ser no máximo 11 caractéres.',
            'mimes' => 'A imagem deve ser um arquivo do tipo: png, jpg, jpeg, gif, svg.'
        ];
    }
}
