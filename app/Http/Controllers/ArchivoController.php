<?php

namespace App\Http\Controllers;

use App\Materia;
use App\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ArchivoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Materia $materia)
    {
        return view('archivos.index', [
            'materia' => $materia,
            'deleted' => Archivo::archived()->count(),
            'rows' => Archivo::actives()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Materia $materia)
    {
        return view('archivos.create', [
            'materia' => $materia,
            'rows' => Archivo::actives()->get(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash(Materia $materia)
    {
        return view('archivos.trash', [
            'materia' => $materia,
            'rows' => Archivo::archived()->get()
        ]);
    }

    /**
     * update the specified resource in storage.
     *
     * @param  \app\Archivo  $archivo
     * @return \illuminate\http\response
     */
    public function restore(Archivo $archivo)
    {
        $archivo->estatus = 1;
        $archivo->save();


        return redirect()->route('archivos.index', $archivo->materia);
    }

    protected function validator(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'estatus' => 'required',
            'file' => 'max:4096',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Materia $materia, Request $request)
    {
        $this->validator($request);

        $archivo = new Archivo;

        $archivo->nombre = $request->nombre;
        $archivo->materia_id = $materia->id;
        $archivo->estatus = $request->estatus;

        if ($request->hasFile('file')) {
            if (!$request->file('file')->isValid())
                abort(500, 'Could not upload image :(');
            $url = Archivo::store($request->file);
        }

        $archivo->url = $url;
        $archivo->save();



        return redirect()->route('archivos.create', $materia);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function show(Materia $materia, Archivo $archivo)
    {
        return view('archivos.show', [
            'materia' => $materia,
            'item' => $archivo,
            'rows' => Archivo::actives()->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function edit(Materia $materia, Archivo $archivo)
    {
        return view('archivos.edit', [
            'materia' => $materia,
            'rows' => Archivo::actives()->get(),
            'item' => $archivo
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Archivo $archivo)
    {
        $this->validator($request);

        $archivo->nombre = $request->nombre;
        $archivo->estatus = $request->estatus;

        if ($request->hasFile('file')) {
            if (!$request->file('file')->isValid())
                abort(500, 'No se ha podido subir el archivo :(');
            $url = Archivo::store($request->file);
            Archivo::destroy($archivo->url);
        }

        $archivo->url = $url;
        $archivo->save();


        return redirect()->route('archivos.index', $archivo->materia);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Archivo $archivo)
    {
        $archivo->estatus = 0;
        $archivo->save();

        return redirect()->route('archivos.index', $archivo->materia);
    }
}
