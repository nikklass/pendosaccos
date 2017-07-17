<?php

use Illuminate\Database\Seeder;
use App\Permission;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        Permission::truncate();
        
        $permissions = [
            [
                'name' => 'role-read',
                'display_name' => 'Display role listing',
                'description' => 'See listing of roles'
            ],
            [
                'name' => 'role-create',
                'display_name' => 'Create role',
                'description' => 'Create a new role'
            ],
            [
                'name' => 'role-edit',
                'display_name' => 'Edit role',
                'description' => 'Edit a role'
            ],
            [
                'name' => 'role-delete',
                'display_name' => 'Delete role',
                'description' => 'Delete a role'
            ],
            [
                'name' => 'user-read',
                'display_name' => 'Display user listing',
                'description' => 'See listing of users'
            ],
            [
                'name' => 'user-create',
                'display_name' => 'Create user',
                'description' => 'Create a new user'
            ],
            [
                'name' => 'user-edit',
                'display_name' => 'Edit user',
                'description' => 'Edit a user'
            ],
            [
                'name' => 'user-delete',
                'display_name' => 'Delete user',
                'description' => 'Delete a user'
            ],
        ];

        foreach($permissions as $key=>$value)
        {
            Permission::create($value);
        }

    }
}
