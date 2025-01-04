<div>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card border-0 shadow-sm rounded">
                <div class="card-body py-4">
                    <h5 class="text-muted fw-bold mb-4" style="color: #b0b0b0 !important">{{ __('Site Identity') }}</h5>
        
                
                    <!-- منطقة رفع اللوجو باستخدام Dropzone -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="mb-3 text-center">
                                <label for="logo" class="form-label fw-bold">{{ __('Site logo') }}</label>
                    
                                <!-- منطقة عرض اللوجو -->
                                <div class="avatar xlarge my-0 mx-auto">
                                    <!-- نستخدم الشرط للتحقق مما إذا كان هناك لوجو مرفوع -->
                                    @if (file_exists(public_path($site_logo)))
                                        <img 
                                            id="logo-image" 
                                            src="{{ $site_logo }}" 
                                            alt="Site Logo" 
                                            class="img-thumbnail"
                                            style="object-fit: contain; cursor: pointer;"
                                            onclick="document.getElementById('image-upload').click()"
                                        >
                                    @else
                                    <span 
                                        id="logo-image"
                                        alt="Site logo" 
                                        style="object-fit: contain; cursor: pointer;"
                                        onclick="document.getElementById('logo-upload').click()"
                                    >
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="img-thumbnail icon icon-tabler icons-tabler-outline icon-tabler-upload"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 9l5 -5l5 5" /><path d="M12 4l0 12" /></svg>
                                    </span>
                                    @endif

                                    
                                </div>
                    
                                <!-- منطقة Dropzone -->
                                <div class="d-none" wire:ignore.self>
                                    <form action="{{ route('dropzone.store') }}" method="post" enctype="multipart/form-data" id="image-upload" class="dropzone">
                                        @csrf
                                    </form>
                                </div>
                    
                                @error('new_logo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <!-- صف يحتوي على اسم الموقع والبريد الإلكتروني -->
                    <div class="row">
                        <!-- اسم الموقع -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="site_name" class="form-label fw-bold">{{ __('Site name') }}</label>
                                <input class="form-control @error('site_name') is-invalid @enderror" type="text" wire:model="site_name" placeholder="{{ __('Enter site name') }}" required>
                                @error('site_name')
                                    <small class="invalid-feedback d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
        
                        <!-- البريد الإلكتروني -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label fw-bold">{{ __('Email') }}</label>
                                <input class="form-control @error('email') is-invalid @enderror" type="email" wire:model="email" placeholder="your-email@example.com" required>
                                @error('email')
                                    <small class="invalid-feedback d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
        
                    <!-- صف يحتوي على رقم الهاتف والميتا تاج -->
                    <div class="row">
                        <!-- رقم الهاتف -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="phone" class="form-label fw-bold">{{ __('Phone Number') }}</label>
                                <input class="form-control @error('phone') is-invalid @enderror" type="text" wire:model="phone" placeholder="123-456-7890" required>
                                @error('phone')
                                    <small class="invalid-feedback d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
        
                        <!-- الميتا تاج -->
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="meta_tag" class="form-label fw-bold">{{ __('Meta Tag') }}</label>
                                <input class="form-control @error('meta_tag') is-invalid @enderror" type="text" wire:model="meta_tag" placeholder="{{ __('Enter meta tag') }}" required>
                                @error('meta_tag')
                                    <small class="invalid-feedback d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
        
                    <!-- صف يحتوي على وصف الموقع (textarea) -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="site_description" class="form-label fw-bold">{{ __('Site Description') }}</label>
                                <textarea class="form-control @error('site_description') is-invalid @enderror" wire:model="site_description" rows="4" placeholder="{{ __('Enter site description') }}"></textarea>
                                @error('site_description')
                                    <small class="invalid-feedback d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
        
                    <!-- منطقة رفع اللوجو باستخدام Dropzone -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label for="icon" class="form-label fw-bold">{{ __('Site icon') }}</label>
                    
                                <!-- منطقة عرض اللوجو -->
                                <div class="avatar medium">
                                    <!-- نستخدم الشرط للتحقق مما إذا كان هناك لوجو مرفوع -->
                                    @if (file_exists(public_path($site_icon)))
                                        <img 
                                            id="icon-image" 
                                            src="{{ $site_icon ? $site_icon : asset('path/to/default-icon.png') }}" 
                                            alt="Site icon" 
                                            class="img-thumbnail" 
                                            style="object-fit: contain; cursor: pointer;"
                                            onclick="document.getElementById('icon-upload').click()"
                                        >
                                    @else
                                    <span 
                                        id="icon-image"
                                        alt="Site icon" 
                                        style="object-fit: contain; cursor: pointer;"
                                        onclick="document.getElementById('icon-upload').click()"
                                    >
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="img-thumbnail icon icon-tabler icons-tabler-outline icon-tabler-upload"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2" /><path d="M7 9l5 -5l5 5" /><path d="M12 4l0 12" /></svg>
                                    </span>
                                    @endif
                                    
                                </div>
                    
                                <!-- منطقة Dropzone -->
                                <div class="d-none" wire:ignore.self>
                                    <form action="{{ route('dropzone.store') }}" method="post" enctype="multipart/form-data" id="icon-upload" class="dropzone">
                                        @csrf
                                    </form>
                                </div>
                    
                                @error('site_icon')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- زر الحفظ -->
                    <div class="mb-3">
                        <button id="save-button" class="btn btn-outline-success btn-main px-5 py-3 w-100" wire:click="saveSiteSettings">{{ __('Save changes') }}</button>
                    </div>
                </div>
            </div>
        </div>
        

        <div class="col-md-5 mb-4">
            <div class="card border-0 shadow-sm rounded mb-4">
                <div class="card-body py-4">
        
                    <h5 class="text-muted fw-bold mb-4" style="color: #b0b0b0 !important">{{ __('Social media') }}</h5>
                    
                    <!-- Facebook -->
                    <div class="mb-3">
                        <label for="facebook" class="form-label fw-bold">{{ __('Facebook') }}</label>
                        <input class="form-control @error('facebook') is-invalid @enderror" type="text" wire:model="facebook" placeholder="https://www.facebook.com/your-profile" required>
                        @error('facebook')
                            <small class="invalid-feedback d-block">{{ $message }}</small>
                        @enderror
                    </div>
        
                    <!-- Instagram -->
                    <div class="mb-3">
                        <label for="instagram" class="form-label fw-bold">{{ __('Instagram') }}</label>
                        <input class="form-control @error('instagram') is-invalid @enderror" type="text" wire:model="instagram" placeholder="https://www.instagram.com/your-profile" required>
                        @error('instagram')
                            <small class="invalid-feedback d-block">{{ $message }}</small>
                        @enderror
                    </div>
        
                    <!-- Twitter -->
                    <div class="mb-3">
                        <label for="twitter" class="form-label fw-bold">{{ __('Twitter') }}</label>
                        <input class="form-control @error('twitter') is-invalid @enderror" type="text" wire:model="twitter" placeholder="https://www.twitter.com/your-profile" required>
                        @error('twitter')
                            <small class="invalid-feedback d-block">{{ $message }}</small>
                        @enderror
                    </div>
        
                    <!-- WhatsApp -->
                    <div class="mb-3">
                        <label for="whatsapp" class="form-label fw-bold">{{ __('WhatsApp') }}</label>
                        <input class="form-control @error('whatsapp') is-invalid @enderror" type="text" wire:model="whatsapp" placeholder="https://wa.me/your-phone-number" required>
                        @error('whatsapp')
                            <small class="invalid-feedback d-block">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <button class="btn btn-outline-success btn-main px-5 py-3 w-100" wire:click="saveSocialSettings">{{ __('Save changes') }}</button>
                    </div>
        
                </div>
            </div>

            <div class="card border-0 shadow-sm rounded">
                <div class="card-body py-4">
        
                    {{-- <h5 class="text-muted fw-bold mb-4" style="color: #b0b0b0 !important">{{ __('Maintenance mode') }}</h5> --}}
                    
                    <div class="my-3">

                        <label for="whatsapp" class="form-label fw-bold">{{ __('Maintenance mode') }}</label>
                        <div class="form-check form-switch d-flex justify-content-between align-items-center">
                            <label class="form-check-label" for="flexSwitchCheckChecked">تفعيل وضع الصيانة</label>
                            <input class="form-check-input large-switch" type="checkbox" id="flexSwitchCheckChecked" wire:model.live="site_mode" {{ $site_mode == 'down' ? 'checked' : '' }}>
                        </div>

                    </div>
        
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
            $(event.detail.modal).modal('hide');

        })

        Dropzone.autoDiscover = false;
        document.addEventListener('DOMContentLoaded', function () {
            let logoDropzone = new Dropzone("#image-upload", {
                url: "{{ route('dropzone.store') }}",
                acceptedFiles: 'image/*',
                addRemoveLinks: true,
                success: function (file, response) {
                    console.log(response);
                    document.getElementById('logo-image').src = response.image_url; // تحديث الصورة بعد رفع اللوجو الجديد
                    @this.saveImaages('logo', response);
                }
            });

            let iconDropzone = new Dropzone("#icon-upload", {
                url: "{{ route('dropzone.store') }}",
                acceptedFiles: 'image/*',
                addRemoveLinks: true,
                success: function (file, response) {
                    document.getElementById('icon-image').src = response.image_url; // تحديث الصورة بعد رفع اللوجو الجديد
                    @this.saveImaages('icon', response);
                }
            });
        });         

    </script>

</div>
