@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('archivos.index'))

@section('title')
<span>
    archivos
</span>
<a href="{{ route('archivos.create') }}" class="btn btn-md btn-light float-right">
    <i class="bi bi-plus"></i>
</a>
@endsection

@section('content')
@endsection

@section('secondary-content')
@include('archivos.list')
@endsection