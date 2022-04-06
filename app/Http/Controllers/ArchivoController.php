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
            'materia' => $materia,
            'rows' => $materia
                ->archivos()->get(),
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
            'rows' => $materia->archivos()->get(),
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
            'rows' => $this->deleted(),
        ]);
    }

    /**
     * update the specified resource in storage.
     *
     * @param  \app\archivo  $archivo
     * @return \illuminate\http\response
     */
    public function restore(Archivo $archivo)
    {
        $archivo->estatus = 1;
        $archivo->save();

        alert()->success('Completado', 'Elemento restaurado');

        return redirect()->route('archivos.index');
    }

    protected function save(Archivo $item, Request $request)
    {
        // dd($request);
        $request->validate([
            'nombre' => 'required',
            'estatus' => 'required',
            'file' => 'max:2048',
        ]);

        if ($request->hasFile('file')) {
            if (!$request->file('file')->isValid())
                abort(500, 'Could not upload image :(');
            $url = archivo::store($request->file);
        }
        // dd($request);

        $item->nombre = mb_strtoupper($request->nombre, 'UTF-8');
        $item->materia_id = $request->materia_id;
        $item->estatus = $request->estatus;
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
    public function store(Materia $materia, Request $request)
    {
        $archivo = new Archivo;
        $request->materia_id = $materia->id;
        $this->save($archivo, $request);

        return redirect()->route('archivos.index', $materia);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function show(Archivo $archivo)
    {
        return view('archivos.show', ['item' => $archivo]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function edit(Archivo $archivo)
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
    public function destroy(Archivo $archivo)
    {
        $archivo->estatus = 0;
        $archivo->save();

        alert()->success('Completado', 'Eliminado correctamente');

        return redirect()->route('archivos.index');
    }

    public function actives($materia_id)
    {
        return Archivo::where('estatus', '!=', 0)
            ->where('materia_id', $materia_id)
            ->orderBy('nombre', 'ASC')->get();
    }

    public function deleted()
    {
        return Archivo::where('estatus', 0)->orderBy('nombre', 'ASC')->get();
    }
}
