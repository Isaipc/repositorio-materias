@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('usuarios.index'))

@section('primary-title')
    <i class="bi bi-people-fill"></i>
    {{ __('Usuarios') }}
@endsection


@section('primary-content')

@endsection

@section('secondary-content')
    @include('usuarios.list')
@endsection
