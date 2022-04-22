@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('materias.index'))

@section('primary-title', __('Materias'))

@section('primary-content')
{{-- @include('materias.list') --}}
@endsection

@section('secondary-content')
@include('materias.list')
@endsection