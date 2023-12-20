<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdministratorUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Administrator',
            'username' => 'administrator',
            'email' => 'administrator@gmail.com',
            'password' => bcrypt('password'),
            'telp'  => '081234567890',
            'role'  => 1,
        ]);

        $role = Role::create(['name' => 'Administrator']);
        $permissions = Permission::pluck('id','id')->all();
        $role->syncPermissions($permissions);
        $user->assignRole([$role->id]);
    }
}
