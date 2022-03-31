<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Documento extends Common
{
    protected $table = 'documentos';
    const IMG_DEFAULT_URL = 'doc/no-disponible.svg';
    protected $fillable = [
        'nombre',
        'url',
        'estatus',
    ];

    /**
     * Get the user that owns the Documento
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
        $doc = Image::create(['url' => $url]);

        return $doc;
    }
}
