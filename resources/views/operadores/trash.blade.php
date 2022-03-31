@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('operadores.trash'))

@section('title', 'Operadores eliminados')

@section('content')
@endsection

@section('secondary-content')
@include('operadores.list')
@endsection
