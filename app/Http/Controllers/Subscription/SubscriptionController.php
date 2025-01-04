<?php

namespace App\Http\Controllers\Subscription;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function show()
    {
        return view('subscription');
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $paymentMethod = $request->paymentMethod;

        $user->createOrGetStripeCustomer();
        $user->addPaymentMethod($paymentMethod);

        $user->newSubscription('default', 'plan-id')->create($paymentMethod);

        return redirect()->route('subscription.success');
    }

    public function success()
    {
        return view('subscription-success');
    }

    public function failure()
    {
        return view('subscription-failure');
    }
}
