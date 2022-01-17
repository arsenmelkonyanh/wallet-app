@extends('layouts.master')

@section('header')
    @include('wallet-app.header')
@endsection

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h1 class="form-title">Create Record</h1>

                    <form method="POST" action="{{ route('records.store') }}" id="createRecordForm">
                        <div class="row">
                            <div class="create-field">
                                <label for="from" id="fromLabelIsNotTransfer">Select wallet</label>
                                @if ($walletsCount > 1)
                                    <label for="from" id="fromLabelIsTransfer" class="is--hidden">From wallet</label>
                                @endif
                                <select id="from" name="from" class="f_wallet-select f_from-select" required>
                                    <option value="0" selected disabled>Select wallet</option>
                                    @foreach ($wallets as $wallet)
                                        <option value="{{ $wallet->id }}" class="f_from-wallet">{{ $wallet->name }}: {{ number_format($wallet->amount, 2, ',', '') }}</option>
                                    @endforeach
                                </select>
                                <p class="error-message f_error-message"></p>
                            </div>
                            @if ($walletsCount > 1)
                                <div class="create-field transfer-to-another">
                                    <input id="isTransfer" type="checkbox" name="isTransfer" value="1">
                                    <label for="isTransfer">Transfer to another wallet</label>
                                </div>
                            @endif
                        </div>
                        @if ($walletsCount > 1)
                            <div class="create-field is--hidden" id="toFieldContainer">
                                <label for="to">To wallet</label>
                                <select id="to" name="to" class="f_wallet-select f_to-select" disabled>
                                    <option value="0" selected disabled>Select wallet</option>
                                    @foreach ($wallets as $wallet)
                                        <option value="{{ $wallet->id }}" class="f_to-wallet">{{ $wallet->name }}: {{ number_format($wallet->amount, 2, ',', '') }}</option>
                                    @endforeach
                                </select>
                                <p class="error-message f_error-message"></p>
                            </div>
                        @endif
                        <div class="create-field" id="typeFieldContainer">
                            <label for="type">Record type</label>
                            <select id="type" name="type" class="f_type-select" required>
                                <option value="0" selected disabled>Record type</option>
                                <option value="credit">Credit</option>
                                <option value="debit">Debit</option>
                            </select>
                            <p class="error-message f_error-message"></p>
                        </div>
                        <div class="create-field">
                            <label for="description">Description</label>
                            <input id="description" name="description" type="text" required>
                            <p class="error-message f_error-message"></p>
                        </div>
                        <div class="create-field">
                            <label for="amount">Amount</label>
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

