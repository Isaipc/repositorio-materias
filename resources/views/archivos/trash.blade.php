@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('archivos.trash'))

@section('title', 'archivos eliminados')

@section('content')

@endsection

@section('secondary-content')
@include('archivos.list')
@endsection