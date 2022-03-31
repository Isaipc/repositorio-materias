<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('permisos.index', [
            'rows' => Permission::where('estatus', 1)->orderBy('name', 'ASC')->get(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        return view('permisos.trash', [
            'rows' => Permission::where('estatus', 0)->orderBy('name', 'ASC')->get(),
        ]);
    }

    /**
     * update the specified resource in storage.
     *
     * @param  \app\Permission  $permiso
     * @return \illuminate\http\response
     */
    public function restore(Permission $permiso)
    {
        $permiso->estatus = 1;
        $permiso->save();

        alert()->success('Completado', 'Elemento restaurado');

        return redirect()->route('permisos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('permisos.create', [
            'rows' => Permission::where('estatus', 1)->orderBy('name', 'ASC')->get(),
            'roles' => Role::where('estatus', 1)->orderBy('name', 'ASC')->get(),
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
        $this->save(new Permission, $request);
        return redirect()->route('permisos.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Permission  $permiso
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permiso)
    {
        return view('permisos.show', ['item' => $permiso]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Permission  $permiso
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permiso)
    {
        return view('permisos.edit', [
            'rows' => Permission::where('estatus', 1)->orderBy('name', 'ASC')->get(),
            'item' => $permiso,
            'roles' => Role::where('estatus', 1)->orderBy('name', 'ASC')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Permission  $permiso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Permission $permiso)
    {
        $this->save($permiso, $request);
        return redirect()->route('permisos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Permission  $permiso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permiso)
    {
        $permiso->estatus = 0;
        $permiso->save();

        alert()->success('Completado', 'Eliminado correctamente');

        return redirect()->route('permisos.index');
    }

    protected function save(Permission $permiso, Request $request)
    {
        $request->validate([
            'name' => 'required',
            // 'roles' => 'required'
        ]);

        $permiso->name = $request->name;
        $permiso->syncRoles($request->roles);
        $permiso->save();

        alert()->success('Completado', 'Guardado correctamente');
        return $permiso;
    }
}
