<?php

namespace App\Http\Controllers;

use App\Archivo;
use App\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
    public function store(Request $request)
    {
        $this->validator($request);
        return $this->save(new Archivo, $request);
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
    public function update(Request $request, Archivo $archivo)
    {
        $this->validator($request);
        return $this->save($archivo, $request);
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

    protected function save(Archivo $archivo, Request $request)
    {
        $unidad = Unidad::find($request->unidad_id);

        $archivo->nombre = $request->nombre;
        $archivo->estatus =  isset($request->estatus)
            ? config('constants.status_enabled')
            : config('constants.status_disabled');

        if (!$request->hasFile('file'))
            abort(500, 'Archivo no encontrado');

        if (!$request->file('file')->isValid())
            abort(500, 'No se pudo subir el archivo. Formato invalido');

        $file = $request->file('file');

        if ($archivo->id != 0)
            Storage::delete([$archivo->path]);

        $path = $file->store('private');

        $archivo->extension = $file->getClientOriginalExtension();
        $archivo->path = $path;

        $unidad->archivos()->save($archivo);
        return  response()->json(['success' => 'Se ha subido el archivo']);
    }

    protected function validator(Request $request)
    {
        return $request->validate([
            'nombre' => 'required',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Archivo $archivo)
    {
        $archivo->delete();

        $response = response()->json(['success' => 'Se ha eliminado ' . $archivo->nombre]);
        return $response;
    }

    /**
     * Change the status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Archivo $archivo, Request $request)
    {
        $validated = $request->validate([
            'estatus' => 'required',
        ]);

        $archivo->estatus =  $request->estatus == "false"
            ? config('constants.status_disabled')
            : config('constants.status_enabled');
        $archivo->save();
        $response = response()->json(['success' => 'Se ha ' . $archivo->getEstatusName() . ' ' . $archivo->nombre]);
        return $response;
    }
}
