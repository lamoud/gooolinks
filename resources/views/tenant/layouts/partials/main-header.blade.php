{{-- header_start --}}

<header class="backend">
    <div class="container">
        <nav class="navbar navbar-expand-lg navbar-light py-3">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ route('home') }}">
                    <h2>{{ get_setting('site_name', 'لـــــــــينك') }}</h2>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02" aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                    <ul class="navbar-nav m-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" aria-current="page" href="{{ route('home') }}">الرئيسية</a>
                        </li>
                    </ul>

                    <div class="dropdown custom-dropdown">
                        <a class="navbar-brand" href="#" role="button" id="notificDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-bell"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}">ملفي الشخصي</a></li>
                            <li><a class="dropdown-item" href="{{ route('logout') }}">تسجيل الخروج</a></li>
                        </ul>
                    </div>

                    <div class="dropdown custom-dropdown">
                        <a class="navbar-brand" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            <img src="{{ Auth::user()->profile_photo_url }}" alt="Avatar Logo" style="width:40px;" class="rounded-pill"> 
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li><a class="dropdown-item" href="{{ route('profile.index') }}">ملفي الشخصي</a></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    تسجيل الخروج
                                </a>
                            </li>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </ul>
                    </div>

                </div>
            </div>
        </nav>
    </div>
</header>

{{-- header_end --}}
