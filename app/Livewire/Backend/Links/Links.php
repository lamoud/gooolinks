<?php

namespace App\Livewire\Backend\Links;

use App\Models\MagicLink;
use App\Models\Tenant;
use App\Models\User;
use App\Services\TenantCreator;
use Livewire\Component;
use Laravel\Fortify\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Links extends Component
{
    public $name;
    public $email;
    public $password;
    public $link;

    public function saveLink()
    {
        $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'link' => [
                'required',
                'string',
                'min:3',
                'max:20',
                'unique:tenants,id',
                'regex:/^[a-zA-Z]+$/',
            ],
        ]);

        $user = User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $input = [];
        $input['link'] = $this->link;
        if ( ! tenant('id') ) {
            $tenantCreator = new TenantCreator();
            $tenant = $tenantCreator->createTenant($input, $user);
            $tenantCreator->createSeeder($tenant);
            $tenantCreator->createAdmin($user, $tenant);
            $tenantCreator->createSettings($input['link'], $tenant);
            $tenantCreator->createSupscription($user, $tenant);
        }

        $this->dispatch('refreshDatatable');
        return $this->dispatch('makeAction', type: 'success', id: 'modal-newlink', title: __('Ok'), msg: 'تم إضافة الرابط بنجاح!');

    }

    protected function passwordRules()
    {
        return (new Password)->length(8); // الحد الأدنى لطول كلمة المرور
                    // ->requireUppercase() // تطلب حرفًا كبيرًا واحدًا
                    // ->requireNumeric() // تطلب رقمًا واحدًا
                    // ->requireSpecialCharacter(); // تطلب حرفًا خاصًا مثل @ أو #
    }

    public function delete_link($id)
    {
        Tenant::find($id)->delete();
        $this->dispatch('refreshDatatable');
        return $this->dispatch('makeAction', type: 'success', title: __('Ok'), msg: 'تم حذف الرابط بنجاح!');

    }

    public function generateMagicLink($tenantId)
    {
        // جلب البريد الإلكتروني للمستخدم الحالي
        $email = Auth::user()->email;
    
        // التحقق من صحة الـ tenantId
        $tenant = Tenant::find($tenantId);
        if (!$tenant) {
            return $this->dispatch('makeAction', type: 'error', title: __('Error'), msg: 'المستأجر غير موجود.');
        }
    
        // حذف الروابط القديمة لنفس المستخدم والمستأجر
        MagicLink::where('email', $email)
            ->where('tenant_id', $tenantId)
            ->delete();
    
        // إنشاء رابط جديد
        $token = Str::random(40);
        $expiresAt = Carbon::now()->addMinutes(15);
    
        MagicLink::create([
            'email' => $email,
            'token' => $token,
            'tenant_id' => $tenantId,
            'expires_at' => $expiresAt,
        ]);
    
        // جلب النطاق الخاص بالمستأجر
        $tenantDomain = $tenant->domains()->first();
    
        if (!$tenantDomain) {
            return $this->dispatch('makeAction', type: 'error', title: __('Error'), msg: 'لا يوجد نطاق لهذا المستأجر.');
        }
    
        // بناء الرابط باستخدام البروتوكول المناسب
        $protocol = request()->secure() ? 'https://' : 'http://';
        $magicLinkUrl = "{$protocol}{$tenantDomain->domain}/magic-login/{$token}";
    
        // إرسال رسالة النجاح وتوجيه المستخدم للرابط
        return $this->dispatch('makeRedirect', type: 'success', url: $magicLinkUrl, title: __('Ok'), msg: 'جاري توجيهك للرابط وتسجيل الدخول...');
    }

    public function render()
    {
        return view('livewire.backend.links.links');
    }
}
