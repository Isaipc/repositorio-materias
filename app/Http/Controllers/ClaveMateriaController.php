<?php

namespace App\Http\Controllers;

use App\AlumnoEnMateria;
use App\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClaveMateriaController extends Controller
{
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

        $user = Auth::user();
        $materia = Materia::where('clave', $request->clave)->first();

        if ($materia == null)
            return response()->json(['error' => 'Clave incorrecta, no se encuentra asociada a ninguna materia.']);

        $alumnoEnMateria = AlumnoEnMateria::where('usuario_id', $user->id)
            ->where('materia_id', $materia->id);

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

        return response()->json(['success' => 'Se ha dado de baja en ' . $materia->nombre]);
    }
}
