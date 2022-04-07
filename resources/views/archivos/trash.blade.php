@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('archivos.trash', $materia))

@section('title', 'Archivos eliminados - ' . $materia->nombre)

@section('content')

@endsection

@section('secondary-content')
@include('archivos.list')
@endsection