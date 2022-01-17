@extends('layouts.master')

@section('header')
    @include('wallet-app.header')
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="form-title">Create Wallet</h1>

                    <form method="POST" action="{{ route('wallets.store') }}" id="createWalletForm">
                        <div class="create-field">
                            <label for="name">Wallet name</label>
                            <input id="name" name="name" type="text" required>
                            <p class="error-message f_error-message"></p>
                        </div>
                        <div class="create-field">
                            <label for="type">Wallet type</label>
                            <select id="type" name="type" required>
                                <option value="0" selected disabled>Choose type</option>
                                @foreach ($walletTypes as $walletType)
                                    <option value="{{ $walletType->id }}">{{ $walletType->name }}</option>
                                @endforeach
                            </select>
                            <p class="error-message f_error-message"></p>
                        </div>
                        <div class="create-field">
                            <label for="color">Wallet color</label>
                            <input id="color" name="color" type="color">
                            <p class="error-message f_error-message"></p>
                        </div>
                        <div class="create-field">
                            <label for="amount">Current amount</label>
                            <input id="amount" name="amount" type="text" required>
                            <p class="error-message f_error-message"></p>
                        </div>
                        <div class="create-field">
                            <button class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150" type="submit">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

