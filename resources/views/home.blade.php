@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('home'))

@section('title')
@hasrole('Administrador')
Repositorio
@endhasrole
@hasrole('Alumno')
Mis materias
@endhasrole

@endsection
@section('content')
<div class="d-flex flex-wrap justify-content-center">
    @hasrole('Administrador')
    @foreach ($materias_rep as $m)
    <div class="card card-primary col-md-4 mr-2 mt-2">
        <div class="card-body">
            <h5 class="card-title"> {{ $m->nombre }} </h5>

            <div class="card-text">
                No. alumnos: {{ $m->alumnos->count() }}
            </div>

            <div class="d-flex">
                <a href="{{ route('archivos.index', $m)}}" class="btn btn-sm btn-link">
                    <i class="bi bi-files"></i>
                    Mostrar archivos
                </a>
                <a href="{{ route('archivos.index', $m)}}" class="btn btn-sm btn-primary">
                    <i class="bi bi-people"></i>
                    Mostrar alumnos
                </a>
            </div>
        </div>
    </div>
    @endforeach
    @endhasrole

    @foreach ($materias_alumn as $m)
    <div class="card card-primary col-md-4 mr-2 mt-2">
        <div class="card-body">
            <h5 class="card-title"> {{ $m->nombre }} </h5>
            <div class="card-text">
                No. archivos: {{ $m->archivos->count() }}
            </div>

            <div class="row">
                <a href="{{ route('materias.show', $m)}}" class="btn btn-sm btn-link">
                    <i class="bi bi-files"></i>
                    Mostrar archivos
                </a>
            </div>
        </div>
    </div>

    @endforeach


</div>
@endsection