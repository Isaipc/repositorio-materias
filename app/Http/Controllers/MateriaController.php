<?php

namespace App\Http\Controllers;

use App\Materia;
use ErrorException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class MateriaController extends Controller
{
    /**
     * display a listing of the resource.
     *
     * @return \illuminate\http\response
     */
    public function index()
    {
        return view('materias.index', [ ]);
    }

    /**
     * display a listing of the resource.
     *
     * @return \illuminate\http\response
     */
    public function list()
    {
        return response()->json(['data' => Materia::actives()->get()]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        return view('materias.trash', [ ]);
    }

    /**
     * update the specified resource in storage.
     *
     * @param  \app\Materia  $materia
     * @return \illuminate\http\response
     */
    public function restore(Materia $materia)
    {
        $materia->estatus = 2;
        $materia->save();

        // alert()->success('Completado', 'Elemento restaurado');

        return redirect()->route('materias.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('materias.create', [ ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->save(new Materia, $request);
        return redirect()->route('materias.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function show(Materia $materia)
    {
        return view('materias.show', [
            'item' => $materia
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function edit(Materia $materia)
    {
        return view('materias.edit', [
            'item' => $materia,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Materia $materia)
    {
        $this->save($materia, $request);
        return redirect()->route('materias.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        try {
            $materia = Materia::find($request->id);
            $materia->estatus = 0;
            $r = $materia->save();

            if ($r)
                $response = response()->json(['success' => 'Se ha eliminado ' . $materia->nombre]);
            else
                $response = response()->json(['error' => 'No se ha podido completar la operación']);
        } catch (ErrorException $e) {
            $response = response()->json(['error' => 'No se ha podido completar la operacion: ' . $e->getMessage()], 404);
        }
        return $response;
    }

    protected function save(Materia $materia, Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $materia->nombre = $request->nombre;
        $materia->descripcion = $request->descripcion;
        $materia->estatus =  isset($request->estatus) ? 1 : 2;
        $materia->save();

        Session::flash('success', "Success!");
        // alert()->success('Completado', 'Guardado correctamente');
        return Redirect::back();
        // return $materia;
    }

    /**
     * Change the status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'estatus' => 'required',
        ]);

        try {
            $materia = Materia::find($request->id);
            $materia->estatus =  $request->estatus == "false" ? 2 : 1;
            $r = $materia->save();
            if ($r)
                $response = response()->json(['success' => 'Se ha ' . $materia->getEstatusName() . ' ' . $materia->nombre]);
            else
                $response = response()->json(['error' => 'No se ha podido completar la operación']);
        } catch (ErrorException $e) {
            $response = response()->json(['error' => 'No se ha podido completar la operacion: ' . $e->getMessage()], 404);
        }

        return $response;
    }
}
