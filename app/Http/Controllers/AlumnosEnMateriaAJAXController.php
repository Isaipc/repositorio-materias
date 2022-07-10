<?php

namespace App\Http\Controllers;

use App\AlumnoEnMateria;
use App\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
}
