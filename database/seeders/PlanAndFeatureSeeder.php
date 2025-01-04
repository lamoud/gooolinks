<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Stripe\Price;
use Stripe\Product;

class PlanAndFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                // إدخال البيانات الخاصة بالميزات
                $features = [
                    ['name' => 'ميزات أساسية', 'description' => 'Description for Feature 1'],
                    ['name' => 'رابط واحد لكل ما تريد', 'description' => 'Description for Feature 2'],
                    ['name' => 'إحصاءات عامة عن آداء الرابط', 'description' => 'Description for Feature 3'],
                    ['name' => 'ثلاث دعوات فقط', 'description' => 'Description for Feature 4'],
                    ['name' => 'مشاركة الرابط', 'description' => 'Description for Feature 5'],
                    ['name' => 'تحكم في الروابط بشكل كامل', 'description' => 'Description for Feature 6'],
                    ['name' => '10 دعوات فقط', 'description' => 'Description for Feature 7'],
                    ['name' => 'عدد غير محدود من الدعوات', 'description' => 'Description for Feature 8'],
                ];
        
                foreach ($features as $feature) {
                    Feature::create($feature);
                }
        
                // إدخال البيانات الخاصة بالخطط
                $plans = [
                    [
                        'name' => 'الاصدار المجاني',
                        'slug' => Str::slug('الاصدار المجاني'),
                        'description' => 'مزايا محدودة لتكون متواجداً.',
                        'monthly_price' => 0,
                        'annual_discount' => 0,
                        'status' => 'published'
                    ],
                    [
                        'name' => 'الباقة الرئيسية',
                        'slug' => Str::slug('الباقة الرئيسية'),
                        'description' => 'طور أعمالك الشخصية وابدأ بتحقيق وصول أعلى.',
                        'monthly_price' => 7.00,
                        'annual_discount' => 20,
                        'status' => 'published'
                    ],
                    [
                        'name' => 'الأفضل',
                        'slug' => Str::slug('الأفضل'),
                        'description' => 'طور أعمالك وحقق أفضل النتائج المرجوة.',
                        'monthly_price' => 15.00,
                        'annual_discount' => 35,
                        'is_featured' => true,
                        'status' => 'published'
                    ],
                ];
        
                foreach ($plans as $plan) {
                    $createdPlan = Plan::create($plan);
        
                    // ربط كل خطة بكل الميزات مع حالة افتراضية
                    foreach (Feature::all() as $feature) {
                        $createdPlan->features()->attach($feature->id, ['status' => 'available']);
                    }
                    
                }
    }
}
