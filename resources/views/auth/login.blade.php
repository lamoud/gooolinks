@extends('frontend/layouts/guest')

@section('css')
<style>
    body {
        background: linear-gradient(to bottom right, #d7e9ff, #E7C6F2);
        min-height: 100vh;
    }
</style>
@endsection
@section('content')

    <div class="card form-card border-0 shadow rounded">
        <div class="card-body">
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <h2 class="text-primary">{{ __('Login') }}</h2>
                <p>سجل دخولك واستكمل العمل على تطوير مستقبلك</p>

                <x-validation-errors class="mb-4" />
                
                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ $value }}
                    </div>
                @endsession

                <div class="mb-3">
                    <label for="email" class="form-label" >{{ __('Email') }}</label>
                    <input class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <div class="input-group input-group-flat">
                        <input type="password" id="pass" class="form-control" name="password" required autocomplete="current-password">
                        <span class="input-group-text">
                        <a id="pass_icon" href="javascript:void(0)" onclick="show_hide_pass( 'pass' )" class="link-secondary" data-bs-toggle="tooltip" aria-label="Show password" data-bs-original-title="Show password">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path></svg>
                        </a>
                        </span>
                    </div>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="remember_me" name="remember">
                    <label class="form-check-label" for="exampleCheck1">{{ __('Remember me') }}</label>
                </div>
                <button type="submit" class="btn btn-primary d-block w-100 py-3">{{ __('Login') }}</button>

                @if (Route::has('password.request'))
                    <p class="my-3">
                        {{ __('Forgot your password?') }}
                        <a class="" href="{{ route('password.request') }}">
                            {{ __('Recover account') }}
                        </a>
                    </p>
                    
                @endif
            </form>
        </div>
    </div>

    <div class="card-socialmedia">
        <div class="container text-center mt-3">
            <div class="row">
                <div class="col-md-5">
                    <hr>
                </div>
                <div class="col-md-2">
                    <p>أو</p>
                </div>
                <div class="col-md-5">
                    <hr>
                </div>
            </div>

            <div class="d-flex justify-content-between w-100">
        
                <a href="{{ route('apple.login') }}" class="btn btn-dark px-3 py-3 d-flex align-items-center justify-content-center" style="width: max-content">
                    {{ __('Sign in with Apple') }}
                    <img src="https://img.icons8.com/ios-filled/50/ffffff/mac-os.png" alt="Apple" style="width: 24px; height: 24px; margin-right: 8px;">
                </a>
    
                <a href="{{ route('google.login') }}" class="btn light btn-main px-3 py-3 d-flex align-items-center justify-content-center" style="width: max-content">
                    {{ __('Sign in with Google') }}
                    <img src="https://img.icons8.com/color/48/000000/google-logo.png" alt="Google" style="width: 24px; height: 24px; margin-right: 8px;">
                </a>
            </div>
        </div>
    </div>
    
    @if (Route::has('register'))
        <p class="text-center fw-bold my-5">
            {{ __('Don\'t have an account?') }}
            <a href="{{ route('register') }}" class="text-decoration-none text-primary">{{ __('Create one here') }} </a>
        </p>
    @endif
    
@endsection