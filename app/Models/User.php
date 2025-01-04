<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Cashier\Billable;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use Billable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    protected static function booted()
    {
        static::deleting(function ($user) {
            // التحقق مما إذا كان المستخدم لديه مستأجر
            $tenant = Tenant::where('user_id', $user->id)->first();
            
            if ($tenant) {
                // حذف المستأجر الخاص بالمستخدم
                try {
                    $tenant->delete();
                } catch (\Exception $e) {
                    \Log::error('Failed to delete tenant: ' . $e->getMessage());
                    throw new \Exception('Error deleting tenant: ' . $e->getMessage());
                }
            }

            // التحقق مما إذا كان لدى المستخدم اشتراك
            $subscription = $user->subscription('default'); // استخدم اسم الاشتراك المناسب لديك

            if ($subscription && $subscription->valid()) {
                // إلغاء اشتراك المستخدم
                try {
                    $subscription->cancelNow(); // إلغاء الاشتراك فورًا
                } catch (\Exception $e) {
                    \Log::error('Failed to cancel subscription: ' . $e->getMessage());
                    throw new \Exception('Error canceling subscription: ' . $e->getMessage());
                }
            }
        });
    }
    public function profile_photo_url()
    {
        return $this->avatar ? url('images/users_avatar/'.$this->avatar) : url("images/users_avatar/default_avatar.png");
    }
}
