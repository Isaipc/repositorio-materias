<?php

namespace App\Http\Controllers;

use App\Materia;
use App\Unidad;
use Illuminate\Http\Request;

class UnidadAJAXController extends Controller
{
    /**
     * display a listing of the resource.
     *
     * @return \illuminate\http\response
     */
    public function index(Materia $materia)
    {
        return response()->json(['data' => $materia->unidades()->where('estatus', '!=', config('constants.status_archived'))->get()]);
    }

    /**
     * display a listing of the resource.
     *
     * @return \illuminate\http\response
     */
    public function trash(Materia $materia)
    {
        return response()->json(['data' => $materia->unidades()->where('estatus', config('constants.status_archived'))->get()]);
    }

    /**
     * update the specified resource in storage.
     *
     * @param  \app\Unidad  $unidad
     * @return \illuminate\http\response
     */
    public function restore(Unidad $unidad)
    {
        $unidad->estatus = 2;
        $unidad->save();

        $response = response()->json(['success' => 'Se ha restaurado ' . $unidad->nombre]);
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|unique:unidades',
        ]);
        return $this->save(new Unidad, $request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Unidad  $unidad
     * @return \Illuminate\Http\Response
     */
    public function edit(Unidad $unidad)
    {
        return view('materias.edit', [
            'item' => $unidad,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unidad  $unidad
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unidad $unidad)
    {
        $validated = $request->validate([
            'nombre' => 'required',
        ]);
        return $this->save($unidad, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unidad  $unidad
     * @return \Illuminate\Http\Response
     */
    public function archive(Unidad $unidad)
    {
        $unidad->estatus = 0;
        $unidad->save();

        $response = response()->json(['success' => 'Se ha eliminado ' . $unidad->nombre]);
        return $response;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unidad  $unidad
     * @return \Illuminate\Http\Response
     */
    public function destroy(Unidad $unidad)
    {
        $unidad->delete();

        $response = response()->json(['success' => 'Se ha eliminado ' . $unidad->nombre]);
        return $response;
    }

    protected function save(Unidad $unidad, Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required',
            'materia_id' => 'required',
        ]);

        $materia = Materia::find($request->materia_id);
        $unidad->nombre = $request->nombre;
        $unidad->estatus = isset($request->estatus) ? config('constants.status_enabled') : config('constants.status_disabled');

        $materia->unidades()->save($unidad);

        $response = response()->json(['success' => 'Se ha guardado ' . $unidad->nombre]);
        return $response;
    }

    /**
     * Change the status.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Unidad  $unidad
     * @return \Illuminate\Http\Response
     */
    public function changeStatus(Unidad $unidad, Request $request)
    {
        $validated = $request->validate([
            'estatus' => 'required',
        ]);

        $unidad->estatus =  $request->estatus == "false" ? config('constants.status_disabled') : config('constants.status_enabled');
        $unidad->save();
        $response = response()->json(['success' => 'Se ha ' . $unidad->getEstatusName() . ' ' . $unidad->nombre]);
        return $response;
    }
}
