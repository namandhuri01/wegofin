<!-- resources/views/emi-processing/index.blade.php -->
@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>EMI Processing</h1>
        <button class="btn btn-primary mb-3" onclick="processData()">Process Data</button>

        <table class="table">
            <thead>
                <tr>
                    <th>Client ID</th>
                    @foreach ($emiDetails->first() ?? [] as $columnName => $value)
                        @if ($columnName !== 'client_id')
                            <th>{{ $columnName }}</th>
                        @endif
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($emiDetails as $detail)
                    <tr>
                        <td>{{ $detail->client_id }}</td>
                        @foreach ($detail as $columnName => $value)
                            @if ($columnName !== 'client_id')
                                <td>{{ $value }}</td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function processData() {
            window.location.href = "{{ route('emi-processing.process-data') }}";
        }
    </script>
@endsection