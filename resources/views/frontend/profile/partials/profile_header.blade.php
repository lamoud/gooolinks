<div class="container mb-5">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6">
                    <div class="d-flex align-items-center text-light">
                        <img src="{{ Auth::user()->profile_photo_url }}" alt="Avatar Logo" class="avatar large shadow-sm"> 
                        <span class="px-4">
                            <span>{{ __('Hello!') }}</span>
                            <h2 class="text-light">{{ Auth::user()->name }}</h2>
                        </span>
                    </div>
                </div>
                <div class="col-md-6"></div>
            </div>
        </div>
    </div>