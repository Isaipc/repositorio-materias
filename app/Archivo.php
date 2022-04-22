<?php

namespace App;

use Facade\FlareClient\Stacktrace\File;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Archivo extends Model
{
    use Common;
    
    protected $table = 'archivos';
    protected $fillable = [
        'nombre',
        'url',
        'estatus',
        'materia_id',
    ];

    /**
     * All of the relationships to be touched.
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

    public function getUrlAttribute($value)
    {
        return Storage::url($value);
    }
}
