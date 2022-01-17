@extends('layouts.master')

@section('header')
    @if (Route::has('login'))
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            @auth
                <a href="{{ route('wallets.index') }}" class="text-sm welcome-header-actions">Wallets</a>
            @else
                <a href="{{ route('login') }}" class="text-sm welcome-header-actions">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="ml-4 text-sm welcome-header-actions">Register</a>
                @endif
            @endauth
        </div>
    @endif
@endsection

@section('content')
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
        <div class="welcome-logo">
            <div class="welcome-logo-container">
                <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
            </div>
        </div>
    </div>
@endsection
