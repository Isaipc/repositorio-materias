<?php

namespace App\Http\Controllers;

use App\Materia;
use App\MateriaImage;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class MateriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('materias.index', [
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
        return view('materias.trash', [
            'rows' => $this->deleted(),
        ]);
    }

    /**
     * update the specified resource in storage.
     *
     * @param  \app\Materia  $materia
     * @return \illuminate\http\response
     */
    public function restore(Materia $materia)
    {
        $materia->estatus = 2;
        $materia->save();

        // alert()->success('Completado', 'Elemento restaurado');

        return redirect()->route('materias.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('materias.create', [
            'rows' => $this->actives(),
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
        $this->save(new Materia, $request);
        return redirect()->route('materias.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function show(Materia $materia)
    {
        return view('materias.show', [
            'rows' => $this->actives(),
            'item' => $materia
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function edit(Materia $materia)
    {
        return view('materias.edit', [
            'rows' => $this->actives(),
            'item' => $materia,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Materia $materia)
    {
        $this->save($materia, $request);
        return redirect()->route('materias.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Materia  $materia
     * @return \Illuminate\Http\Response
     */
    public function destroy(Materia $materia)
    {
        $materia->estatus = 0;
        $materia->save();

        // alert()->success('Completado', 'Eliminado correctamente');

        return redirect()->route('materias.index');
    }

    protected function save(Materia $materia, Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $materia->nombre = $request->nombre;
        $materia->descripcion = $request->descripcion;
        $materia->estatus =  isset($request->estatus) ? 1 : 2;
        $materia->save();

        Session::flash('success', "Success!");
        // alert()->success('Completado', 'Guardado correctamente');
        return Redirect::back();
        // return $materia;
    }

    public function actives()
    {
        return Materia::where('estatus', '!=', 0)->orderBy('nombre', 'ASC')->get();
    }

    public function deleted()
    {

        return Materia::where('estatus', 0)->orderBy('nombre', 'ASC')->get();
    }
}
