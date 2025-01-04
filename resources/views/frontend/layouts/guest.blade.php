<!DOCTYPE html>
<html dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ App::getLocale() }}">
<head>
    @include('frontend.layouts.partials.head')
</head>

<body>
    @include('frontend.layouts.partials.guest-header')
    
    @yield('content')

    @include('frontend.layouts.partials.footer-scripts')
</body>

</body>
</html>