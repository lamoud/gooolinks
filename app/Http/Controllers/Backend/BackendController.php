<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use App\Models\Visit;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use RalphJSmit\Laravel\SEO\Support\SEOData;
use Stancl\Tenancy\Facades\Tenancy;
use Illuminate\Support\Str;
use Laravel\Cashier\Subscription;
use Laravel\Cashier\SubscriptionItem;

class BackendController extends Controller
{
    // public function dashboard()
    // {


    //     return view('backend.dashboard.dashboard');
    // }

    public function dashboard()
    {
        $title = __('Dashboard');
        $pageType = 'dashboard';
    
        // حساب عدد المستخدمين
        $totalUsers = User::count();
    
        // حساب عدد المستخدمين الجدد هذا الشهر
        $currentMonthUsers = User::where('created_at', '>=', now()->startOfMonth())->count();
    
        // حساب عدد المستخدمين في الأشهر السابقة
        $previousUsers = $totalUsers - $currentMonthUsers;
    
        // حساب نسبة النمو أو الانخفاض في عدد المستخدمين
        $userGrowthRate = $previousUsers > 0
            ? round(($currentMonthUsers / $previousUsers) * 100, 2)
            : ($currentMonthUsers > 0 ? 100 : 0);
    
        // حساب عدد الاشتراكات
        $totalSubscriptions = Subscription::count();
    
        // حساب عدد الاشتراكات الجديدة هذا الشهر
        $currentMonthSubscriptions = Subscription::where('created_at', '>=', now()->startOfMonth())->count();
    
        // حساب عدد الاشتراكات في الأشهر السابقة
        $previousSubscriptions = $totalSubscriptions - $currentMonthSubscriptions;
    
        // حساب نسبة النمو أو الانخفاض في الاشتراكات
        $subscriptionGrowthRate = $previousSubscriptions > 0
            ? round(($currentMonthSubscriptions / $previousSubscriptions) * 100, 2)
            : ($currentMonthSubscriptions > 0 ? 100 : 0);
    
        // حساب إجمالي المدفوعات
        $totalPayments = 0;
        $currentMonthPayments = 0;
    
        // جلب جميع العناصر في جدول الاشتراكات
        $subscriptionItems = SubscriptionItem::all();
    
        foreach ($subscriptionItems as $item) {
            try {
                // استدعاء السعر من Stripe باستخدام stripe_price
                $stripePrice = \Stripe\Price::retrieve($item->stripe_price);
    
                // إذا كان السعر صحيحاً، أضفه إلى إجمالي المدفوعات
                if ($stripePrice && isset($stripePrice->unit_amount)) {
                    $payment = $stripePrice->unit_amount / 100; // تحويل من سنتات إلى عملة أساسية
                    $totalPayments += $payment;
    
                    // حساب المدفوعات الجديدة هذا الشهر
                    if ($item->created_at >= now()->startOfMonth()) {
                        $currentMonthPayments += $payment;
                    }
                }
            } catch (\Exception $e) {
                \Log::error("Error retrieving Stripe price: " . $e->getMessage());
            }
        }
    
            // حساب نسبة النمو أو الانخفاض في المدفوعات
            $previousPayments = $totalPayments - $currentMonthPayments;
            $paymentGrowthRate = $previousPayments > 0
                ? round(($currentMonthPayments / $previousPayments) * 100, 2)
                : ($currentMonthPayments > 0 ? 100 : 0);
        
            // حساب عدد الزيارات
            $totalVisits = Visit::count();
        
            // حساب عدد الزيارات هذا الشهر
            $currentMonthVisits = Visit::where('created_at', '>=', now()->startOfMonth())->count();
        
            // حساب عدد الزيارات في الأشهر السابقة
            $previousVisits = $totalVisits - $currentMonthVisits;
        
            // حساب نسبة النمو أو الانخفاض في الزيارات
            $visitGrowthRate = $previousVisits > 0
                ? round(($currentMonthVisits / $previousVisits) * 100, 2)
                : ($currentMonthVisits > 0 ? 100 : 0);
        
            // إعداد بيانات SEO
            $SEOData = new SEOData(
                title: $title,
                description: get_setting('site_description'),
                author: get_setting('site_name'),
                site_name: get_setting('site_name'),
                image: get_setting('site_logo'),
            );
        
    // بيانات الاشتراكات الأسبوعية
    $weeklySubscriptions = [];
    $weeklyNewUsers = [];

    // الأيام من السبت إلى الجمعة
    $daysOfWeek = [
        'Saturday' => 'سبت',
        'Sunday' => 'أحد',
        'Monday' => 'إثنين',
        'Tuesday' => 'ثلاثاء',
        'Wednesday' => 'أربعاء',
        'Thursday' => 'خميس',
        'Friday' => 'جمعة'
    ];

    // تكرار لحساب البيانات لكل يوم
    foreach ($daysOfWeek as $englishDay => $arabicDay) {
        $startOfDay = now()->startOfWeek()->modify($englishDay)->startOfDay();
        $endOfDay = now()->startOfWeek()->modify($englishDay)->endOfDay();

        // الاشتراكات لكل يوم
        $dailySubscriptions = Subscription::whereBetween('created_at', [$startOfDay, $endOfDay])->count();
        $weeklySubscriptions[] = $dailySubscriptions;

        // المستخدمين الجدد لكل يوم
        $dailyNewUsers = User::whereBetween('created_at', [$startOfDay, $endOfDay])->count();
        $weeklyNewUsers[] = $dailyNewUsers;
    }

    // تمرير البيانات إلى العرض
    return view('backend.dashboard.dashboard', compact(
        'title',
        'SEOData',
        'totalUsers',
        'userGrowthRate',
        'totalSubscriptions',
        'subscriptionGrowthRate',
        'totalPayments',
        'paymentGrowthRate',
        'totalVisits',
        'visitGrowthRate',
        'weeklySubscriptions',
        'weeklyNewUsers',
        'pageType'
    ));

    }
    
    
    


    public function plans()
    {

        $title = __('Plans and Packages');
        $pageType = 'admin.plans';
        $SEOData = new SEOData(
            title: $title,
            description: get_setting('site_description'),
            author: get_setting('site_name'),
            site_name: get_setting('site_name'),
            image: get_setting('site_logo'),
        );

        return view('backend.plans.plans', compact(
            'SEOData',
            'pageType',
            'title'
        ));
    }
    public function users()
    {

        $title = __('Users');
        $pageType = 'admin.users';
        $SEOData = new SEOData(
            title: $title,
            description: get_setting('site_description'),
            author: get_setting('site_name'),
            site_name: get_setting('site_name'),
            image: get_setting('site_logo'),
        );

        return view('backend.users.users', compact(
            'SEOData',
            'pageType',
            'title'
        ));
    }
    public function payments()
    {

        $title = __('Payments');
        $pageType = 'admin.payments';
        $SEOData = new SEOData(
            title: $title,
            description: get_setting('site_description'),
            author: get_setting('site_name'),
            site_name: get_setting('site_name'),
            image: get_setting('site_logo'),
        );

        return view('backend.payments.payments', compact(
            'SEOData',
            'pageType',
            'title'
        ));
    }
    public function links()
    {

        $title = __('Links');
        $pageType = 'admin.links';
        $SEOData = new SEOData(
            title: $title,
            description: get_setting('site_description'),
            author: get_setting('site_name'),
            site_name: get_setting('site_name'),
            image: get_setting('site_logo'),
        );

        return view('backend.links.links', compact(
            'SEOData',
            'pageType',
            'title'
        ));
    }
    public function stafRoles()
    {

        $title = __('Staff and Roles');
        $pageType = 'admin.stafroles';
        $SEOData = new SEOData(
            title: $title,
            description: get_setting('site_description'),
            author: get_setting('site_name'),
            site_name: get_setting('site_name'),
            image: get_setting('site_logo'),
        );

        return view('backend.staff_roles.staff_roles', compact(
            'SEOData',
            'pageType',
            'title'
        ));
    }
    public function settings()
    {

        $title = __('Settings');
        $pageType = 'admin.settings';
        $SEOData = new SEOData(
            title: $title,
            description: get_setting('site_description'),
            author: get_setting('site_name'),
            site_name: get_setting('site_name'),
            image: get_setting('site_logo'),
        );

        return view('backend.settings.settings', compact(
            'SEOData',
            'pageType',
            'title'
        ));
    }
    
}
