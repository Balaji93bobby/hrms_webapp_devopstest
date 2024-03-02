<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Sanctum\Sanctum;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        // Sanctum::creatingToken(function ($user) {
        //     $token = $user->createToken('custom-token', ['user_code' => $user->code, 'user_name' => $user->name]);

        //     return [
        //         'token' => $token->plainTextToken,
        //         'user_code' => $user->code,
        //         'user_name' => $user->name,
        //     ];
        // });

        //
    }
}
