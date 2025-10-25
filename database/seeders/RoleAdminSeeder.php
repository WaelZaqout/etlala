<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // تنظيف الكاش
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $guard = 'web';

        $permissions = [
            'full access',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => $guard]);
        }

        // إنشاء دور الأدمن
        $admin = Role::firstOrCreate(['name' => 'admin', 'guard_name' => $guard]);

        // ربط الأدمن بجميع الصلاحيات (كل الموجود في جدول permissions)
        $admin->syncPermissions(Permission::all());

        // إنشاء دور المستخدم العادي
        Role::firstOrCreate(['name' => 'user', 'guard_name' => $guard]);
    }
}
