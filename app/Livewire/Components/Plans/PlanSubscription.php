<?php

namespace App\Livewire\Components\Plans;
use App\Models\Plan;

use Livewire\Component;

class PlanSubscription extends Component
{
    public $plan;
    public $subscriptionType = 'monthly';
    public $name;
    public $email;

    public function mount(Plan $plan)
    {
        $this->plan = $plan;
    }

    public function subscribe()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subscriptionType' => 'required|in:monthly,annual',
        ]);

        // تنفيذ منطق الاشتراك هنا

        session()->flash('message', 'تم الاشتراك بنجاح!');
    }

    public function render()
    {
        return view('livewire.components.plans.plan-subscription');
    }
}
