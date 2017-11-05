<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participa extends Model
{
    protected $fillable = [
        'idGrupo', 'idUsuario',
    ];
}
