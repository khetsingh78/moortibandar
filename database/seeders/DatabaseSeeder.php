<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        \App\Models\User::factory()->create([
            'name' => fake()->name(),
            // 'email' => fake()->unique()->safeEmail(),
            'email' => "khetsinghyogi@gmail.com",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        \App\Models\User::factory()->create([
            'name' => fake()->name(),
            // 'email' => fake()->unique()->safeEmail(),
            'email' => "yogikhetsingh@gmail.com",
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);

        \App\Models\User::factory(10)->create();

        $roles = roles();
        if (!empty($roles)) {
            foreach ($roles as $key => $value) {
                \App\Models\Roles::factory()->create([
                    'name' => $value["name"],
                    'description' => $value["description"],
                ]);
            }
        }

        $permission = permissions();
        if (!empty($permission)) {
            foreach ($permission as $key => $value) {
                \App\Models\Permissions::factory()->create([
                    'name' =>  $value["name"],
                    'description' => $value["description"],
                ]);
            }
        }


        $userRoles = userRoles();
        if (!empty($userRoles)) {
            foreach ($userRoles as $key => $value) {
                \App\Models\UserRoles::factory()->create([
                    'user_id' =>  $value["user_id"],
                    'role_id' => $value["role_id"],
                ]);
            }
        }

        $RolePermissions = RolePermissions();
        if (!empty($RolePermissions)) {
            foreach ($RolePermissions as $key => $value) {
                \App\Models\RolePermissions::factory()->create([
                    'role_id' =>  $value["role_id"],
                    'permission_id' => $value["permission_id"],
                ]);
            }
        }


        $category = category();
        if (!empty($category)) {
            foreach ($category as $key => $value) {
                \App\Models\Category::factory()->create([
                    'name' =>  $value["name"],
                    'parent_id' => $value["parent_id"],
                ]);
            }
        }

        $discount = discount();
        if (!empty($discount)) {
            foreach ($discount as $key => $value) {
                \App\Models\ProductDiscount::factory()->create([
                    "name" =>  $value["name"],
                    "description" =>  $value["description"],
                    "dis_percent" => $value["dis_percent"],
                    "status" => $value["status"],
                ]);
            }
        }

        $gsttax = gsttax();
        if (!empty($gsttax)) {
            foreach ($gsttax as $key => $value) {
                \App\Models\Gsttax::factory()->create([
                    "gst" =>  $value["gst"],
                    "description" =>  $value["description"],
                ]);
            }
        }
    }
}
