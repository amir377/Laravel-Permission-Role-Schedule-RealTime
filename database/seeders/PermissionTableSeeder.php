<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

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
            'user-index',
            'user-create',
            'user-store',
            'user-edit',
            'user-update',
            'user-destroy',
            'calendar-index',
            'calendar-action',
            'schedule-index',
            'schedule-create',
            'schedule-store',
            'schedule-edit',
            'schedule-update',
            'schedule-destroy',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
         ];

         foreach ($permissions as $permission) {
              Permission::create(['name' => $permission]);
         }
    }
}
