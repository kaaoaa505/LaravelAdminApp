<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use DB;
use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('permission_role')->truncate();

        $permissions = Permission::all();

        $admin = Role::whereName('admin')->first();

        foreach($permissions as $permission){
            DB::table('permission_role')->insert([
                'role_id' => $admin->id,
                'permission_id' => $permission->id,
            ]);
        }

        $editor = Role::whereName('editor')->first();

        foreach($permissions as $permission){
            if(!in_array($permission->name, ['edit_roles'])){
                DB::table('permission_role')->insert([
                    'role_id' => $editor->id,
                    'permission_id' => $permission->id,
                ]);
            }
        }

        $viewer = Role::whereName('viewer')->first();

        $viewerRoles = ['view_users', 'view_roles', 'view_products', 'view_orders'];

        foreach($permissions as $permission){
            if(in_array($permission->name, $viewerRoles)){
                DB::table('permission_role')->insert([
                    'role_id' => $viewer->id,
                    'permission_id' => $permission->id,
                ]);
            }
        }

    }
}
