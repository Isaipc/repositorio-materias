@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('usuarios.trash'))

@section('title', 'Usuarios eliminados')

@section('content')
@endsection

@section('secondary-content')
@include('usuarios.list')
@endsection