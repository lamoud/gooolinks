  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ get_setting('site_icon', '#') }}" type="image/x-icon" />
  {!! seo($SEOData ?? null) !!}
  @livewireStyles
  @if (App::getLocale() == 'ar')
      <link  rel="stylesheet" href="{{ url('assets/bootstrap/css/bootstrap.rtl.min.css') }}">
    @else
      <link  rel="stylesheet" href="{{ url('assets/bootstrap/css/bootstrap.min.css') }}">
  @endif
    
  <link rel="stylesheet" href="{{ url('assets/css/main.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('assets/izitoast/css/iziToast.min.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ url('assets/aos/dist/aos.css') }}">

    @yield('css')
    <!-- End css files -->