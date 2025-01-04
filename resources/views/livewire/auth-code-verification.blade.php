<div>
    <div class="card form-card border-0 shadow rounded">
        <div class="card-body" x-data="{ recovery: false }">
            <form method="POST" action="{{ route('two-factor.login') }}">
                @csrf
                
                @if ($recovery === true)
                    <p class="mb-4">{{ __('Please confirm access to your account by entering one of your emergency recovery codes.') }}</p>
                @else
                    <p class="mb-4">{{ __('Please confirm access to your account by entering the authentication code provided by your authenticator application.') }}</p>
                @endif
                
                <x-validation-errors class="mb-4" />
                
                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ $value }}
                    </div>
                @endsession

                @if ($recovery === true)
                    <div class="mb-3">
                        <label for="recovery_code" class="form-label" >{{ __('Recovery Code') }}</label>
                        <input class="form-control" type="text" name="recovery_code" value="{{ old('recovery_code') }}" required autofocus autocomplete="one-time-code">
                    </div>
                @else
                    <div class="mb-3">
                        <label for="code" class="form-label" >{{ __('Code') }}</label>
                        <input class="form-control" type="text" name="code" value="{{ old('code') }}" inputmode="numeric" required autofocus autocomplete="one-time-code">
                    </div>
                @endif


                @if ($recovery === true)
                    <div class="my-3">
                        <a href="javascript:void(0)" wire:click="setRecoveryStatus(false)">
                            {{ __('Use an authentication code') }}
                        </a>
                    </div>
                @else
                    <div class="my-3">
                        <a href="javascript:void(0)" wire:click="setRecoveryStatus(true)">
                            {{ __('Use a recovery code') }}
                        </a>
                    </div>
                @endif

                <button type="submit" class="btn btn-primary d-block w-100">{{ __('Login') }}</button>

            </form>
        </div>
    </div>

    <p class="text-center fw-bold my-5">
        {{ __('Don\'t have an account?') }}
        <a href="{{ route('register') }}" class="text-decoration-none text-primary">{{ __('Create one here') }} </a>
    </p>
</div>
