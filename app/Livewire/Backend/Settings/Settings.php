<?php

namespace App\Livewire\Backend\Settings;

use App\Models\Setting;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Settings extends Component
{
    use WithFileUploads;

    public $site_logo;
    public $new_logo;
    public $site_name;
    public $email;
    public $phone;
    public $meta_tag;
    public $site_description;
    public $site_icon;

    public $facebook;
    public $instagram;
    public $twitter;
    public $whatsapp;

    public $site_mode;

    public function mount()
    {
        $this->site_logo = get_setting('site_logo', '');
        $this->site_name = get_setting('site_name', '');
        $this->email = get_setting('site_email', '');
        $this->phone = get_setting('site_phone', '');
        $this->meta_tag = get_setting('site_metatag', '');
        $this->site_description = get_setting('site_description', '');
        $this->site_icon = get_setting('site_icon', '');

        $this->facebook = get_setting('site_facebook', '');
        $this->instagram = get_setting('site_instagram', '');
        $this->twitter = get_setting('site_twitter', '');
        $this->whatsapp = get_setting('site_whatsapp', '');

        $this->site_mode = get_setting('site_mode', false);
        
    }

    public function saveImaages($type, $response)
    {
        if (!$response) {
            return $this->dispatch('userAction', type: 'error', title: __('Error'), msg: 'لم يتم رفع الملف!');
        }
    
        // تحديد متغير يحتوي على رابط الصورة القديمة
        $oldImage = null;
    
        if ($type === 'logo') {
            $oldImage = get_setting('site_logo'); // احصل على رابط الصورة القديمة
            set_setting('site_logo', $response['image_url']);
        }
    
        if ($type === 'icon') {
            $oldImage = get_setting('site_icon'); // احصل على رابط الصورة القديمة
            set_setting('site_icon', $response['image_url']);
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

    public function saveSiteSettings()
    {
        $this->validate([
            'site_name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'meta_tag' => 'nullable|string|max:255',
            'site_description' => 'nullable|string|max:1000',
        ]);
        
        // حفظ اللوجو إذا تم رفعه
        if ($this->new_logo) {

            $this->validate([
                'new_logo' => 'image|max:1024', // التحقق من أن الملف صورة وحجمه لا يتجاوز 1MB
            ]);

            $path = $this->new_logo->store('logos', 'public');
            $this->site_logo = Storage::url($path);
            set_setting('site_logo', $this->site_logo);
        }

        // حفظ باقي الإعدادات
        set_setting('site_name', $this->site_name);
        set_setting('site_email', $this->email);
        set_setting('site_phone', $this->phone);
        set_setting('site_metatag', $this->meta_tag);
        set_setting('site_description', $this->site_description);

        $this->reset();
        $this->mount();
        // رسالة نجاح
        return $this->dispatch('makeAction', type: 'success', title: __('Ok'), msg: 'تم حفظ الإعدادات بنجاح!');

    }

    public function saveSocialSettings()
    {
        $this->validate([
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'twitter' => 'nullable|url',
            'whatsapp' => 'nullable|string',
        ]);

        // قائمة الإعدادات
        $settings = [
            ['key' => 'site_facebook', 'value' => $this->facebook],
            ['key' => 'site_instagram', 'value' => $this->instagram],
            ['key' => 'site_twitter', 'value' => $this->twitter],
            ['key' => 'site_whatsapp', 'value' => $this->whatsapp],
        ];

        // حفظ أو تعديل الإعدادات
        foreach ($settings as $setting) {
            set_setting($setting['key'], $setting['value']);
        }

        $this->reset();
        $this->mount();
        // رسالة نجاح
        return $this->dispatch('makeAction', type: 'success', title: __('Ok'), msg: 'تم حفظ الإعدادات بنجاح!');

    }

    public function updatedSiteMode()
    {
        // تحديث حالة وضع الصيانة
        set_setting('site_mode', $this->site_mode == 'up' ? 'down' : 'up');

        // رسالة تنبيه عند التحديث
        $this->reset();
        $this->mount();
        return $this->dispatch('makeAction', type: 'success', title: __('Ok'), msg: $this->site_mode == 'down' ? 'تم تفعيل وضع الصيانة' : 'تم إيقاف وضع الصيانة');
    }
    public function render()
    {
        return view('livewire.backend.settings.settings');
    }
}
