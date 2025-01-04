<div>
    <div class="row">

        @forelse ($plans as $plan)
            <div class="col-md-4">
                <div class="card shadow border-0 price-card {{ $plan->is_featured ? 'best' : ''}}" data-aos="zoom-in-up" data-aos-duration="1000">
                    <div class="card-body">
                        <div class="form-check form-switch d-flex justify-content-end" style="gap: 8px">
                            <input class="form-check-input bg-light" type="checkbox" id="is_featured_{{ $plan->id }}" wire:click="toggleFeatured({{ $plan->id }})" {{ $plan->is_featured ? 'checked' : '' }}>
                            <label class="form-check-label {{ $plan->is_featured ? 'text-light' : 'text-primary'}} fw-bolder" id="is_featured_{{ $plan->id }}">المميزة</label>
                        </div>
                        <div class="card-head text-start">
                            <h4 class="{{ $plan->is_featured ? 'h4' : ''}} fw-bolder">{{ $plan->name }}</h4>
                            <p style="height: 50px">{{ $plan->description }}</p>
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

                        <button class="btn {{ $plan->is_featured ? 'btn-light' : 'btn-outline-success btn-main'}} w-100 px-5 py-3 mb-4" wire:click="updatePackage({{ $plan->id }})">
                            {{ __('Modify the package') }}
                        </button>
                        
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

                        <div class="d-flex gap-3 mb-4">
                            <button class="btn btn-danger" wire:click='deletePackage({{$plan->id}})'>
                                {{ __('Delete package') }}
                            </button>
                            <button class="btn {{ $plan->is_featured ? 'btn-light' : 'btn-primary'}}" wire:click='draftPackage({{$plan->id}})'>
                                {{ __('Move to draft') }}
                            </button>
                        </div>
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
    </div>

    <div class="row align-items-center my-4">
        <div class="col-md-8"><h2 class="h4">باقات في المسودة</h2></div>
        <div class="col-md-4 text-md-end">
            
        </div>
    </div>
    <div class="row">

        @forelse ($draftPlans as $plan)
            <div class="col-md-4">
                <div class="card shadow border-0 price-card {{ $plan->is_featured ? 'best' : ''}}" data-aos="zoom-in-up" data-aos-duration="1000">
                    <div class="card-body">
                        <div class="card-head text-start">
                            <h4 class="{{ $plan->is_featured ? 'h4' : ''}} fw-bolder">{{ $plan->name }}</h4>
                            <p style="height: 50px">{{ $plan->description }}</p>
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

                        <button class="btn {{ $plan->is_featured ? 'btn-light' : 'btn-outline-success btn-main'}} w-100 px-5 py-3 mb-4" wire:click="updatePackage({{ $plan->id }})">
                            {{ __('Modify the package') }}
                        </button>
                        
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

                        <div class="d-flex gap-3 mb-4">
                            <button class="btn btn-danger" wire:click='deletePackage({{$plan->id}})'>
                                {{ __('Delete package') }}
                            </button>
                            <button class="btn {{ $plan->is_featured ? 'btn-light' : 'btn-primary'}}" wire:click='draftPackage({{$plan->id}})'>
                                {{ __('Publish the package') }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-primary d-flex align-items-center" role="alert">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img" aria-label="Warning:">
                <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                </svg>
                <div>
                لا توجد باقات في المسودة حتى الآن!
                </div>
            </div>
        @endforelse
    </div>


    <div class="modal fade" id="modal-newpackage" tabindex="-1" aria-labelledby="modal-newpackageLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-newpackageLabel">{{ __('Add a package') }}</h5>
                    <button type="button" wire:click="resetToDefualt" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="package_name" class="form-label fw-bold">{{ __('Package name') }}</label>
                            <input class="form-control @error('package_name') is-invalid @enderror" type="text" wire:model="package_name" placeholder="{{ __('Enter package name') }}" required autofocus>
                            @error('package_name')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="package_marketing" class="form-label fw-bold">{{ __('Marketing sentence') }}</label>
                            <input class="form-control @error('package_marketing') is-invalid @enderror" type="text" wire:model="package_marketing" placeholder="{{ __('Enter marketing sentence') }}" required autofocus>
                            @error('package_marketing')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
    
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="package_price" class="form-label fw-bold">{{ __('Monthly price') }}</label>
                            <input class="form-control @error('package_price') is-invalid @enderror" type="number" wire:model="package_price" min="0" placeholder="{{ __('Enter monthly price') }}" required>
                            @error('package_price')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="package_discount" class="form-label fw-bold">{{ __('Annual discount') }}</label>
                            <input class="form-control @error('package_discount') is-invalid @enderror" type="number" min="0" wire:model="package_discount" placeholder="{{ __('Enter annual discount') }}" required>
                            @error('package_discount')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
    
                    <!-- قائمة الميزات المضافة مع أزرار التعديل والحذف -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Choose Features') }}</label>
                        <ul class="list-group">
                            @foreach($features as $feature)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @if($edit_feature_id === $feature->id)
                                        <!-- إذا كان المستخدم يعدل الميزة -->
                                        <input type="text" class="form-control" wire:model="edit_feature_name">
                                        <button class="btn btn-success btn-sm" wire:click="saveUpdatedFeature">{{ __('Save') }}</button>
                                    @else
                                        <!-- عرض الميزة -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $feature->id }}" wire:model="selected_features">
                                            <label class="form-check-label">{{ $feature->name }}</label>
                                        </div>
                                        <div>
                                            <button class="btn btn-warning btn-sm" wire:click="editFeature({{ $feature->id }})">{{ __('Edit') }}</button>
                                            <button class="btn btn-danger btn-sm" wire:click="deleteFeature({{ $feature->id }})">{{ __('Delete') }}</button>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
    
                    <!-- حقل وزر إضافة ميزة جديدة -->
                    <div class="mb-3">
                        <label for="new_feature" class="form-label fw-bold">{{ __('Add New Feature') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control @error('new_feature') is-invalid @enderror" wire:model="new_feature" placeholder="{{ __('Enter feature name') }}">
                            <button class="btn btn-primary" wire:click="addFeature">{{ __('Add Feature') }}</button>
                            @error('new_feature')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="saveAsDraft">{{ __('Add to draft') }}</button>
                    <button type="button" class="btn btn-primary" wire:click="savePackage">{{ __('Add the package') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-updatepackage" tabindex="-1" aria-labelledby="modal-updatepackageLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-newpackageLabel">{{ __('Edit') .': ' . $package_name }}</h5>
                    <button type="button" class="btn-close" wire:click="resetToDefualt" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="package_name" class="form-label fw-bold">{{ __('Package name') }}</label>
                            <input class="form-control @error('package_name') is-invalid @enderror" type="text" wire:model="package_name" placeholder="{{ __('Enter package name') }}" required autofocus>
                            @error('package_name')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="package_marketing" class="form-label fw-bold">{{ __('Marketing sentence') }}</label>
                            <input class="form-control @error('package_marketing') is-invalid @enderror" type="text" wire:model="package_marketing" placeholder="{{ __('Enter marketing sentence') }}" required autofocus>
                            @error('package_marketing')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
    
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="package_price" class="form-label fw-bold">{{ __('Monthly price') }}</label>
                            <input class="form-control @error('package_price') is-invalid @enderror" type="number" wire:model="package_price" min="0" placeholder="{{ __('Enter monthly price') }}" required>
                            @error('package_price')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="package_discount" class="form-label fw-bold">{{ __('Annual discount') }}</label>
                            <input class="form-control @error('package_discount') is-invalid @enderror" type="number" min="0" wire:model="package_discount" placeholder="{{ __('Enter annual discount') }}" required>
                            @error('package_discount')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
    
                    <!-- قائمة الميزات المضافة مع أزرار التعديل والحذف -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('Choose Features') }}</label>
                        <ul class="list-group">
                            @foreach($features as $feature)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    @if($edit_feature_id === $feature->id)
                                        <!-- إذا كان المستخدم يعدل الميزة -->
                                        <input type="text" class="form-control" wire:model="edit_feature_name">
                                        <button class="btn btn-success btn-sm" wire:click="saveUpdatedFeature">{{ __('Save') }}</button>
                                    @else
                                        <!-- عرض الميزة -->
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $feature->id }}" wire:model="selected_features">
                                            <label class="form-check-label">{{ $feature->name }}</label>
                                        </div>
                                        <div>
                                            <button class="btn btn-warning btn-sm" wire:click="editFeature({{ $feature->id }})">{{ __('Edit') }}</button>
                                            <button class="btn btn-danger btn-sm" wire:click="deleteFeature({{ $feature->id }})">{{ __('Delete') }}</button>
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
    
                    <!-- حقل وزر إضافة ميزة جديدة -->
                    <div class="mb-3">
                        <label for="new_feature" class="form-label fw-bold">{{ __('Add New Feature') }}</label>
                        <div class="input-group">
                            <input type="text" class="form-control @error('new_feature') is-invalid @enderror" wire:model="new_feature" placeholder="{{ __('Enter feature name') }}">
                            <button class="btn btn-primary" wire:click="addFeature">{{ __('Add Feature') }}</button>
                            @error('new_feature')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="resetToDefualt" data-bs-dismiss="modal" aria-label="Close">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-primary" wire:click="saveUpdatePackage">{{ __('Save changes') }}</button>
                </div>
            </div>
        </div>
    </div>
    

    <script>
        window.addEventListener('makeAction', event => {

            window["iziToast"][event.detail.type]({
                    title: `${event.detail.title}`,
                    message: `${event.detail.msg}`,
                    position: 'topLeft',
                    rtl: true,
            });

            $('#modal-newpackage').modal('hide');
            $('#modal-updatepackage').modal('hide');
        })
        window.addEventListener('updatePackageConfirm', event => {

            $('#modal-updatepackage').modal('show');
        })

        window.addEventListener('deletePackageConfirm', event => {

            window["iziToast"][event.detail.type]({
                // title: `${event.detail.title}`,
                message: `${event.detail.msg}`,
                rtl: true,
                timeout: 20000,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999999999,
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {

                        @this.confirmDeletePackage()
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {
            
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            
                    }],
                ]
            });

        })

        window.addEventListener('draftPackageConfirm', event => {

            window["iziToast"][event.detail.type]({
                // title: `${event.detail.title}`,
                message: `${event.detail.msg}`,
                rtl: true,
                timeout: 20000,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999999999,
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {

                        @this.confirmDraftPackage()
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {
            
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
            
                    }],
                ]
            });

        })
    </script>  
</div>
