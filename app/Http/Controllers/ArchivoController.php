<?php

namespace App\Http\Controllers;

use App\Materia;
use App\Archivo;
use App\Constants;
use App\Unidad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller implements Constants
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Materia $materia)
    {
        return view('archivos.index', [
            'item' => $materia,
            'archived' => $materia->unidades()->where('estatus', Constants::ST_ARCHIVED)->get()
        ]);
    }

    /**
     * display a listing of the resource.
     *
     * @return \illuminate\http\response
     */
    public function list(Unidad $unidad)
    {
        return response()->json([
            'data' => $unidad->archivos()->where('estatus', '!=', Constants::ST_ARCHIVED)->get()
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
            'item' => $materia
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
        return $request->validate([
            'nombre' => 'required',
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
     * Display the specified resource.
     *
     * @param  \App\Archivo  $archivo
     * @return \Illuminate\Http\Response
     */
    public function show(Archivo $archivo)
    {
        return response()->file(str_replace("/", "\\", storage_path("app/{$archivo->path}")));
        // abort_if(!Storage::disk('files')->exists($path), 404, "The file doesn't exist. Check the path.");
        // return Storage::disk('files')->response($path);
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

        $path = $file->storeAs(
            "private",
            "{$unidad->materia->nombre}/{$unidad->nombre}/{$fileName}"
        );

        $archivo->extension = $file->getClientOriginalExtension();
        $archivo->path = $path;
        $unidad->archivos()->save($archivo);
    }
}
