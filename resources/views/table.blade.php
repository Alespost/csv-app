@extends('layouts.app')

@section('content')

    @if(isset($title))
        <h1 class="pl-0">{{ $title }}</h1>
    @elseif(url()->current() === route('upload') || url()->current() === route('concat'))

        @error('save-fail')
        <div class="alert alert-danger" role="alert">
            {{ $message }}
        </div>
        @enderror

        <div class="row mb-3">

            {{-- Concat form --}}
            <div class="col">
                <form method="POST" action="{{route('concat')}}">
                    @csrf
                    <input type="hidden" value="{{ serialize($header) }}" name="header">
                    <input type="hidden" value="{{ serialize($data) }}" name="data">
                    <button class="btn btn-primary">Concat</button>
                </form>
            </div>

            {{-- Save form --}}
            <div class="col-4 mr-3">
                <form method="POST" action="{{ route('store') }}" class="row">
                    @csrf
                    <input type="hidden" value="{{ serialize($header) }}" name="header">
                    <input type="hidden" value="{{ serialize($data) }}" name="data">

                    <div class="input-group">
                        <input type="text" name="title" class="form-control" placeholder="Title" aria-label="Title" required>
                        <div class="input-group-append">
                            <button class="btn btn-success" type="submit">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
        <tr>
            @foreach($header as $item)
                <th scope="col">
                    {{$item['name']}}
                    <br>
                    <span class="normal">({{$item['type']}})</span>
                </th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($data as $line)
            <tr>
                @foreach($line as $item)
                    <td>{{ $item }}</td>
                @endforeach
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
