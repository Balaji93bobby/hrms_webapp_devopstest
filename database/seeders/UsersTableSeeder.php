<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'id' => '' ,
            'name' => 'super admin',
            'user_code'=>'SA100',
            'email' => 'tested2353@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('123123123'),
            'avatar'=>'egrherhea',
            'created_at' => now(),
            'updated_at' => now(),
            'is_admin'=>'0',
            'is_onboarded'=>'1',
            'onboard_type'=>'normal',
            'is_ssa'=>'1',
            'can_login'=>'1',


        ]);

    }
}
