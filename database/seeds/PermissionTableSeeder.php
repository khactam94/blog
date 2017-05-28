<?php

use Illuminate\Database\Seeder;
use App\Models\Permission;

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
        //base permission
            [
                'name' => 'users-manager',
                'display_name' => 'User Manager',
                'description' => 'Create, update, view, delete a user'
            ],
        	[
        		'name' => 'roles-manager',
        		'display_name' => 'Manage Role',
        		'description' => 'Create, Update, Delete a role'
        	],
            [
                'name' => 'permissions-manager',
                'display_name' => 'Manage Permission',
                'description' => 'Create, Update, Delete a permission'
            ],
        // advance permission
            [
                'name' => 'posts-manager',
                'display_name' => 'Manage all posts',
                'description' => 'Create, Update, Delete a post'
            ],
            [
                'name' => 'tags-manager',
                'display_name' => 'Manage all tags',
                'description' => 'Create, Update, Delete a tag'
            ],
            [
                'name' => 'categories-manager',
                'display_name' => 'Manage all categories',
                'description' => 'Create, Update, Delete a categorie'
            ],
            [
                'name' => 'my-posts-manager',
                'display_name' => 'Manage Permission users post',
                'description' => 'Create, Update, Delete a permission'
            ],
        ];

        foreach ($permissions as $key => $value) {
        	Permission::create($value);
        }
    }
}
