<?php

namespace App\Http\Controllers;

use App\Materia;
use Illuminate\Http\Request;

class AlumnosEnMateriaController extends Controller
{
     /**
     * display a listing of the resource.
     *
     * @return \illuminate\http\response
     */
    public function index(Materia $materia)
    {
        return view('alumnos-en-materia.index', ['item' => $materia]);
    }
}