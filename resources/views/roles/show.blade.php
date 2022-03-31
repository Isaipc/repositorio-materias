@extends('layouts.dashboard')

@section('title', 'Detalles de rol: ' . $item->name)

@section('content')
<table class="table table-stripped table-sm">
    <tbody>
        <tr>
            <th>Nombre</th>
            <td> {{ $item->name }} </td>
        </tr>
        <tr>
            <th>Estatus</th>
            <td> {{ $item->estatus ? 'Activo' : 'Inactivo'}} </td>
        </tr>
        <tr>
            <th>Fecha de creación</th>
            <td> {{ $item->created_at }} </td>
        </tr>
        <tr>
            <th>Fecha de ultima actualización</th>
            <td> {{ $item->updated_at }} </td>
        </tr>
        <tr>
            <th>Permisos asociados</th>
            <td>
                <div class="row">
                    @foreach ($item->permissions as $p)
                    <span class="col-md-12 col-lg-4">
                        <li>
                            <a href="{{ route('permisos.show', $p->id )}}">
                                {{ $p->name }}
                            </a>
                        </li>
                    </span>
                    @endforeach
                </div>
            </td>
        </tr>
    </tbody>
</table>
@endsection