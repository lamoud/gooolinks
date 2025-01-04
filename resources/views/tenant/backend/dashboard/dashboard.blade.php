@extends('tenant/backend/layouts/master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    @include('tenant.backend.layouts.partials.dashboard-sidebar')
    
    <div id="content" class="p-4 p-md-5 pt-5">
      <div class="container">
        @livewire('tenant.backend.main.main')
      </div>
    </div>
</div>
@endsection