<?php

namespace App\Http\Controllers;

use App\Archivo;
use App\Unidad;
use Illuminate\Http\Request;

class ArchivoAJAXController extends Controller
{
    /**
     * display a listing of the resource.
     *
     * @return \illuminate\http\response
     */
    public function index(Unidad $unidad)
    {
        return response()->json([
            'data' => $unidad->archivos()->where('estatus', '!=', config('constants.status_archived'))->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Unidad $unidad, Request $request)
    {
        $this->validator($request);
        $this->save($unidad, new Archivo, $request);

        return  response()->json(['success' => 'Se ha subido el archivo']);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function update(Archivo $archivo, Request $request)
    {
        $this->validator($request);

        $unidad = $archivo->unidad;
        $this->save($unidad, $archivo, $request);

        return  response()->json(['success' => 'Se ha subido el archivo']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function archive(Archivo $archivo)
    {
        $archivo->estatus = 0;
        $archivo->save();

        $response = response()->json(['success' => 'Se ha eliminado ' . $archivo->nombre]);
        return $response;
    }

    protected function save(Unidad $unidad, Archivo $archivo, $request)
    {
        $archivo->nombre = $request->nombre;
        $archivo->estatus =  isset($request->estatus) ? 1 : 2;

        if (!$request->hasFile('file'))
            abort(500, 'Archivo no encontrado');

        if (!$request->file('file')->isValid())
            abort(500, 'No se pudo subir el archivo. Formato invalido');

        $file = $request->file('file');
        $fileName = $request->nombre;

        $path = $file->store('private');

        $archivo->extension = $file->getClientOriginalExtension();
        $archivo->path = $path;
        $unidad->archivos()->save($archivo);
    }

    protected function validator(Request $request)
    {
        return $request->validate([
            'nombre' => 'required',
        ]);
    }
}
