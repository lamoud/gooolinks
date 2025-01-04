<div>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />

    <style>
        .cursor-pointer {
            cursor: pointer;
        }
    </style>
    <div class="row">
        <div class="col-md-8">
            <div class="d-flex align-items-center justify-content-between mb-4 p-3 py-4 shadow-sm rounded bg-white">
                <div>
                    <span class="fw-bold">رابطك الخاص هو:</span>
                    <a id="link-to-copy" href="{{ $tenantUrl }}" target="_blank" class="text-primary fw-bold">{{ $tenantUrl }}</a>
                </div>
                <button id="copy-button" class="btn btn-outline-success btn-main px-5 py-3 fw-bold">نسخ الرابط</button>
            </div>


            <div class="mb-4 p-3 py-4 shadow-sm rounded bg-white">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h4 class="fw-bold">إضافة روابط التواصل</h4>
                    </div>
                    @if ($socilLinksShow)
                        <b class="cursor-pointer" wire:click="toggleElementsShow('socilLinksShow')">
                            إخفاء اللائحة
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                        </b>
                    @else
                    <b class="cursor-pointer" wire:click="toggleElementsShow('socilLinksShow')">
                        إظهار اللائحة
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 15l6 -6l6 6" /></svg>
                    </b>
                    @endif
                    
                </div>

                @if ($socilLinksShow)

                    @forelse ($socialLinks as $index => $link)
                    <div class="mb-3 p-3 shadow-sm rounded bg-light">
                        <div class="d-flex align-items-center justify-content-between">
                            
                            <div class="d-flex align-items-center cursor-pointer" wire:click="toggleElementsShow('{{$index}}')">
                                <span class="text-primary fw-bold me-2">{{ $link['name'] }}</span>
                                @if ($link['showElm'])
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                                @else
                                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 15l6 -6l6 6" /></svg>
                                @endif
                            </div>
                            
                            <div class="form-check form-switch d-flex justify-content-between align-items-center">
                                <input class="form-check-input large-switch" type="checkbox" id="{{ $link['name_en'] }}" {{ $link['show'] ? 'checked' : '' }} wire:change="updateSocialVisibility('{{ $index }}', $event.target.checked)">
                                <a href="javascript:void(0)" wire:click="deleteSocialLink('{{ $index }}')">
                                    <svg style="color:#eb5757" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                                </a>
                            </div>
                        </div>

                        <span class="d-flex align-items-center">

                            @if ($link['showElm'])
                                <svg  xmlns="http://www.w3.org/2000/svg"  width="35"  height="35"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-grip-vertical text-secondary"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M9 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M9 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M15 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M15 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M15 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg>
                                @if ($link['editing'])
                                    <span class="d-flex align-items-center">
                                        <input type="text" class="form-control me-2" wire:model="socialLinks.{{ $index }}.link" placeholder="أدخل الرابط الجديد">
                                        <button class="btn btn-success" wire:click="saveSocialLink('{{ $index }}')">حفظ</button>
                                    </span>
                                @else
                                    <span class="fw-bold">{{ $link['link'] }}</span>
                                    <span class="text-decoration-underline cursor-pointer text-primary fw-bold" wire:click="toggleEditing('{{$index}}')">
                                        <svg style="transform: rotateY(180deg)" xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-pencil-minus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" /><path d="M13.5 6.5l4 4" /><path d="M16 19h6" /></svg>
                                    </span>
                                @endif
                                
                            @endif
                        </span>
                    </div>
                    @empty
                        
                    @endforelse
                    <button class="btn btn-outline-success btn-main my-3 px-5 py-3 fw-bold w-100" data-bs-toggle="modal" data-bs-target="#modal-newSocialLink">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                        إضافة رابط
                    </button>

                @endif
            </div>

            <div class="mb-4 p-3 py-4 shadow-sm rounded bg-white">
                <div class="d-flex align-items-center justify-content-between mb-3">
                    <div>
                        <h4 class="fw-bold">إضافة الترويسة</h4>
                    </div>
                    @if ($headerElemShow)
                        <b class="cursor-pointer" wire:click="toggleElementsShow('headerElemShow')">
                            إخفاء اللائحة
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 9l6 6l6 -6" /></svg>
                        </b>
                    @else
                    <b class="cursor-pointer" wire:click="toggleElementsShow('headerElemShow')">
                        إظهار اللائحة
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevron-up"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 15l6 -6l6 6" /></svg>
                    </b>
                    @endif
                    
                </div>

                @if ($headerElemShow)
                    <div class="row mb-3">
                        <!-- منطقة رفع اللوجو باستخدام Dropzone -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="mb-3 text-center">                    
                                <!-- منطقة عرض اللوجو -->
                                <div class="avatar xlarge my-0 mx-auto">
                                    <!-- نستخدم الشرط للتحقق مما إذا كان هناك لوجو مرفوع -->
                                        <img 
                                            id="logo-image" 
                                            src="{{ $personCompanyLogo }}" 
                                            alt="Site Logo" 
                                            class="img-thumbnail"
                                            style="object-fit: contain; cursor: pointer;"
                                            onclick="document.getElementById('image-upload').click()"
                                        >

                                    
                                </div>
                    
                                <!-- منطقة Dropzone -->
                                <div class="d-none" wire:ignore.self>
                                    <form action="{{ route('te.dropzone.store') }}" method="post" enctype="multipart/form-data" id="image-upload" class="dropzone">
                                        @csrf
                                    </form>
                                </div>
                    
                                @error('new_logo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
                        <!-- حقل اسم الشخص أو الشركة -->
                        <div class="col-md-6">
                            <label for="personCompanyName" class="form-label">{{ __('Person/Company Name') }}</label>
                            <input type="text" class="form-control" id="personCompanyName" wire:model="personCompanyName" placeholder="{{ __('Enter person or company name') }}">
                            @error('personCompanyName')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    
                        <!-- حقل مجال العمل -->
                        <div class="col-md-6">
                            <label for="workField" class="form-label">{{ __('Work Field') }}</label>
                            <input type="text" class="form-control" id="workField" wire:model="workField" placeholder="{{ __('Enter work field') }}">
                            @error('workField')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- حقل نص التسويق -->
                    <div class="mb-3">
                        <label for="marketingText" class="form-label">{{ __('Marketing Text') }}</label>
                        <textarea class="form-control" id="marketingText" wire:model="marketingText" rows="4" placeholder="{{ __('Enter marketing text') }}"></textarea>
                        @error('marketingText')
                            <small class="invalid-feedback d-block">{{ $message }}</small>
                        @enderror
                    </div>
                
                    
                    <button class="btn btn-outline-success btn-main my-3 px-5 py-3 fw-bold w-100" wire:click="saveHeaderData">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                        {{ __('Save') }}
                    </button>

                @endif
            </div>

        </div>
        <div class="col-md-4">
            <style>
                .profile-card {
                    background-color: #faf8fe;
                    margin: 0 auto;
                    border-radius: 5%;
                    
                }
            </style>
            <div class="profile-card p-4 d-flex flex-column align-items-center text-center shadow">
                <div class="avatar xlarge my-0 mx-auto">
                    <!-- نستخدم الشرط للتحقق مما إذا كان هناك لوجو مرفوع -->
                        <img 
                            id="logo-image" 
                            src="{{ get_setting('person_company_avatar', Auth()->user()->profile_photo_url) }}" 
                            alt="Site Logo" 
                            class="img-thumbnail"
                            style="object-fit: contain; cursor: pointer;border-radius:50%"
                        >
                </div>
        
                <h3>{{ get_setting('person_company_name', 'اسم الشركة(الشخص)') }}</h3>
                <b>{{ get_setting('work_field', 'مدرب كمال أجسام') }}</b>
                <div class="text-muted">
                    {{ get_setting('marketing_text', 'نص تسويقي مصغر عن ما يقوم به الشخص أو الشركة ما يصف عمله بشكل مختصر') }}
        
                    @php
                        $defultLinks = [
                                    'facebook'=>[
                                        'show'=>true,
                                        'link'=>'https://facebook.com',
                                        'logo'=>'<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="currentColor"  class="icon icon-tabler icons-tabler-filled icon-tabler-brand-facebook"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 2a1 1 0 0 1 .993 .883l.007 .117v4a1 1 0 0 1 -.883 .993l-.117 .007h-3v1h3a1 1 0 0 1 .991 1.131l-.02 .112l-1 4a1 1 0 0 1 -.858 .75l-.113 .007h-2v6a1 1 0 0 1 -.883 .993l-.117 .007h-4a1 1 0 0 1 -.993 -.883l-.007 -.117v-6h-2a1 1 0 0 1 -.993 -.883l-.007 -.117v-4a1 1 0 0 1 .883 -.993l.117 -.007h2v-1a6 6 0 0 1 5.775 -5.996l.225 -.004h3z" /></svg>',
                                        'name'=>'فيسبوك',
                                        'name_en'=>'Facebook',
                                        'showElm' => true,
                                        'editing' => false,
                                    ],
                                    'twitter'=>[
                                        'show'=>false,
                                        'link'=>'https://twitter.com',
                                        'logo'=>'<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-brand-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4l11.733 16h4.267l-11.733 -16z" /><path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" /></svg>',
                                        'name'=>'تويتر',
                                        'name_en'=>'Twitter',
                                        'showElm' => false,
                                        'editing' => false,
                                    ],
                                    'whatsapp'=>[
                                        'show'=>true,
                                        'link'=>'https://whatsapp.com',
                                        'logo'=>'<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-brand-x"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 4l11.733 16h4.267l-11.733 -16z" /><path d="M4 20l6.768 -6.768m2.46 -2.46l6.772 -6.772" /></svg>',
                                        'name'=>'واتساب',
                                        'name_en'=>'Whatsapp',
                                        'showElm' => false,
                                        'editing' => false,
                                    ],
                                ];
        
                        $socialLinks = json_decode(get_setting('socialLinks', json_encode($defultLinks)), true);
                    @endphp
        
                    <div class="my-4">
                        @forelse ($socialLinks as $index => $link)
                            @if (isset($link['show']) && $link['show'])
                                
                                <div class="mb-3 p-4 shadow-sm rounded" style="background: #e6eff5">
                                    <div class="d-flex align-items-center justify-content-between">
                                        {!! $link['logo'] !!}
                                        <b>{{ $link['name'] }}</b>
                                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-circles"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M6.5 17m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M17.5 17m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /></svg>
                                    </div>
                                </div>
                            @endif
                        @empty
                            
                        @endforelse
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-newSocialLink" tabindex="-1" aria-labelledby="modal-newSocialLinkLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-newSocialLinkLabel">{{ __('Add a new social link') }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Unique Name Field -->
                    <div class="mb-3">
                        <label for="unique_name" class="form-label">{{ __('Unique Name') }}</label>
                        <input class="form-control" type="text" id="unique_name" wire:model="unique_name" required>
                        @error('unique_name')
                            <small class="invalid-feedback d-block">{{ $message }}</small>
                        @enderror
                    </div>
    
                    <!-- Name Field -->
                    <div class="mb-3">
                        <label for="name" class="form-label">{{ __('Link Name (Arabic)') }}</label>
                        <input class="form-control" type="text" id="name" wire:model="name" required>
                        @error('name')
                            <small class="invalid-feedback d-block">{{ $message }}</small>
                        @enderror
                    </div>
    
                    <!-- Name in English Field -->
                    <div class="mb-3">
                        <label for="name_en" class="form-label">{{ __('Link Name (English)') }}</label>
                        <input class="form-control" type="text" id="name_en" wire:model="name_en" required>
                        @error('name_en')
                            <small class="invalid-feedback d-block">{{ $message }}</small>
                        @enderror
                    </div>
    
                    <!-- Link Field -->
                    <div class="mb-3">
                        <label for="link" class="form-label">{{ __('URL') }}</label>
                        <input class="form-control" type="url" id="link" wire:model="link" required>
                        @error('link')
                            <small class="invalid-feedback d-block">{{ $message }}</small>
                        @enderror
                    </div>
    
                    <!-- Icon Field -->
                    <div class="mb-3">
                        <label for="icon" class="form-label">{{ __('Icon (SVG or Class)') }}</label>
                        <input class="form-control" type="text" id="icon" wire:model="icon" required>
                        @error('icon')
                            <small class="invalid-feedback d-block">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-primary" wire:click="addSocialLink">{{ __('Save') }}</button>
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
        // استهداف الزر والرابط
        const copyButton = document.getElementById('copy-button');
        const linkToCopy = document.getElementById('link-to-copy').href;

        // إضافة حدث عند النقر
        copyButton.addEventListener('click', () => {
            // إنشاء عنصر مؤقت لنسخ النص
            const tempInput = document.createElement('input');
            tempInput.value = linkToCopy;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy'); // تنفيذ النسخ
            document.body.removeChild(tempInput);

            // تغيير نص الزر بعد النسخ
            copyButton.textContent = 'تم النسخ!';
            copyButton.classList.remove('btn-outline-success');
            copyButton.classList.add('btn-success');

            // إعادة النص الأصلي بعد فترة قصيرة
            setTimeout(() => {
                copyButton.textContent = 'نسخ الرابط';
                copyButton.classList.remove('btn-success');
                copyButton.classList.add('btn-outline-success');
            }, 2000);
        });

        Dropzone.autoDiscover = false;
        document.addEventListener('DOMContentLoaded', function () {
            let logoDropzone = new Dropzone("#image-upload", {
                url: "{{ route('te.dropzone.store') }}",
                acceptedFiles: 'image/*',
                addRemoveLinks: true,
                success: function (file, response) {
                    console.log(response);
                    document.getElementById('logo-image').src = response.image_url; // تحديث الصورة بعد رفع اللوجو الجديد
                    @this.saveImaages('logo', response);
                }
            });
        });
    </script>
</div>
