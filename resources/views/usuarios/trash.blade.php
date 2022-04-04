@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('usuarios.trash'))

@section('title', 'Alumnos eliminados')

@section('content')
@endsection

@section('secondary-content')
@include('usuarios.list')
@endsection