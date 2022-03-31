@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('materias.trash'))

@section('title', 'Materias eliminadas')

@section('content')
@endsection

@section('secondary-content')
@include('materias.list')
@endsection