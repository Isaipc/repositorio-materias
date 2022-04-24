<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Unidad extends Model
{
    use Common;

    protected $table = 'unidades';

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
}
