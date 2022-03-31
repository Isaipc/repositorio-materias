@extends('layouts.app')


@section('frame')
<div class="container">
    @yield('breadcrumbs')
    @yield('nav')

    <div class="container">
        @yield('content')
        @yield('secondary-content')
    </div>
</div>
@endsection