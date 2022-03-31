<?php

namespace App\Http\Controllers;

use App\Documento;
use App\User;
use App\Operador;
use App\Producto;
use App\Seccion;
use App\PuntoRevision;
use Illuminate\Http\Request;

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
        return view('home', [
            'usuarios' => User::all()->count(),
            'clientes' => '',
            'documentos' => Documento::where('estatus', 1)->count(),
            'servicios' => ''
        ]);
    }
}
