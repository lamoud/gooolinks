@extends('backend/layouts/master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    @include('backend.layouts.partials.dashboard-sidebar')
    
    <div id="content" class="p-4 p-md-5 pt-5">
        @livewire('backend.staff-roles.staff-roles')
    </div>
</div>

@endsection