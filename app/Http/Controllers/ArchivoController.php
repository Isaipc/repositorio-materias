<?php

namespace App\Http\Controllers;

use App\Materia;
use App\Archivo;
use App\Constants;
use App\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller implements Constants
{
    /**
     * display a listing of the resource.
     *
     * @return \illuminate\http\response
     */
    public function index()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash(Unidad $unidad)
    {
        return view('archivos.trash', ['item' => $unidad, 'parent' => $unidad->materia]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function show(Archivo $archivo)
    {
        $user = Auth::user();

        if (!$user->materias->contains($archivo->unidad->materia))
            return redirect('/');

        return response()->file(str_replace("/", "\\", storage_path("app/{$archivo->path}")));
        // abort_if(!Storage::disk('files')->exists($path), 404, "The file doesn't exist. Check the path.");
        // return Storage::disk('files')->response($path);
    }
}
