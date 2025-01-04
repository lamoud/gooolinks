<div>
    <section class="hero-section pt-5" data-aos="fade-up" data-aos-duration="1000">
        <div class="container d-flex flex-column align-items-center text-center">
            <div class="heed mb-4" data-aos="fade-up" data-aos-duration="1000">
                <h1 class="decorated-text">إنطلق بسرعة الصاروخ</h1>
                <h1 class="decorated-text">واحصل على انتشار أكبر</h1>
                <p>نساعدك على تطوير أعمالك من خلال الوصول الأكبر والأسرع بطرق سهلة لزبائنك المحتملين وغيرها من الأساليب التي تجعلك رائداً في مجالك، كل ذلك برابط واحد</p>
            </div>
            <div class="d-flex gap-3 mb-4">
                @auth
                    <a class="btn btn-outline-success btn-main px-5 py-3"  href="{{ route('profile.index') }}">{{ __('Profile') }}</a>
                @else
                    <a class="btn btn-outline-success btn-main px-5 py-3"  href="{{ route('login') }}">ابدأ الآن مجاناً</a>
                @endauth
                <button class="btn light btn-outline-success btn-main px-5 py-3">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-player-play">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M7 4v16l13 -8z"/>
                    </svg>
                    شاهد الفيديو الترويجي
                </button>
            </div>
            <div class="text-center hero-floating">

                <div class="float-left" data-aos="zoom-in-left">
                    <img src="assets/images/Img_float_hero.svg" alt="hero-1" class="">
                    <p>12.2K</p>
                </div>
                <div class="float-riight" data-aos="zoom-in-left">
                    <img src="assets/images/Img_float_hero_right.svg" alt="hero-2" class="">
                    <p>35K</p>
                </div>

                <img src="assets/images/statistics.svg" alt="statistics" class="img-fluid">
            </div>
        </div>
    </section>
</div>
