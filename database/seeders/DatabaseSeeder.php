<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use App\Models\Counter;
use App\Models\User;



class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\CRequest::factory(10)->create();


        Counter::create([
            "id" => 69,
            "product_no" => 102729,
        ]);


        $admin = User::create([
            "name" => 'admin',
            "lastname" =>'admin',
            "email" => 'admin@admin.com',
            "password" => 'admin'
        ]);

        \App\Models\CRequest::factory()->count(50)->create();


        $adminRole = Role::create(['name' => 'admin']);
        $admin->assignRole('admin');


        $engineeringPerm = Permission::create(['name' => 'engineering']);
        $crApproverPerm = Permission::create(['name' => 'cr_approver']);
        $engApproverPerm = Permission::create(['name' => 'eng_approver']);
        $engCheckerPerm = Permission::create(['name' => 'eng_checker']);





        $adminRole->givePermissionTo($engineeringPerm);
    }
}
