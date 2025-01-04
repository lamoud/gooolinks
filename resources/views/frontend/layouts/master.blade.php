<!DOCTYPE html>
<html dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ App::getLocale() }}">
<head>
    @include('frontend.layouts.partials.head')
</head>

<body>
    @include('frontend.layouts.partials.main-header')
    
    @yield('content')

    @include('frontend.layouts.partials.footer')
    @include('frontend.layouts.partials.footer-scripts')
</body>

</html>