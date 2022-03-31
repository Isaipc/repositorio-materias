<?php

namespace App\Http\Controllers;

use App\CarritoDeCompras;
use App\Categoria;
use App\Documento;
use App\Image;
use App\DocumentoImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DocumentoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('documentos.index', [
            'rows' => $this->actives(),
            'deleted' => $this->deleted()->count()

        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('documentos.create', [
            'Materias' => Categoria::orderBy('nombre', 'ASC')->where('estatus', 1)->get(),
            'rows' => Documento::orderBy('nombre', 'ASC')->where('estatus', 1)->get(),
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function trash()
    {
        return view('documentos.trash', [
            'rows' => Documento::orderBy('nombre', 'ASC')->where('estatus', 0)->get(),
        ]);
    }

    /**
     * update the specified resource in storage.
     *
     * @param  \app\documento  $documento
     * @return \illuminate\http\response
     */
    public function restore(Documento $documento)
    {
        $documento->estatus = 1;
        $documento->save();

        alert()->success('Completado', 'Elemento restaurado');

        return redirect()->route('documentos.index');
    }

    protected function save(Documento $item, Request $request)
    {
        // dd($request);
        $request->validate([
            'nombre' => 'required',
            'categoria' => 'required',
            'stock' => 'required',
            'precio_menudeo' => 'required',
            'precio_mayoreo' => 'required',
            'detalles' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);


        $item->nombre = mb_strtoupper($request->nombre, 'UTF-8');
        $item->categoria_id = $request->categoria;
        $item->precio_menudeo = $request->precio_menudeo;
        $item->precio_mayoreo = $request->precio_mayoreo;
        $item->stock = $request->stock;
        $item->detalles = $request->detalles;
        $item->save();

        // if ($request->hasFile('image')) {
        //     if (!$request->file('image')->isValid())
        //         abort(500, 'Could not upload image :(');
        //     $img = Image::store($request->image);
        //     DocumentoImage::replace($item->id, $img->id);
        // }

        alert()->success('Completado', 'Guardado correctamente');
        return $item;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $documento = new Documento;
        $this->save($documento, $request);

        return redirect()->route('documentos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function show(Documento $documento)
    {
        return view('documentos.show', ['item' => $documento]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function edit(Documento $documento)
    {
        return view('documentos.edit', [
            'Materias' => Categoria::orderBy('nombre', 'ASC')->where('estatus', 1)->get(),
            'rows' => Documento::orderBy('nombre', 'ASC')->where('estatus', 1)->get(),
            'item' => $documento
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Documento $documento)
    {
        $this->save($documento, $request);

        return redirect()->route('documentos.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Documento  $documento
     * @return \Illuminate\Http\Response
     */
    public function destroy(Documento $documento)
    {
        $documento->estatus = 0;
        $documento->save();

        alert()->success('Completado', 'Eliminado correctamente');

        return redirect()->route('documentos.index');
    }

    public function mostrarTodo(Categoria $categoria)
    {
        $categorias = Categoria::where('estatus', 1)->get();
        $documentos = Documento::where('estatus', 1)->get();

        return view('tienda.index', [
            '_categoria' => $categoria,
            'Materias' => $categorias,
            'documentos' => $documentos
        ]);
    }

    public function mostrarPorCategoria(Categoria $categoria)
    {
        $categorias = Categoria::where('estatus', 1)->get();
        $documentos = Documento::where('estatus', 1)->where('categoria_id', $categoria->id)->get();
        return view(
            'tienda.index',
            [
                '_categoria' => $categoria,
                'Materias' => $categorias,
                'documentos' => $documentos,
            ]
        );
    }

    public function mostrarDocumento(Documento $documento)
    {
        $categorias = Categoria::where('estatus', 1)->get();

        return view(
            'documentos.show-tienda',
            [
                '_categoria' => $documento->categoria,
                'Materias' => $categorias,
                'documento' => $documento
            ]
        );
    }

    public function actives()
    {
        return Documento::where('estatus', '!=', 0)->orderBy('nombre', 'ASC')->get();
    }

    public function deleted()
    {

        return Documento::where('estatus', 0)->orderBy('nombre', 'ASC')->get();
    }
}
