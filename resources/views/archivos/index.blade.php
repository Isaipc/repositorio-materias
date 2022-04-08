@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('archivos.index', $materia))

@section('title')
<span>
    Archivos -
</span>
<span class="font-weight-semibold"> {{ $materia->nombre }} </span>
<a href="{{ route('archivos.create', $materia) }}" class="btn btn-md btn-light float-end">
    <i class="bi bi-plus"></i>
</a>
@endsection

@section('content')
<a href="{{ route('archivos.trash', $materia) }}" class="btn btn-md btn-link">
    Mostrar eliminados ({{ $deleted }})
</a>
@endsection

@section('secondary-content')
@include('archivos.list')
@endsection