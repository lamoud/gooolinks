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
            <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <h2 class="text-primary">{{ __('Recover account') }}</h2>
                <p>ادخل ايميلك وسيصلك رابط لتغيير كلمة المرور</p>

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
                <button type="submit" class="btn btn-primary d-block w-100">{{ __('Send') }}</button>
            </form>
        </div>
    </div>

    @if (Route::has('register'))
        <p class="text-center fw-bold my-5">
            {{ __('Don\'t have an account?') }}
            <a href="{{ route('register') }}" class="text-decoration-none text-primary">{{ __('Create one here') }} </a>
        </p>
    @endif
    
@endsection