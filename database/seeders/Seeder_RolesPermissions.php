<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\User;

class Seeder_RolesPermissions extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $new_permissions_count = 0;
        $new_roles_count = 0;

        $roles = config('vmt_roles_permissions.roles');
        $permissions = config('vmt_roles_permissions.permissions');


         //create permissions
         foreach ($permissions as $singlePermission) {
            if(! Permission::where('name', $singlePermission)->exists())
            {
                Permission::create(['name' => $singlePermission]);
                $new_permissions_count++;
            }
         }

         //create roles
         foreach($roles as $singleRole){
            if(!Role::where('name', $singleRole)->exists())
            {
                Role::create(['name' => $singleRole]);
                $new_roles_count++;
            }
         }

         echo "Seeder Completed !";
         echo "\n Result (New Roles Added, New Perm Added ) : ".$new_roles_count." , ".$new_permissions_count."\n";



         ////assign permissions to roles
            //SUPER ADMIN
            $sa_role = Role::findByName('superadmin');
            $sa_role->syncPermissions([
                        $permissions['MANAGE_PAYSLIPS_can_view'],
                        $permissions['MANAGE_PAYSLIPS_release_payslip'],
                        $permissions['can_view_employees_payslip'],

                    ]);

            //assign this role to SA100
            User::where('is_ssa','1')->first()->assignRole('superadmin');

            echo "\n SA Role : (Total Perm count) :: ".$sa_role->permissions->count()." \n";


        ////Assign roles to users based on org_role

            //assign manager role to user's whose org_role = 4 (In future,we will use UI to assign roles)
            $users_managers = User::where('org_role','4')->get();

            foreach($users_managers as $singleManager)
            {
                $singleManager->assignRole('manager');

            }



         //HR
         $hr_role = Role::findByName('hr');
         $hr_role->syncPermissions([]); //Remove all permission if empty array given

         echo "\n HR Role : (Total Perm count) :: ".$hr_role->permissions->count()." \n";



         echo "\n\n";
    }
}
