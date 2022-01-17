@extends('layouts.master')

@section('header')
    @include('wallet-app.header')
@endsection

@section('content')
    <div class="records">
        <table class="table table-striped">
            <thead>
            <tr>
                <th scope="col">Wallet</th>
                <th scope="col">Type</th>
                <th scope="col">Amount</th>
                <th scope="col">Description</th>
                <th scope="col">Date</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($records as $record)
{{--                <div class="record">--}}
{{--                    <p>Amount: {{ $record->amount }}, {{ $record->description }}</p>--}}
{{--                </div>--}}
                <tr>
                    <td>{{ $record->wallet->name }}</td>
                    <td>{{ $record->type }}</td>
                    <td>{{ $record->amount }}</td>
                    <td>{{ $record->description }}</td>
                    <td>{{ $record->created_at }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection
