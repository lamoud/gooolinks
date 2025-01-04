<?php

namespace App\Livewire\Backend\Users;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Stripe\StripeClient;

class UsersTable extends DataTableComponent
{
    //protected $model = User::class;
    public function builder(): Builder
    {
        return User::query()->with('subscriptions');
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        

        return [
            Column::make(__('Serial Number'), "id")
                ->sortable()
                ->format(function($value) {
                    return 'EL-' . str_pad($value, 5, '0', STR_PAD_LEFT);
                }),
            Column::make(__('Profile Picture'), 'profile_photo_path')
                ->format(function ($value, $column, $row) {
                    $photoUrl = $column->profile_photo_url; 
                    return '<img src="' . $photoUrl . '" width="50" height="50" alt="Profile Picture" class="rounded-circle">';
                })
                ->html(),
                Column::make(__('Name'), "name")
                ->sortable()
                ->searchable()
                ->format(function($value) {
                    return Str::limit($value, 12); // حصر الاسم إلى 10 أحرف
                }),

            Column::make(__('Email'), "email")
                ->sortable()
                ->searchable()
                ->format(function($value) {
                    $limitedEmail = Str::limit($value, 12); // حصر البريد الإلكتروني إلى 10 أحرف
                    return '<a href="mailto:' . $value . '">' . $limitedEmail . '</a>'; // تحويل البريد الإلكتروني إلى رابط
                })
                ->html(),
            Column::make(__('Subscription'))
                ->label(function ($row) {
                    if ($row->subscribed('default')) {
                        $subscription = $row->subscription('default');
                        $stripe = new StripeClient(config('cashier.secret'));
                        $price = $stripe->prices->retrieve($subscription->stripe_price);
                        $product = $stripe->products->retrieve($price->product);
                        return Str::limit($product->name, 15) ?? __('Unknown');
                    }
                    return __('Not subscribed');
                }),
            Column::make(__('Date of Joining'), "created_at")
                ->sortable()
                ->format(function($value) {
                    return Carbon::parse($value)->translatedFormat('j F Y');
                }),

            Column::make(__('Last Updated'), "updated_at")
                ->sortable()
                ->deselected()
                ->format(function($value) {
                    return Carbon::parse($value)->translatedFormat('j F Y');
                }),
            Column::make(__('Actions'))
                ->label(function ($row) {
                    return view('livewire.backend.users.actions.actions', ['row' => $row]); // قم بإنشاء view خاص بالإجراءات
                })
        ];

    }


    public function show($id)
    {
        dd('User data');
    }

    public function delete($id)
    {
        return $this->dispatch('deleteUser', id: $id, type: 'question', msg: 'هل ترغب في حذف المستخدم؟');
    }

}
