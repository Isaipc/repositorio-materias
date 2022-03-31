@extends('layouts.app')

@section('frame')

@include('navbar')

<main class="py-2">
    <div class="container">
        <div class="mt-3">
            @yield('breadcrumbs')
        </div>
        <div class="card mt-3">
            <div class="card-header bg-primary text-white">
                <h5>
                    @yield('title')
                </h5>
            </div>
            <div class="card-body container">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @yield('content')
            </div>
        </div>
        @yield('secondary-content')
    </div>
</main>
@endsection