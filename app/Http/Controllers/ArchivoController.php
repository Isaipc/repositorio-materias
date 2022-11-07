<?php

namespace App\Http\Controllers;

use App\Archivo;
use App\Unidad;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
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
        $path = str_replace("/", "\\", storage_path("app/{$archivo->path}"));

        if ($user->hasRole('Administrador'))
            return response()->file($path);

        if (!$user->materias->contains($archivo->unidad->materia) || $archivo->estatus != config('constants.status_enabled'))
            return redirect('/');

        return response()->file($path);
        // return Storage::disk('files')->response($path);
    }
}
