<div>
    <div class="action d-flex align-items-center my-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" id="flexSwitchCheckChecked" checked>
            <label class="form-check-label text-primary fw-bolder" for="flexSwitchCheckChecked">سنوي</label>
        </div>

        <div class="rounded py-1 px-3 border border-primary rounded-pill text-primary mx-4">
            {{ number_format($averageDiscount, 2) }}% خصم
        </div>
    </div>
    
    <div class="row">

        @forelse ($plans as $plan)
            <div class="col-md-4">
                <div class="card price-card {{ $plan->is_featured ? 'best' : ''}}" data-aos="zoom-in-up" data-aos-duration="1000">
                    <div class="card-body">
                        <div class="card-head text-start">
                            <h4 class="{{ $plan->is_featured ? 'h4' : ''}} fw-bolder">{{ $plan->name }}</h4>
                            <p>{{ $plan->description }}</p>
                            @if($plan->monthly_price == 0)
                                <div class="h1 fw-bolder py-4">
                                    $0 
                                    <small class="h5">مجاناً</small>
                                </div>
                            @else
                                <div class="h1 fw-bolder py-4">
                                    ${{ number_format($plan->monthly_price, 2) }}
                                </div>
                            @endif
                        </div>

                        <a class="btn {{ $plan->is_featured ? 'btn-light' : 'btn-outline-success btn-main'}} w-100 px-5 py-3 mb-4" href="{{ route('plans.show', $plan->slug) }}">
                            @if ($plan->monthly_price == 0)
                                ابدأ الآن مجاناً
                            @else
                                {{ $plan->is_featured ? 'احصل عليها الآن' : 'ابدأ الآن'}}
                            @endif
                            
                        </a>
                        
                        <ul class="text-start">

                            @forelse ($plan->features as $ft)

                            @php
                                $planFeature = $ft->pivot; // الوصول إلى pivot للحصول على حالة الميزة
                            @endphp
                                @if ($planFeature->status !== 'disabled')
                                    <li class="{{ $planFeature->status }}">
                                        @if ($planFeature->status == 'unavailable')
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
                                        @else
                                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                                        @endif
                                        {{ $ft->name }}
                                    </li>
                                @endif
                                
                            @empty
                                
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-primary d-flex align-items-center" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <div>
                لا توجد باقات نشطة حتى الآن!
                </div>
            </div>
        @endforelse
        
        {{-- <div class="col-md-4">
            <div class="card price-card">
                <div class="card-body">
                    <div class="card-head text-start">
                        <h4 class="fw-bolder">الباقة الرئيسية</h4>
                        <p>طور أعمالك الشخصية وابدأ بتحقيق وصول أعلى</p>
                        <div class="h1 fw-bolder py-4">$7 <small class="h5">وفر أكثر من 20$</small></div>
                    </div>

                    <button class="btn btn-outline-success btn-main w-100 px-5 py-3 mb-4">ابدأ الآن</button>
                    
                    <ul class="text-start">
                        <li class="available">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                            مميزات أساسية
                        </li>
                        <li class="available">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                            رابط واحد لكل ما تريد
                        </li>
                        <li class="available">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                            إحصاءات عامة عن أداء الرابط
                        </li>
                        <li class="available">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                            ثلاث دعوات فقط
                        </li>
                        <li class="available">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                            مشاركة الرابط
                        </li>
                        <li class="available">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                            تحكم في الروابط بشكل كامل
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card price-card best">
                <div class="card-body">
                    <div class="card-head text-start">
                        <p class="h4 fw-bolder">الأفضل</p>
                        <p>طور أعمالك وحقق أفضل النتائج المرجوة</p>
                        <div class="h1 fw-bolder py-4">$15 <small class="h5">وفر 35$</small></div>
                    </div>

                    <button class="btn btn-light w-100 px-5 py-3 mb-4">أحصل عليها الآن</button>
                    
                    <ul class="text-start">
                        <li class="available">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                            مميزات أساسية
                        </li>
                        <li class="available">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                            رابط واحد لكل ما تريد
                        </li>
                        <li class="available">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                            إحصاءات عامة عن أداء الرابط
                        </li>
                        <li class="available">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                            ثلاث دعوات فقط
                        </li>
                        <li class="available">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                            مشاركة الرابط
                        </li>
                        <li class="available">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                            تحكم في الروابط بشكل كامل
                        </li>
                    </ul>
                </div>
            </div>
        </div> --}}
    </div>
</div>
