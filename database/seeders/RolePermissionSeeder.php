<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            'create-dispatch',
            'edit-dispatch',
            'delete-dispatch',
            'view-dispatch',
            'approve-task',
            'reject-task',
            'recommend-task',
            'return-task',
            'view-all-tasks',
            'view-assigned-tasks',
            'view-admin-inbox',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create Admin role and assign all permissions
        $adminRole = Role::firstOrCreate(['name' => 'Admin']);
        $adminRole->givePermissionTo($permissions);

        // Assign Admin role to a test user (replace 1 with your user ID)
        $user = \App\Models\User::find(1);
        if ($user) {
            $user->assignRole('Admin');
        }
    }
}
