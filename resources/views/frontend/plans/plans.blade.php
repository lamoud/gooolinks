@extends('frontend/layouts/master')

@section('css')
    <style>
        header {
            background: #fff
        }
    </style>
@endsection

@section('content')

    <section class="plan-section py-5">
        <div class="container text-center">
            <div class="head">
                <h2>اختر الخطة التي تناسبك</h2>
                <p>العديد من المزايا في مجموعة من الباقات الرائعة، يمكنك إختيار أفضل باقة مناسبة لك  لتساعدك على البداية</p>    
            </div>

                @livewire('components.plans.plans')
        </div>
    </section>

@endsection