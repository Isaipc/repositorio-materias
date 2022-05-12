<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materia extends Model
{
    use Common;

    protected $table = 'materias';
    protected $fillable = [
        'nombre',
        'descripcion',
        'estatus',
        'clave'
    ];


    public function getCreatedAtAttribute($value)
    {
        return $value;
    }

    public function getUpdatedAtAttribute($value)
    {
        return $value;
    }

    /**
     * Get all of the comments for the Materia
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function unidades(): HasMany
    {
        return $this->hasMany(Unidad::class, 'materia_id', 'id');
    }

    /**
     * Get all of the alumnoEnMateria for the Materia
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function alumnoEnMateria(): HasMany
    {
        return $this->hasMany(AlumnoEnMateria::class, 'materia_id', 'id');
    }

    /**
     * The alumnos that belong to the Materia
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function alumnos(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'usuario_materias', 'materia_id', 'usuario_id')->withTimestamps();
    }
}
