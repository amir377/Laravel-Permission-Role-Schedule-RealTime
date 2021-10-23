<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Models\Role as RoleManualModel;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleWorker = Role::create(['name' => 'Worker']);

        $user = User::create([
            'name' => 'amirhossein',
            'email' => 'admin@laravel.com',
            'password' => bcrypt('12345'),
            'role_id' => RoleManualModel::ROLE_ADMIN
        ]);

        $permissions = Permission::pluck('id','id')->all();

        $roleAdmin->syncPermissions($permissions);
        $roleWorker->syncPermissions(Permission::whereIn('name', ['schedule-index','schedule-create','schedule-store','schedule-edit','schedule-update','schedule-destroy'])->get()->pluck('id','id'));

        $user->assignRole([$roleAdmin->id]);
    }
}
