@extends('layouts.app')

@section('frame')

    @include('navbar')

    <main class="py-2">
        <div class="container">
            <div class="mt-3">
                @yield('breadcrumbs')
            </div>

            <div class="card mt-3 shadow-sm">
                <div class="card-header bg-light text-center text-uppercase">
                    @yield('primary-title')
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
                    @yield('primary-content')
                </div>
            </div>
        </div>
    </main>
@endsection
