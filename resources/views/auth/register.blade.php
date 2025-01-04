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
            <form method="POST" action="{{ route('register') }}">
                @csrf
                <h2 class="text-primary">{{ __('Register') }}</h2>
                <p>إنطلق الآن وأعمل على تطوير أعمالك وانتشارها</p>

                <x-validation-errors class="mb-4" />
                
                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ $value }}
                    </div>
                @endsession

                <div class="mb-3">
                    <label for="email" class="form-label" >{{ __('Name') }}</label>
                    <input class="form-control" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label" >{{ __('Email') }}</label>
                    <input class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">{{ __('Password') }}</label>
                    <div class="input-group input-group-flat">
                        <input type="password" id="pass" class="form-control" name="password" required autocomplete="new-password">
                        <span class="input-group-text">
                        <a id="pass_icon" href="javascript:void(0)" onclick="show_hide_pass( 'pass' )" class="link-secondary" data-bs-toggle="tooltip" aria-label="Show password" data-bs-original-title="Show password">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path></svg>
                        </a>
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                    <div class="input-group input-group-flat">
                        <input type="password" id="pass2" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        <span class="input-group-text">
                        <a id="pass2_icon" href="javascript:void(0)" onclick="show_hide_pass( 'pass2' )" class="link-secondary" data-bs-toggle="tooltip" aria-label="Show password" data-bs-original-title="Show password">
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path><path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6"></path></svg>
                        </a>
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    @php
                        $url = url('/');
                        $parsedUrl = parse_url($url);
                        $domain = $parsedUrl['host'];
                    @endphp
                    <label for="link" class="form-label">{{ __('الرابط') }}</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-link" style="direction: ltr">.{{ $domain }}</span>
                        <input type="text" class="form-control" name="link" value="{{ old('link') }}" placeholder="link" aria-label="link" aria-describedby="basic-link">
                    </div>
                </div>                
                
                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="my-3">
                    <label class="form-check">
                        <input id="terms" type="checkbox" name="terms" class="form-check-input">
                        <span class="form-check-label">
                            {!! 
                                __('I agree to the :terms_of_service and :privacy_policy', [
                                    'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">&nbsp;'.__('Terms of Service').'&nbsp;</a>',
                                    'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">'.__('Privacy Policy').'</a>',
                                ]) 
                            !!}
                        </span>
                    </label>
                </div>
            @endif

                <button type="submit" class="btn btn-primary d-block w-100">{{ __('Register') }}</button>

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
    
    <p class="text-center fw-bold my-5">
        {{ __('Already registered?') }}
        <a href="{{ route('login') }}" class="text-decoration-none text-primary">{{ __('Login') }} </a>
    </p>
    
@endsection