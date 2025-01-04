@extends('tenant.frontend/layouts/master')

@section('content')
<style>
    body {
        background: #f1f3f6;
    }

    .profile-card {
        background-color: #faf8fe;
        /* width: max-content;
        max-width: 500px; */
        margin: 0 auto;
        border-radius: 5%;
        
    }
</style>
    <div class="profile-card p-4 d-flex flex-column align-items-center text-center">
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

        <h2>{{ get_setting('person_company_name', 'اسم الشركة(الشخص)') }}</h2>
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
@endsection