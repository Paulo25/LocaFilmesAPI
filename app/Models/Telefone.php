<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cliente;

class Telefone extends Model
{
    protected $table = 'telefones';

    protected $primaryKe = 'id';

    protected $timestamp = true;

    protected $fillable = [
        'cliente_id',
        'numero'
    ];

    /**
     * Get the cliente that owns the telefone.
     */
    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }


    /**
     * regras de validação
     * @return array
     */
    public function rules($id = null)
    {
        return [
            'cliente_id' => 'required',
            'numero' => 'required|max:20'
        ];
    }

    /**
     * mensagem de validação
     * @return array
     */
    public function messages()
    {
        return [
            'required' => 'Preencha o campo :attribute.',
            'max' => 'O campo deve ser no máximo 20 caractéres.'
        ];
    }
}
