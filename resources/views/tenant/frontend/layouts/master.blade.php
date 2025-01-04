<!DOCTYPE html>
<html dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ App::getLocale() }}">
<head>
    @include('tenant.frontend.layouts.partials.head')
</head>

<body>
    @include('tenant.frontend.layouts.partials.main-header')
    
    @yield('content')

    @include('tenant.frontend.layouts.partials.footer')
    @include('tenant.frontend.layouts.partials.footer-scripts')
</body>

</html>