<?php

namespace App\Http\Controllers;

use App\AlumnoEnMateria;
use App\Materia;
use App\User;

class AlumnosEnMateriaAJAXController extends Controller
{
    /**
     * display a listing of the resource.
     *
     * @return \illuminate\http\response
     */
    public function index(Materia $materia)
    {
        return response()->json(['data' => $materia->alumnos()->where('estatus', '!=', config('constants.status_archived'))->get()]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Materia $materia, User $user)
    {
        $materia->alumnos()->detach($user->id);
        
        return response()->json(['success' => 'El alumno ' . $user->nombre . ' ya no es participe del curso:' . $materia->nombre]);
    }
    
    /**
     * Remove all students related with this subject 
     *
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function closeCourse(Materia $materia)
    {
        $materia->alumnos()->detach();

        $response = response()->json(['success' => 'El curso ' . $materia->nombre . ' ha sido cerrado']);
        return $response;
    }


}
