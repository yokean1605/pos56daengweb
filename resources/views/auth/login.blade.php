@extends('layouts.app')

@section('content')
<div class="login-box">
    <div class="login-logo">
        <a href="#">
            <b>Admin</b>LTE
        </a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
    <div class="card-body login-card-body">
        <p class="login-box-msg">Sign in to start your session</p>

        <form action="{{ route('login') }}" method="post">
            @csrf
            @if(session('error'))
                @alert(['type' => 'danger'])
                    {{ session('error') }}
                @endalert
            @endif
            <div class="input-group mb-3">
                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="input-group mb-3">
                <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
                @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="icheck-primary">
                        <input type="checkbox" id="remember">
                        <label for="remember">
                        Remember Me
                        </label>
                    </div>
                </div>
                <!-- /.col -->
                <div class="col-4">
                    <button type="submit" class="btn btn-primary btn-block">{{ __('Login') }}</button>
                </div>
                <!-- /.col -->
            </div>
        </form>
    </div>
    <!-- /.login-card-body -->
    </div>
</div>
@endsection
