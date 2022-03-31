<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materia extends Common 
{
    protected $table = 'materias';
    protected $fillable = [
        'nombre',
        'descripcion',
        'estatus',
    ];

    
    /**
     * Get all of the comments for the Materia
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documentos(): HasMany
    {
        return $this->hasMany(Documento::class, 'materia_id', 'id');
    }

}
