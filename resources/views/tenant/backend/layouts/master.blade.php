<!DOCTYPE html>
<html dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ App::getLocale() }}">
<head>
    @include('tenant.backend.layouts.partials.head')
</head>

<body>
    @include('tenant.backend.layouts.partials.main-header')
    
    @yield('content')

    @include('tenant.backend.layouts.partials.footer')
    @include('tenant.backend.layouts.partials.footer-scripts')
</body>

</body>
</html>