@extends('layouts.master')

@section('header')
    @include('wallet-app.header')
@endsection

@section('content')
    <h1 class="total-balance">Total balance: {{ number_format($walletsTotal, 2, ',', '') }}</h1>
    <div class="wallets">
        @foreach ($wallets as $wallet)
            <div class="wallet" style="background-color: {{ $wallet->color }}">
                <p>{{ $wallet->name }}</p>
                <p>Type: {{ $wallet->wallet_type->name }}</p>
                <p>Balance: {{ number_format($wallet->amount, 2, ',', '') }}</p>
                <button class="f_delete-wallet delete-wallet" type="button" data-action="{{ route('wallets.destroy', ['wallet' => $wallet->id]) }}">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="#000000" viewBox="0 0 48 48" width="48px" height="48px"><path d="M 20.5 4 A 1.50015 1.50015 0 0 0 19.066406 6 L 14.640625 6 C 12.796625 6 11.086453 6.9162188 10.064453 8.4492188 L 7.6972656 12 L 7.5 12 A 1.50015 1.50015 0 1 0 7.5 15 L 40.5 15 A 1.50015 1.50015 0 1 0 40.5 12 L 40.302734 12 L 37.935547 8.4492188 C 36.913547 6.9162187 35.202375 6 33.359375 6 L 28.933594 6 A 1.50015 1.50015 0 0 0 27.5 4 L 20.5 4 z M 8.9726562 18 L 11.125 38.085938 C 11.425 40.887937 13.77575 43 16.59375 43 L 31.40625 43 C 34.22325 43 36.574 40.887938 36.875 38.085938 L 39.027344 18 L 8.9726562 18 z"/></svg>
                </button>
            </div>
        @endforeach
    </div>
@endsection
