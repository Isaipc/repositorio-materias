<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Archivo extends Common
{
    protected $table = 'archivos';
    protected $fillable = [
        'nombre',
        'url',
        'estatus',
        'materia_id',
    ];

    /**
     * Get the user that owns the archivo
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function materia(): BelongsTo
    {
        return $this->belongsTo(Materia::class);
    }


    public static function store($doc)
    {
        $ext = $doc->extension();
        $docName = time() . '.' . $ext;

        $path = $doc->storeAs('/public', $docName);
        $url = Storage::url($docName);
        return $url;
    }

    public static function destroy($url)
    {
        Storage::delete([$url]);
    }
}
