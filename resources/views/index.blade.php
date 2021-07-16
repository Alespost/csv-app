@extends('layouts.app')

@section('content')
    <h1>Stored CSVs</h1>
    @if($csvs->isNotEmpty())
        <div class="table-responsive">
            <table class="table col-md-4">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                </tr>
                </thead>
                <tbody>

                @foreach($csvs as $csv)
                    <tr>
                        <td>{{ $csv->id }}</td>
                        <td><a href="{{ route('show', [$csv->id]) }}">{{ $csv->title }}</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="alert alert-warning" role="alert">
            No CSV found.
        </div>
    @endif
@endsection
