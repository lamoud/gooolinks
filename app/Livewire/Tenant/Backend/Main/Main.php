<?php

namespace App\Livewire\Tenant\Backend\Main;

use Livewire\Component;
use Stancl\Tenancy\Tenant;


class Main extends Component
{
    public $socilLinksShow = true;
    public $headerElemShow = true;
    public $socialLinks = [];

    public $site_facebook;
    public $facebookElmShow = true;
    public $facebookShow;
    public $facebookEditing = false;

    public $site_twitter;
    public $twitterElmShow = true;
    public $twitterShow;
    public $twitterEditing = false;

    public $site_whatsapp;
    public $whatsappElmShow = true;
    public $whatsappShow;
    public $whatsappEditing = false;

    public $site_instagram;
    public $instagramElmShow = true;
    public $instagramShow;
    public $instagramEditing = false;

    public $site_tiktok;
    public $tiktokElmShow = true;
    public $tiktokShow;
    public $tiktokEditing = false;

    public $site_linkedin;
    public $linkedinElmShow = true;
    public $linkedinShow;
    public $linkedinEditing = false;

    public $site_youtube;
    public $youtubeElmShow = true;
    public $youtubeShow;
    public $youtubeEditing = false;

    public $site_website;
    public $websiteElmShow = true;
    public $websiteShow;
    public $websiteEditing = false;

    public $unique_name;
    public $name;
    public $name_en;
    public $link;
    public $icon;

    public $personCompanyLogo;
    public $personCompanyName;
    public $workField;
    public $marketingText;

    public function addSocialLink()
    {
        $this->validate([
            'unique_name' => 'required|alpha_dash',
            'name' => 'required|string|max:255',
            'name_en' => 'required|string|max:255',
            'link' => 'required|url',
            'icon' => 'required|string|max:1024',
        ]);

        if (array_key_exists($this->unique_name, $this->socialLinks)) {
            // إرجاع خطأ في حالة وجود الاسم الفريد
            $this->addError('unique_name', __('The unique name already exists in social links.'));
            return;
        }

        $index = $this->unique_name;
        // حفظ البيانات في قاعدة البيانات
        $this->socialLinks[$index] = [
            'show'=>true,
            'name' => $this->name,
            'name_en' => $this->name_en,
            'link' => $this->link,
            'logo' => $this->icon,
            'showElm' => true,
            'editing' => false,
        ];

        $this->saveSocialLink($index);
        $this->reset();
        $this->mount();
    }

    public function toggleElementsShow($index)
    {
        if( $index == 'socilLinksShow'){
            $this->socilLinksShow = !$this->socilLinksShow;
            return;
        }
        if( $index == 'headerElemShow'){
            $this->headerElemShow = !$this->headerElemShow;
            return;
        }

        if (!isset($this->socialLinks[$index])) {

            return $this->dispatch('makeAction', type: 'error', title: __('Error'), msg: __('Social link not found.'));
        }

        $this->socialLinks[$index]['showElm'] = !$this->socialLinks[$index]['showElm'];
        $this->saveSocialLink($index);
    }

    public function toggleEditing($index)
    {
        $this->socialLinks[$index]['editing'] = !$this->socialLinks[$index]['editing'];
        //$this->saveSocialLink($index);
    }

    public function updateSocialVisibility($index, $show)
    {
        $this->socialLinks[$index]['show'] = $show;
        $this->saveSocialLink($index);
    }
    public function saveSocialLink($index = null)
    {
        // تحقق من صحة الفهرس
        if ($index === null || !isset($this->socialLinks[$index])) {
            return $this->dispatch('makeAction', type: 'error', title: __('Error'), msg: 'فهرس غير صالح!');
        }
    
        // استرجاع الروابط الاجتماعية الحالية من قاعدة البيانات
        $social = json_decode(get_setting('socialLinks', '[]'), true);
    
        // تعطيل وضع التعديل للعنصر الحالي
        $this->socialLinks[$index]['editing'] = false;
        // تحديث العنصر المحدد
        $social[$index] = $this->socialLinks[$index];
        
        // حفظ الروابط المحدثة

        set_setting('socialLinks', json_encode($social));
        // رسالة نجاح
        $this->mount();
        return $this->dispatch('makeAction', type: 'success', modal: '#modal-newSocialLink', title: __('Ok'), msg: 'تم تحديث وسائل الاتصال بنجاح!');
    }
    
    public function deleteSocialLink($index)
    {
        // التحقق من وجود الرابط في المصفوفة
        if (isset($this->socialLinks[$index])) {
            unset($this->socialLinks[$index]); // حذف الرابط من المصفوفة
            
            // تحديث البيانات في قاعدة البيانات
            set_setting('socialLinks', json_encode($this->socialLinks));
    
            // رسالة نجاح
            return $this->dispatch('makeAction', type: 'success', title: __('Ok'), msg: __('Social link deleted successfully!'));
        }
    
        // رسالة خطأ إذا لم يكن الرابط موجودًا
        return $this->dispatch('makeAction', type: 'error', title: __('Error'), msg: __('Social link not found.'));
    }
    
    public function saveHeaderData()
    {
        $this->validate([
            'personCompanyName' => 'required|string|max:255',
            'workField' => 'required|string|max:255',
            'marketingText' => 'nullable|string',
        ]);
    
        // تنفيذ عملية الحفظ
        set_setting('person_company_name', $this->personCompanyName);
        set_setting('work_field', $this->workField);
        set_setting('marketing_text', $this->marketingText);
    
        // إعادة ضبط الحقول بعد الحفظ
        $this->reset();
        $this->mount();
    
        // رسالة نجاح
        $this->dispatch('makeAction', type: 'success', modal: '#modal-newSocialLink', title: __('Ok'), msg: __('Header data saved successfully!'));

    }
    
    
    public function saveImaages($type, $response)
    {
        if (!$response) {
            return $this->dispatch('userAction', type: 'error', title: __('Error'), msg: 'لم يتم رفع الملف!');
        }
    
        // تحديد متغير يحتوي على رابط الصورة القديمة
        $oldImage = null;
    
        if ($type === 'logo') {
            $oldImage = $this->personCompanyLogo; // احصل على رابط الصورة القديمة
            set_setting('person_company_avatar', $response['image_url']);
        }
    
        // حذف الصورة القديمة إذا كانت موجودة
        if ($oldImage && file_exists(public_path($oldImage))) {
            unlink(public_path($oldImage)); // حذف الصورة القديمة
        }

        $this->reset();
        $this->mount();
    
        // رسالة نجاح
        return $this->dispatch('makeAction', type: 'success', title: __('Ok'), msg: 'تم حفظ الإعدادات بنجاح!');
    }

    public function mount()
    {
        // $this->site_facebook = get_setting('site_facebook', 'https://facebook.com');
        // $this->site_twitter = get_setting('site_twitter', 'https://twitter.com');
        // $this->site_whatsapp = get_setting('site_whatsapp', '0123456789');
        // $this->site_instagram = get_setting('site_instagram', 'https://link.com');
        // $this->site_tiktok = get_setting('site_tiktok', 'https://tiktok.com');
        // $this->site_linkedin = get_setting('site_linkedin', 'https://linkedin.com');
        // $this->site_youtube = get_setting('site_youtube', 'https://youtube.com');
        // $this->site_website = get_setting('site_website', 'https://website.com');


        $this->personCompanyLogo = get_setting('person_company_avatar', Auth()->user()->profile_photo_url);
        $this->personCompanyName = get_setting('person_company_name', Auth()->user()->name);
        $this->workField = get_setting('work_field', 'مدرب كمال أجسام');
        $this->marketingText = get_setting('marketing_text', 'نص تسويقي مصغر عن ما يقوم به الشخص أو الشركة ما يصف عمله بشكل مختصر');
        
        $defultLinks = 
        [
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

        $this->socialLinks = json_decode(get_setting('socialLinks', json_encode($defultLinks)), true);

        //dd($this->socialLinks);

    }

    public function render()
    {
        $currentTenant = tenancy()->tenant;
        
        // الحصول على اسم النطاق الافتراضي
        $domain = $row->domain ?? config('app.url');
        
        // تنظيف اسم النطاق من 'http://' و 'https://'
        $cleanDomain = str_replace(['http://', 'https://'], '', $domain);
        
        // تحديد البروتوكول المناسب بناءً على دعم HTTPS
        $protocol = request()->isSecure() ? 'https' : 'http';
        
        // إنشاء الرابط الكامل
        $url = "{$protocol}://{$currentTenant->id}.{$cleanDomain}";
    
        return view('livewire.tenant.backend.main.main', [
            'tenantUrl' => $url,
        ]);
    }
    
}
