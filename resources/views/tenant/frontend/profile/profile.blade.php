@extends('tenant.frontend/layouts/master')
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
                        tenant.
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection