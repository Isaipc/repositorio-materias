<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AlumnoEnMateriaController extends Controller
{
    /**
     * display a listing of the resource.
     *
     * @return \illuminate\http\response
     */
    public function index()
    {
        $user = Auth::user();
        return response()->json([
            'materias' => $user->materias()->where('estatus', '!=', config('constants.status_archived'))->get()
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
        $validated = $request->validate([
            'clave' => 'required'
        ]);

        $materia = Materia::where('clave', $request->clave)->first();
        if ($materia == null)
            return response()->json(['error' => 'Clave incorrecta, no se encuentra asociada a ninguna materia.']);

        Auth::user()->materias()->attach($materia->id);
        return response()->json(['success' => 'Usted ha sido registrado en ' . $materia->nombre]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Materia $materia)
    {
        Auth::user()->materias()->detach($materia->id);

        $response = response()->json(['success' => 'Se ha dado de baja en ' . $materia->nombre]);
        return $response;
    }
}
