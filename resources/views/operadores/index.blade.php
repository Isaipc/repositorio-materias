@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('operadores.index'))

@section('title', 'Catálogo de operadores')

@section('content')
<a href="{{ route('operadores.create') }}" class="btn btn-md btn-success">
    <i class="bi bi-plus"></i>
    Nuevo operador
</a>
<a href="{{ route('operadores.trash') }}" class="btn btn-md btn-link">
    <i class="bi bi-trash"></i>
    Eliminados
</a>
@endsection

@section('secondary-content')
@include('operadores.list')
@endsection
