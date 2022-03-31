@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('permisos.trash'))

@section('title', 'Permisos eliminados')

@section('content')
@endsection

@section('secondary-content')
@include('permisos.list')
@endsection