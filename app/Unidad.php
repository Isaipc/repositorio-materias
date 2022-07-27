<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unidad extends Model
{
    use Common;

    protected $table = 'unidades';
    protected $fillable = [
        'nombre',
        'url',
        'estatus',
    ];
    
    /**
     * all of the relationships to be touched.
     *
     * @var array
     */
    protected $touches = ['materia'];

    /**
     * Get the user that owns the archivo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }

    /**
     * Get all of the comments for the Materia
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function archivos(): HasMany
    {
        return $this->hasMany(Archivo::class, 'unidad_id', 'id');
    }
}
