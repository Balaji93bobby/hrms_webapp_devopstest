<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'id' =>$this->faker->randomNumber(6, false),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$vry5bkqFn25Jq/5JVRldEurny4slho/O2NI6Nlla57o0QKf3X0kjW', // Abs@123123
            'remember_token' => Str::random(10),

            'user_code' => 'ABS'.$this->faker->randomNumber(6, false),
            'client_id' => '1' ,
            'active' => '1',

            'avatar' => null,
            'is_admin' => '0',
            'is_onboarded' => '1',
            'onboard_type' => 'normal',
            'is_default_password_updated' => '1',
            'org_role' => '4',
            'is_ssa' => '0',
            'can_login' => '1',
            'fcm_token' => null

        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
