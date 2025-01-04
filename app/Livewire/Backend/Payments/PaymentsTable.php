<?php

namespace App\Livewire\Backend\Payments;

use App\Models\Tenant;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Laravel\Cashier\Subscription;
use Stripe\StripeClient;
use Stripe\Stripe;
use Stripe\Price;

class PaymentsTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return Subscription::query()->select('*');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setEmptyMessage('No data');
        $this->setRememberColumnSelectionEnabled();
        $this->setDefaultSort('created_at', 'desc');
        $this->setHideBulkActionsWhenEmptyStatus(true);
        $this->setSearchDebounce(1000);
    }

    public function columns(): array
    {
        return [
            // Column::make(__('Link'), 'name')
            //     ->label(function($row) {
            //         $domain = $row->domain ?? config('app.url');
            //         $cleanDomain = str_replace(['http://', 'https://'], '', $domain);
            //         $url = "http://{$row->id}." . $cleanDomain;
                    
            //         return '<div class="d-flex align-items-center">
            //             <a href="' . $url . '" target="_blank" class="text-primary me-2">' . Str::limit($row->name, 15) . '</a>
            //         </div>';
            //     })
            //     ->html()
            //     ->sortable()
            //     ->searchable(function(Builder $query, $searchTerm) {
            //         $query->where('id', 'like', '%' . $searchTerm . '%')
            //               ->orWhere('name', 'like', '%' . $searchTerm . '%');
            //     }),
            // Column::make(__('Owner'))
            //     ->label(function($row) {
            //         if ($row->owner) {
            //             $name = Str::limit($row->owner->name, 15);
            //             $avatar = $row->owner->profile_photo_url ?? 'default-avatar.png'; // ضع مسار الصورة الافتراضية هنا
            //             return '<div class="d-flex align-items-center">
            //                         <img src="' . $avatar . '" alt="' . $name . '" class="rounded-circle me-2" style="width: 50px; height: 50px;">
            //                         <span>' . $name . '</span>
            //                     </div>';
            //         }
            //         return 'N/A';
            //     })
            //     ->html()
            //     ->sortable()
            //     ->searchable(function(Builder $query, $searchTerm) {
            //         $query->whereHas('owner', function($query) use ($searchTerm) {
            //             $query->where('name', 'like', '%' . $searchTerm . '%');
            //         });
            //     }),
            // Column::make(__('Subscription'))
            //     ->label(function ($row) {
            //         $owner = $row->owner;
            //         if ($owner && $owner->subscribed('default')) {
            //             $subscription = $owner->subscription('default');
            //             $stripe = new StripeClient(config('cashier.secret'));
            //             $price = $stripe->prices->retrieve($subscription->stripe_price);
            //             $product = $stripe->products->retrieve($price->product);
            //             return Str::limit($product->name, 15) ?? __('Unknown');
            //         }
            //         return __('Not subscribed');
            //     }),
            Column::make(__('User'), 'user_id') // اسم العمود في قاعدة البيانات
                ->sortable()
                ->format(function($value, $row) {
                    if( $row->owner ){

                        $name = Str::limit($row->owner->name, 15);
                        $avatar = $row->owner->profile_photo_url ?? 'default-avatar.png';

                        return '<div class="d-flex align-items-center">
                                    <img src="' . $avatar . '" alt="' . $name . '" class="rounded-circle me-2" style="width: 50px; height: 50px;">
                                    <span>' . $name . '</span>
                                </div>';
                    }else{
                        return 'N/A';
                    }
                })
                ->html(),
            Column::make(__('Price'), 'stripe_price')
                ->sortable()
                ->format(function($value, $row) {
                    try {
                        // جلب السعر من Stripe باستخدام معرف السعر
                        $price = Price::retrieve($value);
                        $amount = $price->unit_amount / 100; // تحويل السعر إلى الدولار
                        
                        return number_format($amount, 2) . ' $';
                    } catch (\Exception $e) {
                        // في حال فشل الطلب أو عدم صحة معرف السعر
                        return '<span class="text-muted">غير متاح</span>';
                    }
                })
                ->html(),
            Column::make(__('Status'), "stripe_status")
                ->sortable()
                ->format(function($value) {
                    switch ($value) {
                        case 'active':
                            return '<span class="badge bg-success">نشط</span>';
                        case 'canceled':
                            return '<span class="badge bg-danger">ملغي</span>';
                        case 'trialing':
                            return '<span class="badge bg-warning text-dark">فترة تجريبية</span>';
                        case 'past_due':
                            return '<span class="badge bg-secondary">متأخر</span>';
                        default:
                            return '<span class="badge bg-light text-dark">' . htmlspecialchars($value) . '</span>';
                    }
                })
                ->html(),
            Column::make(__('Last Updated'), "updated_at")
                ->sortable()
                ->format(function($value) {
                    return Carbon::parse($value)->translatedFormat('j F Y');
                }),
            Column::make(__('Date of Joining'), "created_at")
                ->sortable()
                ->format(function($value) {
                    return Carbon::parse($value)->translatedFormat('j F Y');
                })
        ];
    }

    public function manageLink($id)
    {
        return $this->dispatch('manageLink', id: $id);
    }

    public function deleteLink($id)
    {
        return $this->dispatch('deleteLink', id: $id, type: 'question', msg: 'هل ترغب في حذف الرابط؟');
    }
}