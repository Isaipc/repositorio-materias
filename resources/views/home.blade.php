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
    <div class="card card-primary col-md-4 ms-2 mt-2">
        <div class="card-body text-center">
            <h5 class="card-title"> {{ $m->nombre }} </h5>
            <div class="d-flex justify-content-around mt-2">
                <a href="{{ route('archivos.index', $m)}}" class="btn btn-md btn-light">
                    <i class="bi bi-files"></i>
                    Archivos ({{ $m->archivos->count() }})
                </a>
                <a href="{{ route('materias.show', $m)}}" class="btn btn-md btn-light">
                    <i class="bi bi-people"></i>
                    Alumnos ({{ $m->alumnos->count() }})
                </a>
            </div>
        </div>
    </div>
    @endforeach
    @endhasrole

    @foreach ($materias_alumn as $m)
    <div class="card card-primary col-md-4 ms-2 mt-2">
        <div class="card-body text-center" >
            <h5 class="card-title"> {{ $m->nombre }} </h5>

            <a href="{{ route('materias.show', $m)}}" class="btn btn-md btn-light">
                <i class="bi bi-files"></i>
                Archivos ({{ $m->archivos->count() }})
            </a>
        </div>
    </div>

    @endforeach


</div>
@endsection