@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('materias.index'))

@section('title')
Materias
@can('materias-nuevo')
<a href="{{ route('materias.create') }}" class="btn btn-md btn-light float-right">
    <i class="bi bi-plus"></i>
</a>
@endcan
@endsection

@section('content')
<a href="{{ route('materias.trash') }}" class="btn btn-md btn-link">
    Mostrar eliminados ({{ $deleted }})
</a>
@endsection

@section('secondary-content')
@include('materias.list')
@endsection