<!DOCTYPE html>
<html dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ App::getLocale() }}">
<head>
    @include('tenant.frontend.layouts.partials.head')
</head>

<body>
    @include('tenant.frontend.layouts.partials.guest-header')
    
    @yield('content')

    @include('tenant.frontend.layouts.partials.footer-scripts')
</body>

</body>
</html>