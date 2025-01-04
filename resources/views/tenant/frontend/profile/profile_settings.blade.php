@extends('tenant.frontend/layouts/master')
@vite(['resources/js/app.js'])
@section('css')
<style>
    header {
        background: #fff
    }
</style>
@endsection
@section('content')
    @include('tenant.frontend.profile.partials.profile_header')
    
    <div class="container mb-5">
        <div class="row">
            <div class="col-md-4 mb-5">
                @include('tenant.frontend.profile.partials.profile_sidebar')
            </div>

            <div class="col-md-8 mb-5">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">

                        <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-info" class="nav-link active" data-bs-toggle="tab" aria-selected="true" role="tab">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path><path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path></svg>
                                {{ __('Profile') }}</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-password" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-lock" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 13a2 2 0 0 1 2 -2h10a2 2 0 0 1 2 2v6a2 2 0 0 1 -2 2h-10a2 2 0 0 1 -2 -2v-6z" /><path d="M11 16a1 1 0 1 0 2 0a1 1 0 0 0 -2 0" /><path d="M8 11v-4a4 4 0 1 1 8 0v4" /></svg>
                                {{ __('Password') }}</a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-sessions" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="16"  height="16"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-devices"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M13 9a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-6a1 1 0 0 1 -1 -1v-10z" /><path d="M18 8v-3a1 1 0 0 0 -1 -1h-13a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h9" /><path d="M16 9h2" /></svg>
                                    {{ __('Browser Sessions') }}
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#tabs-social" class="nav-link" data-bs-toggle="tab" aria-selected="false" role="tab" tabindex="-1">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-article" width="16" height="16" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 4m0 2a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2z" /><path d="M7 8h10" /><path d="M7 12h10" /><path d="M7 16h10" /></svg>
                                    {{ __('Social media') }}
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content mt-5">
                            <div class="tab-pane active show" id="tabs-info" role="tabpanel">
                                @if (Laravel\Fortify\Features::canUpdateProfileInformation())
                                    @livewire('profile.update-profile-information-form')
                                @endif
                            </div>
                            
                            <div class="tab-pane" id="tabs-password" role="tabpanel">
                                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                                    @livewire('profile.update-password-form')
                                    <x-section-border />
                                @endif
                            </div>
                            
                            <div class="tab-pane" id="tabs-sessions" role="tabpanel">
                                {{-- @livewire('profile.update-social-media') --}}
                                @livewire('profile.logout-other-browser-sessions-form')
                            </div>

                            <div class="tab-pane" id="tabs-social" role="tabpanel">
                                {{-- @livewire('profile.update-social-media') --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection