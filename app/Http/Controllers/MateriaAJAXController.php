<?php

namespace App\Http\Controllers;

use App\Materia;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MateriaAJAXController extends Controller
{
    /**
     * display a listing of the resource.
     *
     * @return \illuminate\http\response
     */
    public function index()
    {
        return response()->json(['data' => Materia::actives()->get()]);
    }

    /**
     * display a listing of the resource.
     *
     * @return \illuminate\http\response
     */
    public function trash()
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
        $materia->estatus = 2;
        $materia->save();

        $response = response()->json(['success' => 'Se ha restaurado ' . $materia->nombre]);
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
            'nombre' => 'required|unique:materias',
            'clave' => 'required|unique:materias'
        ]);
        return $this->save(new Materia, $request);
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
        $validated = $request->validate([
            'nombre' => 'required',
            'clave' => ['required' , Rule::unique('materias')->ignore($materia)]
        ]);
        return $this->save($materia, $request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function archive(Materia $materia)
    {
        $materia->estatus = 0;
        $materia->save();

        $response = response()->json(['success' => 'Se ha eliminado ' . $materia->nombre]);
        return $response;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Materia $materia)
    {
        $materia->delete();

        $response = response()->json(['success' => 'Se ha eliminado ' . $materia->nombre]);
        return $response;
    }

    protected function save(Materia $materia, Request $request)
    {
        $materia->nombre = $request->nombre;
        $materia->descripcion = $request->descripcion;
        $materia->estatus =  isset($request->estatus) ? 1 : 2;
        $materia->clave = $request->clave;
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

        $materia->estatus =  $request->estatus == "false" ? 2 : 1;
        $materia->save();
        $response = response()->json(['success' => 'Se ha ' . $materia->getEstatusName() . ' ' . $materia->nombre]);
        return $response;
    }
}
