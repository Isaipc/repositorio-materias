<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use ErrorException;
use Illuminate\Database\Eloquent\Builder;
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
        return view('usuarios.index');
    }

    /**
     * display a listing of the resource.
     *
     * @return \illuminate\http\response
     */
    public function list()
    {
        return response()->json(['data' => User::actives()->get()]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        return view('usuarios.trash');
    }

    /**
     * display a listing of the resource.
     *
     * @return \illuminate\http\response
     */
    public function trashList()
    {
        return response()->json(['data' => User::archived()->get()]);
    }

    /**
     * update the specified resource in storage.
     *
     * @param  \app\User  $item
     * @return \illuminate\http\response
     */
    public function restore(User $user)
    {
        $user->estatus = 2;
        $user->save();

        $response = response()->json(['success' => 'Se ha restaurado ' . $user->nombre]);
        return $response;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function new()
    {
        return view('usuarios.create', [
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
            'nombre' => $request['name'],
            'username' => $request['username'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
        ])->save();

        $item->assignRole('Alumno');

        $response = response()->json(['success' => 'Se ha guardado ' . $item->nombre]);
        return $response;
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
            'nombre' => $request['name'],
            'username' => $request['username'],
            'email' => $request['email'],
        ])->save();


        $item->assignRole('Alumno');
        return redirect()->route('usuarios.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $item
     * @return \Illuminate\Http\Response
     */
    public function archive(User $user)
    {
        $user->estatus = 0;
        $user->save();

        $response = response()->json(['success' => 'Se ha eliminado ' . $user->nombre]);
        return $response;
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $item
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete();

        $response = response()->json(['success' => 'Se ha eliminado ' . $user->nombre . ' de forma permanente.']);
        return $response;
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
            'username' => ['required', 'string', 'max:50', 'unique:users'],
            'email' => ['string', 'email', 'max:50', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }
}