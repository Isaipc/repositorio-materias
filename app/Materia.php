<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
    public function archivos(): HasMany
    {
        return $this->hasMany(Archivo::class, 'materia_id', 'id');
    }

    /**
     * Get all of the usuarios for the Materia
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function usuarios(): HasMany
    {
        return $this->hasMany(User::class, 'materia_id', '');
    }

    /**
     * The alumnos that belong to the Materia
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function alumnos(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user_table', 'user_id', 'role_id');
    }


}
