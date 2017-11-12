<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tarefa extends Model
{
    protected $fillable = [
        'idGrupo', 'mensagem', 'idUsuario', 'porcentagem', 'titulo', 
    ];
}