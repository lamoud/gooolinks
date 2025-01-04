<?php

namespace App\Livewire\Components\Plans;

use App\Models\Plan;
use Livewire\Component;
use Illuminate\Support\Facades\DB;


class Plans extends Component
{
    public $plans;
    public $averageDiscount;

    public function mount()
    {
        $this->plans =Plan::where('status', 'published')->get();
        $this->averageDiscount = Plan::where('status', 'published')
        ->where('annual_discount', '>', 0)
        ->avg('annual_discount');
    }

    public function render()
    {
        return view('livewire.components.plans.plans');
    }
}