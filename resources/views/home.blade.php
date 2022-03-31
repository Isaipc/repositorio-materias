@extends('layouts.dashboard')

@section('breadcrumbs', Breadcrumbs::render('home'))

@section('title', 'Repositorio')
@section('content')
<div class="">
    <div class="row mb-4">
        <div class="col">
            @include('bienvenida')
        </div>
    </div>
</div>
@endsection
