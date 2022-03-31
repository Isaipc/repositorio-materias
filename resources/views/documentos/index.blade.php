@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('documentos.index'))

@section('title')
<span>
    Documentos
</span>
<a href="{{ route('documentos.create') }}" class="btn btn-md btn-light float-right">
    <i class="bi bi-plus"></i>
</a>
@endsection

@section('content')
<a href="{{ route('documentos.trash') }}" class="btn btn-md btn-link">
    Mostrar eliminados ({{ $deleted }})
</a>
@endsection

@section('secondary-content')
@include('documentos.list')
@endsection