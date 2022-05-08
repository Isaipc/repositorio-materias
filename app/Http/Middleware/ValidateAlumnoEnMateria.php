<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class ValidateAlumnoEnMateria
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user->hasRole('Administrador'))
            return $next($request);

        if (!$user->materias->contains($request->materia))
            return redirect('/');


        return $next($request);
    }
}
