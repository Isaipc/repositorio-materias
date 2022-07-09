<?php

namespace App\Http\Controllers;

use App\Materia;
use App\Unidad;
use App\Constants;
use ErrorException;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UnidadController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Materia $materia)
    {
        return view('unidades.index', [
            'item' => $materia,
            'archived' => $materia->unidades()->where('estatus', config('constants.status_archived'))->get()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash(Materia $materia)
    {
        return view('unidades.trash', [ 'item' => $materia ]);
    }
}
