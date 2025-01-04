<!DOCTYPE html>
<html dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}" lang="{{ App::getLocale() }}">
<head>
    @include('backend.layouts.partials.head')
</head>

<body>
    @include('backend.layouts.partials.main-header')
    
    @yield('content')

    @include('backend.layouts.partials.footer')
    @include('backend.layouts.partials.footer-scripts')
</body>

</body>
</html>