<?php

namespace Database\Seeders;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superAdminRole = Role::create(['guard_name'=>'web','name' => 'super_admin', 'display_name'=> 'المدير العام', 'display_name_en'=> 'Super Administrator', 'color'=> 'purple']);
        $adminRole = Role::create(['guard_name'=>'web','name' => 'admin', 'display_name'=> 'مدير', 'display_name_en'=> 'Administrator']);
        $userRole = Role::create(['guard_name'=>'web','name' => 'user', 'display_name'=> 'مستخدم', 'display_name_en'=> 'User']);
        // $clientRole = Role::create(['guard_name'=>'web','name' => 'client', 'display_name'=> 'عميل', 'display_name_en'=> 'Client']);
        // $prospectiveClientRole = Role::create(['guard_name'=>'web','name' => 'prospective_client', 'display_name'=> 'عميل محتمل', 'display_name_en'=> 'Prospective client']);

        $admin_view = Permission::create(['guard_name'=>'web','name' => 'admin_view', 'display_name'=> 'عرض  لوحة التحكم', 'display_name_en'=> 'View dashboard']);

        if ( ! tenant('id') ) {
            $platforms_view = Permission::create(['guard_name'=>'web','name' => 'platforms_view', 'display_name'=> 'عرض المنصات', 'display_name_en'=> 'View platforms']);
            $platforms_add = Permission::create(['guard_name'=>'web','name' => 'platforms_add', 'display_name'=> 'إضافة منصات', 'display_name_en'=> 'Add platforms']);
            $platforms_update = Permission::create(['guard_name'=>'web','name' => 'platforms_update', 'display_name'=> 'تعديل منصات', 'display_name_en'=> 'Update platforms']);
            $platforms_delete  = Permission::create(['guard_name'=>'web','name' => 'platforms_delete', 'display_name'=> 'حذف منصات', 'display_name_en'=> 'Delete platforms']);
            $platforms_manage  = Permission::create(['guard_name'=>'web','name' => 'platforms_manage', 'display_name'=> 'إدارة منصات', 'display_name_en'=> 'Manage platforms']);    
        }

        $roles_view = Permission::create(['guard_name'=>'web','name' => 'roles_view', 'display_name'=> 'عرض  الصلاحيات', 'display_name_en'=> 'View roles']);
        $roles_add = Permission::create(['guard_name'=>'web','name' => 'roles_add', 'display_name'=> 'إضافة صلاحيات', 'display_name_en'=> 'Add roles']);
        $roles_update = Permission::create(['guard_name'=>'web','name' => 'roles_update', 'display_name'=> 'تعديل الصلاحيات', 'display_name_en'=> 'Update roles']);
        $roles_delete = Permission::create(['guard_name'=>'web','name' => 'roles_delete', 'display_name'=> 'حذف صلاحيات', 'display_name_en'=> 'Delete roles']);

        $users_view = Permission::create(['guard_name'=>'web','name' => 'users_view', 'display_name'=> 'عرض  المستخدمين', 'display_name_en'=> 'View users']);
        $users_add = Permission::create(['guard_name'=>'web','name' => 'users_add', 'display_name'=> 'إضافة مستخدمين', 'display_name_en'=> 'Add users']);
        $users_update = Permission::create(['guard_name'=>'web','name' => 'users_update', 'display_name'=> 'تعديل مستخدمين', 'display_name_en'=> 'Update users']);
        $users_delete = Permission::create(['guard_name'=>'web','name' => 'users_delete', 'display_name'=> 'حذف مستخدمين', 'display_name_en'=> 'Delete users']);

        $employees_view = Permission::create(['guard_name'=>'web','name' => 'employees_view', 'display_name'=> 'عرض  الموظفينن', 'display_name_en'=> 'View employees']);
        $employees_add = Permission::create(['guard_name'=>'web','name' => 'employees_add', 'display_name'=> 'إضافة موظفينن', 'display_name_en'=> 'Add employees']);
        $employees_update = Permission::create(['guard_name'=>'web','name' => 'employees_update', 'display_name'=> 'تعديل موظفينن', 'display_name_en'=> 'Update employees']);
        $employees_delete = Permission::create(['guard_name'=>'web','name' => 'employees_delete', 'display_name'=> 'حذف موظفينن', 'display_name_en'=> 'Delete employees']);

        if ( ! tenant('id') ) {
            
            $plans_view = Permission::create(['guard_name'=>'web','name' => 'plans_view', 'display_name'=> 'عرض الخطط', 'display_name_en'=> 'View plans']);
            $plans_add = Permission::create(['guard_name'=>'web','name' => 'plans_add', 'display_name'=> 'إضافة خطط', 'display_name_en'=> 'Add plans']);
            $plans_update = Permission::create(['guard_name'=>'web','name' => 'plans_update', 'display_name'=> 'تعديل خطط', 'display_name_en'=> 'Update plans']);
            $plans_delete = Permission::create(['guard_name'=>'web','name' => 'plans_delete', 'display_name'=> 'حذف خطط', 'display_name_en'=> 'Delete plans']);    
        }

        $settings_view = Permission::create(['guard_name'=>'web','name' => 'settings_view', 'display_name'=> 'عرض الإعدادات', 'display_name_en'=> 'View settings']);
        $settings_update = Permission::create(['guard_name'=>'web','name' => 'settings_update', 'display_name'=> 'تعديل الإعدادات', 'display_name_en'=> 'Update settings']);

        $section_hero_view = Permission::create(['guard_name'=>'web','name' => 'hero_section_view', 'display_name'=> 'عرض الإعدادات', 'display_name_en'=> 'View settings']);

        $permissions = Permission::pluck('name')->toArray();
        $adminRole->syncPermissions($permissions);
        $superAdminRole->syncPermissions($permissions);


        $superAdmin = User::create([
            'name'               => 'Super admin',
            'email'              => 'betalamoud@gmail.com',
            'email_verified_at'  => Carbon::now(),
            'password'           => Hash::make('SuperAdmin_123@#')
        ]);

        $superAdmin->assignRole('super_admin');
    }
}
