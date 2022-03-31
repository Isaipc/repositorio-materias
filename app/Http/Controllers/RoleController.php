<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('roles.index', [
            'rows' => Role::where('estatus', 1)->orderBy('name', 'ASC')->get(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        return view('roles.trash', [
            'rows' => Role::where('estatus', 0)->orderBy('name', 'ASC')->get(),
        ]);
    }

    /**
     * update the specified resource in storage.
     *
     * @param  \app\Role  $role
     * @return \illuminate\http\response
     */
    public function restore(Role $role)
    {
        $role->estatus = 1;
        $role->save();

        alert()->success('Completado', 'Elemento restaurado');

        return redirect()->route('roles.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('roles.create', [
            'rows' => Role::where('estatus', 1)->orderBy('name', 'ASC')->get(),
            'permisos' => Permission::where('estatus', 1)->orderBy('name', 'ASC')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->save(new Role, $request);
        return redirect()->route('roles.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return view('roles.show', [
            'item' => $role,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        return view('roles.edit', [
            'rows' => Role::where('estatus', 1)->orderBy('name', 'ASC')->get(),
            'permisos' => Permission::where('estatus', 1)->orderBy('name', 'ASC')->get(),
            'item' => $role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Role $role)
    {
        $this->save($role, $request);
        return redirect()->route('roles.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        $role->estatus = 0;
        $role->save();

        alert()->success('Completado', 'Eliminado correctamente');

        return redirect()->route('roles.index');
    }

    protected function save(Role $role, Request $request)
    {
        $request->validate([
            'name' => 'required',
            'permisos' => 'required',
        ]);

        $role->name = $request->name;
        $role->syncPermissions($request->permisos);
        $role->save();

        alert()->success('Completado', 'Guardado correctamente');
        return $role;
    }
}
