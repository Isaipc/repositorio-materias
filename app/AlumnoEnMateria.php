<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AlumnoEnMateria extends Model
{
    protected $table = 'usuario_materias';

    protected $fillable = ['usuario_id', 'materia_id'];
}
