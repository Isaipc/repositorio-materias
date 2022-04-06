<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('usuarios.index', [
            'rows' => $this->actives(),
            'deleted' => $this->deleted()->count()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        return view('usuarios.trash', [
            'rows' => $this->deleted(),
        ]);
    }

    /**
     * update the specified resource in storage.
     *
     * @param  \app\User  $user
     * @return \illuminate\http\response
     */
    public function restore(User $user)
    {
        $user->estatus = 1;
        $user->save();

        alert()->success('Completado', 'Elemento restaurado');

        return redirect()->route('usuarios.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new()
    {
        return view('usuarios.create', [
            'rows' => $this->actives(),
            'roles' => Role::all(),
        ]);
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $item = new User;
        $item->fill([
            'name' => $request['name'],
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ])->save();

        $item->syncRoles($request->roles);

        alert()->success('Completado', 'Guardado correctamente');

        return redirect()->route('usuarios.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('usuarios.show', [
            'rows' => $this->actives(),
            'item' => $user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('usuarios.edit', [
            'rows' => $this->actives(),
            'item' => $user,
            'roles' => Role::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $item = $user;
        $item->fill([
            'name' => $request['name'],
            'username' => $request['username'],
            'email' => $request['email'],
        ])->save();


        $item->syncRoles($request->roles);

        alert()->success('Completado', 'Guardado correctamente');

        return redirect()->route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->estatus = 0;
        $user->save();

        alert()->success('Completado', 'Eliminado correctamente');

        return redirect()->route('usuarios.index');
    }

    public function editPassword(User $user)
    {
        return view('usuarios.password-edit', [
            'rows' => User::orderBy('name', 'ASC')->where('estatus', 1)->get(),
            'item' => $user,
        ]);
    }

    public function resetPassword(User $user, Request $request)
    {
        $request->validate(['password' => 'required|string|confirmed|min:8']);

        $user->password = Hash::make($request['password']);
        $user->save();

        alert()->success('Completado', 'Contraseña restablecida');

        return redirect()->route('usuarios.index');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:50'],
            'username' => ['required', 'string', 'max:50'],
            // 'email' => ['string', 'email', 'max:50', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'roles' => ['required'],
        ]);
    }

    public function actives()
    {
        return User::where('estatus', '!=', 0)->orderBy('name', 'ASC')->get();
    }

    public function deleted()
    {

        return User::where('estatus', 0)->orderBy('name', 'ASC')->get();
    }
}
