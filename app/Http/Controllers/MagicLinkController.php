<?php

namespace App\Http\Controllers;

use App\Models\MagicLink;
use App\Models\Tenant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Stancl\Tenancy\Facades\Tenancy;

class MagicLinkController extends Controller
{
    public function generate(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'tenant_id' => 'required',
        ]);

        $email = $request->email;
        $tenantId = $request->tenant_id;

        // حذف الروابط القديمة
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

        $tenant = Tenant::findOrFail($tenantId);
        
        // ضبط المستأجر الحالي وتوصيل القاعدة
        $tenantDomain = $tenant->domains()->first();
        if (!$tenantDomain) {
            abort(403, 'الرابط غير صالح أو غير موجود.');
        }
        // توليد رابط تسجيل الدخول
        $protocol = request()->secure() ? 'https://' : 'http://';
        $magicLinkUrl = $protocol . $tenantDomain->domain . '/magic-login/' . $token;

        // توجيه المستخدم إلى الرابط
        return Redirect::to($magicLinkUrl);
    }

    public function login($token)
    {
        // الوصول للقاعدة المركزية
        $magicLink = tenancy()->central(function () use ($token) {
            return MagicLink::where('token', $token)->first();
        });
    
        if (!$magicLink || Carbon::parse($magicLink->expires_at)->isPast()) {
            abort(403, 'الرابط غير صالح أو منتهي الصلاحية.');
        }
    
        // البحث عن المستأجر
        $tenant = tenancy()->find($magicLink->tenant_id);
        if (!$tenant) {
            abort(404, 'لم يتم العثور على المستأجر.');
        }
    
        try {
            // تعيين المستأجر
            tenancy()->initialize($tenant);
    
            // تسجيل الدخول
            $user = User::where('id', 1)->first();
            if ($user) {
                Auth::login($user, true);
                
                // حذف الرابط السحري من القاعدة المركزية
                tenancy()->central(function () use ($magicLink) {
                    $magicLink->delete();
                });
    
                return redirect('/dashboard');
            }
    
            abort(404, 'المستخدم غير موجود.');
        } finally {
            // إنهاء المستأجر
            tenancy()->end();
        }
    }
    
}
