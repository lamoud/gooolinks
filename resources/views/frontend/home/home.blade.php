@extends('frontend/layouts/master')

@section('content')
    @livewire('components.sections.hero-section')
    @livewire('components.sections.brands-section')
    @livewire('components.sections.join-distincts-section')
    @livewire('components.sections.weekly-activity-section')
    @livewire('components.sections.reaching-top-section')
    @livewire('components.sections.plan-section')
    @livewire('components.sections.newsletter-section')
    @livewire('components.sections.hero-mini-section') 
@endsection