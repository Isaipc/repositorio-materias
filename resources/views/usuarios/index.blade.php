@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('usuarios.index'))

@section('title')
<span>
    Usuarios del sistema
</span>
<a href="{{ route('usuarios.create') }}" class="btn btn-md btn-light float-right">
    <i class="bi bi-plus"></i>
</a>
@endsection

@section('content')
<a href="{{ route('usuarios.trash') }}" class="btn btn-md btn-link">
    Mostrar eliminados ({{ $deleted }})
</a>
@endsection

@section('secondary-content')
@include('usuarios.list')
@endsection