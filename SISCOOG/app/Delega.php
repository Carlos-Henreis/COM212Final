<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delega extends Model
{
    protected $fillable = [
        'idGrupo', 'idTarefa', 'idUsuario',
    ];
}
