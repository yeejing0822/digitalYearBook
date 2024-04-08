@extends('templates.main')

@section('content')
    <h1>Sign In</h1>

<form method="post" action="{{ route('login') }}">
    @csrf
  <div class="form-group">
    <label for="email">Email address</label>
    <input name="email" type="email" class="form-control @error('email') is-invalid @enderror" id="email" aria-describedby="email" value="{{ old('email') }}">
    @error('email')
        <span class="invalid-feedback" role="alert">
            {{ $message }}
        </span>
    @enderror
  </div>
  <div class="form-group">
    <label for="password">Password</label>
    <input name="password" type="password" class="form-control @error('password') is-invalid @enderror" id="password">
    @error('password')
        <span class="invalid-feedback" role="alert">
            {{ $message }}
        </span>
    @enderror
  </div>
  <br>
  <button type="submit" class="btn btn-primary">Sign in</button>
</form>
@endsection

