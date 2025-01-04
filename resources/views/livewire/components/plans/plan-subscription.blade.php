<div>
    <div class="row">
        <div class="col-md-8"><h1>{{ $plan->name }}</h1></div>
        <div class="col-md-4"></div>
    </div>
    {{-- <div>
        <h1>{{ $plan->name }}</h1>
        <p>{{ $plan->description }}</p>
    
        <h3>السعر</h3>
        <p>شهري: ${{ number_format($plan->monthly_price, 2) }}</p>
        <p>سنوي: ${{ number_format($plan->monthly_price * 12 * (1 - $plan->annual_discount / 100), 2) }} (خصم {{ $plan->annual_discount }}%)</p>
    
        @if (session()->has('message'))
            <div class="alert alert-success">
                {{ session('message') }}
            </div>
        @endif
    
        <form wire:submit.prevent="subscribe">
            <div class="form-group">
                <label for="subscriptionType">اختر نوع الاشتراك:</label>
                <select wire:model="subscriptionType" id="subscriptionType" class="form-control">
                    <option value="monthly">شهري</option>
                    <option value="annual">سنوي</option>
                </select>
            </div>
    
            <div class="form-group">
                <label for="name">اسمك:</label>
                <input type="text" wire:model="name" id="name" class="form-control">
            </div>
    
            <div class="form-group">
                <label for="email">البريد الإلكتروني:</label>
                <input type="email" wire:model="email" id="email" class="form-control">
            </div>
    
            <button type="submit" class="btn btn-primary">احصل على الباقة</button>
        </form>
    </div> --}}
</div>
