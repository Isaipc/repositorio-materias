<?php

namespace App\Http\Controllers;

use App\CarritoDeCompras;
use App\Materia;
use App\archivo;
use App\Image;
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
            'rows' => $this->actives($materia),
            'deleted' => $this->deleted()->count()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('archivos.create', [
            'Materias' => Materia::orderBy('nombre', 'ASC')->where('estatus', 1)->get(),
            'rows' => archivo::orderBy('nombre', 'ASC')->where('estatus', 1)->get(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        return view('archivos.trash', [
            'rows' => archivo::orderBy('nombre', 'ASC')->where('estatus', 0)->get(),
        ]);
    }

    /**
     * update the specified resource in storage.
     *
     * @param  \app\archivo  $archivo
     * @return \illuminate\http\response
     */
    public function restore(archivo $archivo)
    {
        $archivo->estatus = 1;
        $archivo->save();

        alert()->success('Completado', 'Elemento restaurado');

        return redirect()->route('archivos.index');
    }

    protected function save(archivo $item, Request $request)
    {
        // dd($request);
        $request->validate([
            'nombre' => 'required',
            'file' => 'mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('file')) {
            if (!$request->file('file')->isValid())
                abort(500, 'Could not upload image :(');
            $url = archivo::store($request->file);
        }

        $item->nombre = mb_strtoupper($request->nombre, 'UTF-8');
        $item->materia_id = $request->materia_id;
        $item->url = $url;
        $item->save();

        // alert()->success('Completado', 'Guardado correctamente');
        return $item;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $archivo = new archivo;
        $this->save($archivo, $request);

        return redirect()->route('archivos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function show(archivo $archivo)
    {
        return view('archivos.show', ['item' => $archivo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function edit(archivo $archivo)
    {
        return view('archivos.edit', [
            'Materias' => Materia::orderBy('nombre', 'ASC')->where('estatus', 1)->get(),
            'rows' => archivo::orderBy('nombre', 'ASC')->where('estatus', 1)->get(),
            'item' => $archivo
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, archivo $archivo)
    {
        $this->save($archivo, $request);

        return redirect()->route('archivos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(archivo $archivo)
    {
        $archivo->estatus = 0;
        $archivo->save();

        alert()->success('Completado', 'Eliminado correctamente');

        return redirect()->route('archivos.index');
    }

    public function actives($materia_id)
    {
        return archivo::where('estatus', '!=', 0)
        ->where('materia_id', $materia_id)
        ->orderBy('nombre', 'ASC')->get();
    }

    public function deleted()
    {
        return archivo::where('estatus', 0)->orderBy('nombre', 'ASC')->get();
    }
}
