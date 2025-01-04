@extends('backend/layouts/master')

@section('content')

<div class="wrapper d-flex align-items-stretch">
    @include('backend.layouts.partials.dashboard-sidebar')
    
    <div id="content" class="p-4 p-md-5 pt-5">

        <div class="container">
            <div class="row align-items-center mb-5">
                <div class="col-md-8"><h2 class="h4">{{ $title }}</h2></div>
                <div class="col-md-4 text-md-end">
                    {{-- <button class="btn btn-outline-success btn-main px-5 py-3" data-bs-toggle="modal" data-bs-target="#modal-newlink">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        {{ __('Add a link') }}
                    </button> --}}
                </div>
            </div>
            @livewire('backend.payments.payments')
        </div>
    </div>
</div>

@endsection