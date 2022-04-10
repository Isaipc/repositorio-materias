<?php

namespace App\Http\Controllers;

use App\archivo;
use App\Materia;
use App\User;
use App\Operador;
use App\Producto;
use App\Seccion;
use App\PuntoRevision;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = Auth::user();
        return view('home', [
            'materias_rep' => Materia::actives()->get(),
            'materias_alumn' => $user->materias
        ]);
    }
}
