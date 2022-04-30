<?php

namespace App\Http\Controllers;

use App\Materia;
use App\Unidad;
use App\Constants;
use ErrorException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UnidadController extends Controller implements Constants
{
    /**
     * display a listing of the resource.
     *
     * @return \illuminate\http\response
     */
    public function list(Materia $materia)
    {
        return response()->json([
            'data' => $materia->unidades()->where('estatus', '!=', Constants::ST_ARCHIVED)->get()
        ]);
    }

    /**
     * display a listing of the resource.
     *
     * @return \illuminate\http\response
     */
    public function archived(Materia $materia)
    {
        return response()->json([
            'data' => $materia->unidades->where('estatus', Constants::ST_ARCHIVED)
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
        return $this->save(new Unidad, $request);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unidad $unidad)
    {
        return $this->save($unidad, $request);
    }

    protected function save(Unidad $unidad, Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required',
            'materia_id' => 'required',
        ]);

        $materia = Materia::find($request->materia_id);
        $unidad->nombre = $request->nombre;
        $unidad->estatus =  isset($request->estatus) ? Constants::ST_ENABLED : Constants::ST_DISABLED;

        $materia->unidades()->save($unidad);

        $response = response()->json(['success' => 'Se ha guardado ' . $unidad->nombre]);
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
        $unidad->estatus = Constants::ST_ARCHIVED;
        $unidad->save();

        $response = response()->json(['success' => 'Se ha eliminado ' . $unidad->nombre]);
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

        $unidad->estatus =  $request->estatus == "false" ? Constants::ST_DISABLED : Constants::ST_ENABLED;
        $unidad->save();
        $response = response()->json(['success' => 'Se ha ' . $unidad->getEstatusName() . ' ' . $unidad->nombre]);

        return $response;
    }
}
