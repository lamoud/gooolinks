<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Stripe\Price;
use Stripe\Product;

use Exception;

class Plan extends Model
{
    use HasFactory;
    use Sluggable;
    
    protected $fillable = [
        'name',
        'slug',
        'description',
        'monthly_price',
        'annual_discount',
        'is_featured',
        'status'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected static function booted()
    {
        static::saving(function ($plan) {
            if ($plan->is_featured) {
                // قم بإلغاء تمييز أي خطة أخرى مميزة
                static::where('is_featured', true)->where('id', '!=', $plan->id)->update(['is_featured' => false]);
            }
        });

        // إنشاء المنتج عند إنشاء خطة جديدة
        static::creating(function ($plan) {
            try {
                $product = Product::create([
                    'name' => $plan->name,
                    'description' => $plan->description,
                ]);

                // إنشاء خطة شهرية
                $monthlyPrice = Price::create([
                    'product' => $product->id,
                    'unit_amount' => $plan->monthly_price > 0 ? $plan->monthly_price * 100 : 0,
                    'currency' => 'usd',
                    'recurring' => ['interval' => 'month'],
                ]);

                // تحديث معرف المنتج في قاعدة البيانات
                $plan->stripe_product_id = $product->id;
                $plan->stripe_price_id = $monthlyPrice->id;
                
            } catch (Exception $e) {
                // التعامل مع الأخطاء
                \Log::error('Failed to create Stripe product: ' . $e->getMessage());
                throw new Exception('Error creating product in Stripe: ' . $e->getMessage());
            }
        });
        
                // تحديث المنتج عند تعديل الخطة
        // تحديث المنتج والسعر عند تعديل الخطة
        static::updating(function ($plan) {
            if ($plan->isDirty('name') || $plan->isDirty('description') || $plan->isDirty('monthly_price')) {
                try {
                    // استرجاع المنتج من Stripe
                    $product = Product::retrieve($plan->stripe_product_id);
                    
                    // تحديث معلومات المنتج
                    $product->name = $plan->name; // استخدام slug كاسم المنتج
                    $product->description = $plan->description;
                    $product->save(); // حفظ التغييرات

                    if( $plan->isDirty('monthly_price') ){
                        // تحديث سعر المنتج
                        //$price = Price::retrieve($plan->stripe_price_id); // استرجاع السعر الحالي باستخدام price_id
                        $newAmount = $plan->monthly_price > 0 ? $plan->monthly_price * 100 : 0;
                        
                        // إنشاء سعر جديد بدلاً من تحديث السعر الحالي
                        $newPrice = Price::create([
                            'product' => $plan->stripe_product_id,
                            'unit_amount' => $newAmount,
                            'currency' => 'usd',
                            'recurring' => [
                                'interval' => 'month',
                            ],
                        ]);
                        // تحديث stripe_price_id في نموذج Plan
                        $plan->stripe_price_id = $newPrice->id;
                    }
                    
                } catch (Exception $e) {
                    \Log::error('Failed to update Stripe product or price: ' . $e->getMessage());
                    throw new Exception('Error updating product or price in Stripe: ' . $e->getMessage());
                }
            }
        });
         // حذف المنتج من Stripe عند حذف الخطة
        // static::deleting(function ($plan) {
        //     try {
        //         // التحقق من وجود معرف المنتج في Stripe
        //         if ($plan->stripe_product_id) {
        //             // استرجاع جميع الأسعار المرتبطة بالمنتج
        //             $prices = Price::all(['product' => $plan->stripe_product_id]);

        //             // حذف كل سعر مرتبط بالمنتج
        //             foreach ($prices->data as $price) {
        //                 $price->delete();
        //             }

        //             // بعد حذف جميع الأسعار، حذف المنتج نفسه
        //             $product = Product::retrieve($plan->stripe_product_id);
        //             $product->delete();
        //         }
        //     } catch (Exception $e) {
        //         \Log::error('Failed to delete Stripe product or prices: ' . $e->getMessage());
        //         throw new Exception('Error deleting product or prices from Stripe: ' . $e->getMessage());
        //     }
        // });
    
    }

    public function features()
    {
        return $this->belongsToMany(Feature::class, 'plan_features')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}
