@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('usuarios.index'))

@section('primary-title', __('Usuarios'))
@section('primary-content')
    
@endsection

@section('secondary-content')
@include('usuarios.list')
@endsection
