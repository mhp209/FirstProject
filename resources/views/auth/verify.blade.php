@extends('front.layout.auth')

@section('content')
<div class="container">
    @if ($errors->has('code'))
        <div class="alert alert-danger">
            {{ $errors->first('code') }}
        </div>
    @endif

    <h1>Verify Code </h1>
    <form method="POST" action="{{ route('verify') }}">
        @csrf
        <label for="code">Verification Code:</label>
        <input type="text" name="code" required>
        <button type="submit">Verify</button>
    </form>
</div>
@endsection
