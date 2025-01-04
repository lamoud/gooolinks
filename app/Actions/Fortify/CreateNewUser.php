<?php

namespace App\Actions\Fortify;

use App\Models\Setting;
use App\Models\Tenant;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

use App\Services\TenantCreator;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            'link' => [
                'required',
                'string',
                'min:3',
                'max:20',
                'unique:tenants,id',
                'regex:/^[a-zA-Z]+$/',
            ],
        ])->validate();

        $user = User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        if ( ! tenant('id') ) {
            $tenantCreator = new TenantCreator();
            $tenant = $tenantCreator->createTenant($input, $user);
            $tenantCreator->createSeeder($tenant);
            $tenantCreator->createAdmin($user, $tenant);
            $tenantCreator->createSettings($input['link'], $tenant);
            $tenantCreator->createSupscription($user, $tenant);
        }



        return $user;
    }
}
