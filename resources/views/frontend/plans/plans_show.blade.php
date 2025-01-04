@extends('frontend/layouts/master')

@section('css')
    <style>
        header {
            background: #fff
        }
    </style>
@endsection

@section('content')
    <div class="container">
        @livewire('components.plans.plan-subscription', ['plan' => $plan])
    </div>
@endsection