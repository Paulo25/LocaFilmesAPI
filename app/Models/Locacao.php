<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Locacao extends Model
{
    protected $table = 'locacaos';

    protected $primaryKey = 'id';

    protected $timestamp = true;

    protected $fillable = [
        'cliente_id',
        'filme_id'
    ];

}
