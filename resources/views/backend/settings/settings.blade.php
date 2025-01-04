@extends('backend/layouts/master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    @include('backend.layouts.partials.dashboard-sidebar')
    
    <div id="content" class="p-4 p-md-5 pt-5">
        <div class="row align-items-center mb-5">
            <div class="col-md-8"><h2 class="h4">{{ $title }}</h2></div>
            <div class="col-md-4 text-md-end">
            </div>
        </div>
        @livewire('backend.settings.settings')
    </div>
</div>

@endsection