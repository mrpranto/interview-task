<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            [
                'name' => 'Access Dashboard',
                'slug' => 'app.access.dashboard',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Access User',
                'slug' => 'app.access.user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Create User',
                'slug' => 'app.create.user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Update User',
                'slug' => 'app.update.user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Delete User',
                'slug' => 'app.delete.user',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Permission::query()->insert($permissions);
    }
}
