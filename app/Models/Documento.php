<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;
use App\Models\Cliente;

class Documento extends Model
{
    protected $table = 'documentos';

    protected $primaryKey = 'id';

    protected $timestamp = true;

    protected $fillable = [
        'cpf_cnpj',
        'cliente_id'
    ];

    /**
     * Get the cliente that owns the documento.
     */
    public function cliente(){
        return $this->belongsTo(Cliente::class, 'cliente_id', 'id');
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules($id = null){
        return [
            'cpf_cnpj' => 'required|min:11|max:19|' . Rule::unique('documentos')->ignore($id, 'cliente_id'),
            'cliente_id' => 'required|'. Rule::unique('documentos')->ignore($id, 'cliente_id')
        ];
    }
    
    /**
     * regra validação
     * @return array
     */
    public function messages(){
        return [
            'cpf_cnpj.unique' => 'Este cpf/cnpj já está cadastrado.',
            'required' => 'Preencha o campo :attribute.',
            'min' => 'O campo deve ser no minímo 11 caractéres.',
            'cpf_cnpj.max' => 'O campo deve ser no máximo 11 caractéres.',
            'cliente_id.unique' => 'Ja existe um cpf para este cliente'
        ];
    }

}
