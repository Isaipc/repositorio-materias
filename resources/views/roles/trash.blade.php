@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('roles.trash'))

@section('title', 'Roles eliminados')

@section('content')
@endsection

@section('secondary-content')
@include('roles.list')
@endsection