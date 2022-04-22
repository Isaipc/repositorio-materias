@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('materias.index'))

@section('primary-title')
<i class="bi bi-collection-fill"></i>
{{__('Materias')}}
@endsection

@section('primary-content')
{{-- @include('materias.list') --}}
@endsection

@section('secondary-content')
@include('materias.list')
@endsection