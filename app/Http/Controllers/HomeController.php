<?php

namespace App\Http\Controllers;

use App\Materia;
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
        $materias = Materia::actives()->get();

        return view('home', [
            'materias' => $user->hasRole('Administrador') ?
                $materias : $user->materias->where('estatus', config('constants.status_enabled'))
        ]);
    }
}
