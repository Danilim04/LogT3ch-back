<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use MongoDB\Laravel\Eloquent\Model;

class cotacao extends Model
{
    protected $collection = 'cotacoes';
    protected $connection = 'mongodb';

    protected $fillable = [
        'cotacaoId',
        'nome',
        'nomeEmpresa',
        'telefone',
        'email',
        'infoSite',
        'valorSugerido'
    ];
}
