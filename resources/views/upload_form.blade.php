@extends('layouts.app')

@section('content')
    <div class="col-4 offset-4">
        <form method="POST" action="{{ route('csv-parse') }}" enctype="multipart/form-data">
            @csrf

            {{-- File input --}}
            <div class="mb-3">
                <label for="csv" class="form-label">Choose CSV File</label>
                <input class="form-control" type="file" accept="text/csv" id="csv" name="csv">

                @error('csv')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                <script>
                    document.getElementById('csv').classList.add('is-invalid');
                </script>
                @enderror
            </div>

            {{-- Separator Select --}}
            <div class="mb-3">
                <select class="custom-select" aria-label="Separator" name="separator" id="separator">
                    <option @if( !old('separator') || old('separator') === ',' ) selected @endif value=",">Comma (,)
                    </option>
                    <option @if( old('separator') === ';' ) selected @endif value=";">Semicolon (;)</option>
                </select>
                @error('separator')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                <script>
                    document.getElementById('separator').classList.add('is-invalid');
                </script>
                @enderror
            </div>

            {{-- Submit button --}}
            <div class="mb-3">
                <button class="btn btn-primary" type="submit">Parse</button>
            </div>
        </form>
    </div>
@endsection
