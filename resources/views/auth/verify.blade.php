@extends('layouts.dashboard')

@section('primary-title')
    {{ __('Verify Your Email Address') }}
@endsection

@section('primary-content')
    <div class="col-md-6 mx-auto">
        @if (session('resent'))
            <div class="alert alert-success" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        {{ __('Before proceeding, please check your email for a verification link.') }}
        {{ __('If you did not receive the email') }},
        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <button type="submit"
                class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
        </form>
    </div>
@endsection
