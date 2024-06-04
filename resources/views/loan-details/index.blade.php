@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Loan Details</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Client ID</th>
                    <th>Number of Payments</th>
                    <th>First Payment Date</th>
                    <th>Last Payment Date</th>
                    <th>Loan Amount</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($loanDetails as $detail)
                    <tr>
                        <td>{{ $detail->client_id }}</td>
                        <td>{{ $detail->num_of_payments }}</td>
                        <td>{{ $detail->first_payment_date }}</td>
                        <td>{{ $detail->last_payment_date }}</td>
                        <td>{{ $detail->loan_amount }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection