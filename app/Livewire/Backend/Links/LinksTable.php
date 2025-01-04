<?php

namespace App\Livewire\Backend\Links;

use App\Models\Tenant;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Stripe\StripeClient;

class LinksTable extends DataTableComponent
{
    public function builder(): Builder
    {
        return Tenant::query()->select('*');
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
            Column::make(__('Link'), 'name')
                ->label(function($row) {
                    $domain = $row->domain ?? config('app.url');
                    $cleanDomain = str_replace(['http://', 'https://'], '', $domain);
                    $url = "http://{$row->id}." . $cleanDomain;
                    
                    return '<div class="d-flex align-items-center">
                        <a href="' . $url . '" target="_blank" class="text-primary me-2">' . Str::limit($row->name, 15) . '</a>
                    </div>';
                })
                ->html()
                ->sortable()
                ->searchable(function(Builder $query, $searchTerm) {
                    $query->where('id', 'like', '%' . $searchTerm . '%')
                          ->orWhere('name', 'like', '%' . $searchTerm . '%');
                }),
            Column::make(__('Owner'))
                ->label(function($row) {
                    if ($row->owner) {
                        $name = Str::limit($row->owner->name, 15);
                        $avatar = $row->owner->profile_photo_url ?? 'default-avatar.png'; // ضع مسار الصورة الافتراضية هنا
                        return '<div class="d-flex align-items-center">
                                    <img src="' . $avatar . '" alt="' . $name . '" class="rounded-circle me-2" style="width: 50px; height: 50px;">
                                    <span>' . $name . '</span>
                                </div>';
                    }
                    return 'N/A';
                })
                ->html()
                ->sortable()
                ->searchable(function(Builder $query, $searchTerm) {
                    $query->whereHas('owner', function($query) use ($searchTerm) {
                        $query->where('name', 'like', '%' . $searchTerm . '%');
                    });
                }),
            Column::make(__('Subscription'))
                ->label(function ($row) {
                    $owner = $row->owner;
                    if ($owner && $owner->subscribed('default')) {
                        $subscription = $owner->subscription('default');
                        $stripe = new StripeClient(config('cashier.secret'));
                        $price = $stripe->prices->retrieve($subscription->stripe_price);
                        $product = $stripe->products->retrieve($price->product);
                        return Str::limit($product->name, 15) ?? __('Unknown');
                    }
                    return __('Not subscribed');
                }),
            Column::make(__('Last Updated'), "updated_at")
                ->sortable()
                ->deselected()
                ->format(function($value) {
                    return Carbon::parse($value)->translatedFormat('j F Y');
                }),

            Column::make(__('Actions'))
                ->label(function ($row) {
                    return view('livewire.backend.links.actions.link-actions', ['row' => $row]);
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