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
        return view('materias.index', []);
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
        return view('materias.trash');
    }

    /**
     * display a listing of the resource.
     *
     * @return \illuminate\http\response
     */
    public function trashList()
    {
        return response()->json(['data' => Materia::archived()->get()]);
    }

    /**
     * update the specified resource in storage.
     *
     * @param  \app\Materia  $materia
     * @return \illuminate\http\response
     */
    public function restore(Materia $materia)
    {
        try {
            $materia->estatus = 2;
            $r = $materia->save();

            if ($r)
                $response = response()->json(['success' => 'Se ha restaurado ' . $materia->nombre]);
            else
                $response = response()->json(['error' => 'No se ha podido completar la operación']);
        } catch (ErrorException $e) {
            $response = response()->json(['error' => 'No se ha podido completar la operacion: ' . $e->getMessage()], 404);
        }
        return $response;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('materias.create', []);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->save(new Materia, $request);
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
        return $this->save($materia, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Materia $materia)
    {
        try {
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
        ]);
        $materia->nombre = $request->nombre;
        $materia->descripcion = $request->descripcion;
        $materia->estatus =  isset($request->estatus) ? 1 : 2;
        $materia->save();

        $response = response()->json(['success' => 'Se ha guardado ' . $materia->nombre]);
        return $response;
    }

    /**
     * Change the status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Materia $materia, Request $request)
    {
        $validated = $request->validate([
            'estatus' => 'required',
        ]);

        try {
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
