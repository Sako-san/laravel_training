@extends('layout')
@section('content')
<form method="POST" action="{{ route('register') }}">
  @csrf
  <div class="form-group">
    <label>Name</label>
    <input name="name" value="{{ old('name') }}" type="text" required class="form-control{{ $errors->has('name') ? ' is-invalid':'' }}" >

    @if ($errors->has('name'))
      <span class="invalid-feedback">
        <strong>{{ $errors->first('name') }}</strong>
      </span>
    @endif
  </div>

  <div class="form-group">
    <label>E-mail</label>
    <input name="email" value="{{ old('email') }}" required class="form-control{{ $errors->has('email') ? ' is-invalid':'' }}"" type="text">
  
    @if ($errors->has('email'))
      <span class="invalid-feedback">
        <strong>{{ $errors->first('email') }}</strong>
      </span>
    @endif
  </div>

  <div class="form-group">
    <label>Password</label>
    <input name="password" value="" required class="form-control{{ $errors->has('password') ? ' is-invalid':'' }}"" type="password">

    @if ($errors->has('password'))
      <span class="invalid-feedback">
        <strong>{{ $errors->first('password') }}</strong>
      </span>
    @endif
  </div>

  <div class="form-group">
    <label>Retyped Password</label>
    <input name="password_confirmation" value="" required class="form-control" type="password">
  </div>

  <button type="submit" class="btn btn-primary btn-block">Register</button>
</form>
@endsection('content')