@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('permisos.index'))

@section('title', 'Permisos del sistema')

@section('content')
<a href="{{ route('permisos.create') }}" class="btn btn-md btn-primary">
    <i class="bi bi-plus"></i>
    Nuevo permiso 
</a>
<a href="{{ route('permisos.trash') }}" class="btn btn-md btn-link">
    <i class="bi bi-trash"></i>
    Eliminados
</a>
@endsection

@section('secondary-content')
@include('permisos.list')
@endsection