<?php

namespace App\Http\Controllers\SocialAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class AppleController extends Controller
{
    public function redirectToApple()
    {
        return Socialite::driver('apple')->redirect();
    }

    public function handleAppleCallback()
    {
        $user = Socialite::driver('apple')->user();
        $findUser = User::where('email', $user->email)->first();

        if ($findUser) {
            Auth::login($findUser);
        } else {
            $newUser = User::create([
                'name' => $user->name,
                'email' => $user->email,
                'apple_id' => $user->id,
                'password' => encrypt('my-apple'),
            ]);

            Auth::login($newUser);
        }

        return redirect()->intended('dashboard');
    }
}
