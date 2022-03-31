@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('documentos.trash'))

@section('title', 'Documentos eliminados')

@section('content')

@endsection

@section('secondary-content')
@include('documentos.list')
@endsection