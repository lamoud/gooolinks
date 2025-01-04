<?php
namespace App\Services;

use App\Models\Plan;
use App\Models\Setting;
use App\Models\Tenant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Exception;

class TenantCreator
{
    public function createTenant(array $input, User $user): ?Tenant
    {
        try {
            $link = strtolower($input['link']);
            $tenant = Tenant::create([
                'id' => $link,
                'name' => $link,
                'user_id' => $user->id,
            ]);

            $domain = $link . '.' . request()->getHost();
            $tenant->domains()->create(['domain' => $domain]);

            return $tenant;
        } catch (Exception $e) {
            // تسجيل الخطأ أو التعامل معه
            \Log::error('Error creating tenant: ' . $e->getMessage());
            return null;
        }
    }
    
    public function createSeeder(Tenant $tenant)
    {
        try {
            Artisan::call('tenants:seed', [
                '--tenants' => [$tenant->id]
            ]);
        } catch (Exception $e) {
            // تسجيل الخطأ أو التعامل معه
            \Log::error('Error seeding tenant: ' . $e->getMessage());
        }
    }

    public function createAdmin(User $user, Tenant $tenant)
    {
        try {
            tenancy()->initialize($tenant);

            $admin = User::where('email', $user->email)->first();
            if (! $admin) {
                $usadmin = User::create([
                    'name'               => 'Admin',
                    'email'              => $user->email,
                    'email_verified_at'  => Carbon::now(),
                    'password'           => $user->password
                ]);

                $usadmin->assignRole('admin');
            } else {
                $admin->update([
                    'password'  => $user->password
                ]);

                $admin->assignRole('admin');
            }

            tenancy()->end();
        } catch (Exception $e) {
            // تسجيل الخطأ أو التعامل معه
            \Log::error('Error creating admin: ' . $e->getMessage());
            tenancy()->end(); // تأكد من إنهاء السياق حتى في حالة حدوث خطأ
        }
    }

    public function createSettings(string $link, Tenant $tenant)
    {
        try {
            tenancy()->initialize($tenant);

            $settings = [
                ['key' => 'site_name', 'value' => $link],
                ['key' => 'site_description', 'value' => $link],
                ['key' => 'site_logo', 'value' => ''],
                ['key' => 'site_icon', 'value' => ''],
            ];

            foreach ($settings as $setting) {
                Setting::updateOrCreate(['key' => $setting['key']], ['value' => $setting['value']]);
            }

            tenancy()->end();
        } catch (Exception $e) {
            // تسجيل الخطأ أو التعامل معه
            \Log::error('Error creating settings: ' . $e->getMessage());
            tenancy()->end(); // تأكد من إنهاء السياق حتى في حالة حدوث خطأ
        }
    }

    public function createSupscription(User $user, Tenant $tenant)
    {
        try {
            // محاولة إنشاء الاشتراك
            $plan = Plan::find(1); 
            $user->newSubscription('default', $plan->stripe_price_id)->create();
        } catch (Exception $e) {
            // إذا حدث أي خطأ
            return redirect()->back()->with('error', 'There was an error creating the subscription: ' . $e->getMessage());
        }
    }
}
