<?php

namespace App\Http\Controllers;

use App\Materia;
use Illuminate\Http\Request;

class AlumnoController extends Controller
{
    /**
     * display a listing of the resource.
     *
     * @return \illuminate\http\response
     */
    public function index(Materia $materia)
    {
        return view('alumnos.index', ['item' => $materia]);
    }

    /**
     * display a listing of the resource.
     *
     * @return \illuminate\http\response
     */
    public function list(Materia $materia)
    {
        return response()->json(['data' => $materia->alumnos()->where('estatus', '!=', 0)->get()]);
    }
}
