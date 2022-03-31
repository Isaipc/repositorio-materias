@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('roles.index'))

@section('title', 'Roles del sistema')

@section('content')
<a href="{{ route('roles.create') }}" class="btn btn-md btn-primary">
    <i class="bi bi-plus"></i>
    Nuevo rol 
</a>
<a href="{{ route('roles.trash') }}" class="btn btn-md btn-link">
    <i class="bi bi-trash"></i>
    Eliminados
</a>
@endsection

@section('secondary-content')
@include('roles.list')
@endsection