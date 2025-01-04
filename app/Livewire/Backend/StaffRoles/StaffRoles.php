<?php

namespace App\Livewire\Backend\StaffRoles;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class StaffRoles extends Component
{
    public $roles;
    public $current_user;
    public $employee_name;
    public $employee_email;
    public $employee_password;
    public $employee_role;

    public $current_role;
    public $role_name_ar;
    public $role_name_en;
    public $role_slug;
    public $roles_add = false;
    public $roles_view = false;
    public $roles_update = false;
    public $roles_delete = false;
    public $employees_add = false;
    public $employees_view = false;
    public $employees_update = false;
    public $employees_delete = false;
    public $users_add = false;
    public $users_view = false;
    public $users_update = false;
    public $users_delete = false;
    public $plans_add = false;
    public $plans_view = false;
    public $plans_update = false;
    public $plans_delete = false;
    public $settings_view = false;
    public $settings_update = false;

    public function mount()
    {
        $this->roles = Role::all();
    }

    public function resetToDefault()
    {
        $this->reset();
        $this->mount();
    }

    public function active_user(  $id ){

        $user = User::find($id);        
        if( ! $user ){
            $this->resetToDefault();
            return  $this->dispatch('userAction', type: 'error', title: __('Error'), msg: 'لم يتم العثور على الموظف!');
        }

        $this->current_user = $user;

        $this->employee_name = $user->name;
        $this->employee_email = $user->email;
        $this->employee_role = $user->getRoleNames()->first();
        
    }

    public function active_role(  $id ){

        $this->resetToDefault();
        $role = Role::find($id);        
        if( ! $role ){
            $this->resetToDefault();
            return  $this->dispatch('userAction', type: 'error', title: __('Error'), msg: 'لم يتم العثور على الدور!');
        }

        $this->current_role = $role;

        $this->role_slug = $role->name;
        $this->role_name_ar = $role->display_name;
        $this->role_name_en = $role->display_name_en;
        
        //dd($this->current_role->getPermissionNames());
        $permissionNames = $this->current_role->getPermissionNames();

        foreach ($permissionNames as $per) {
            
            if( isset($this->$per) ){
                $this->$per = true;
            }
        }

        // public $roles_add = false;
        // public $roles_view = false;
        // public $roles_update = false;
        // public $roles_delete = false;
        // public $employees_add = false;
        // public $employees_view = false;
        // public $employees_update = false;
        // public $employees_delete = false;
        // public $users_add = false;
        // public $users_view = false;
        // public $users_update = false;
        // public $users_delete = false;
        // public $plans_add = false;
        // public $plans_view = false;
        // public $plans_update = false;
        // public $plans_delete = false;
        // public $settings_view = false;
        // public $settings_update = false;
    }

    public function saveEmployee()
    {
        $this->validate([
            'employee_name' => 'required|string|max:255',
            'employee_email' => 'required|email|unique:users,email',
            'employee_password' => 'required|string|min:8',
            'employee_role' => 'required|exists:roles,name',
        ]);

        // إنشاء المستخدم الجديد
        $user = User::create([
            'name' => $this->employee_name,
            'email' => $this->employee_email,
            'password' => Hash::make($this->employee_password),
        ]);

        // تعيين الدور للمستخدم
        $user->assignRole($this->employee_role);

        // رسالة نجاح
        $this->resetToDefault();
        $this->dispatch('refreshDatatable');
        return $this->dispatch('makeAction', type: 'success', title: __('Ok'), msg: 'تم إضافة الموظف بنجاح!');
    }

    public function updateEmployee()
    {
        if( $this->current_user ){
            return  $this->dispatch('UserAction', type: 'error', title: __('Error'), msg: 'لم يتم العثور على الدور!');
        }
        $this->validate([
            'employee_name' => 'required|string|max:255',
            'employee_email' => 'required|email|unique:users,email,' . $this->current_user->id,
            'employee_password' => 'nullable|string|min:8',
            'employee_role' => 'required|exists:roles,name',
        ]);
    
        // تحديث بيانات المستخدم
        $this->current_user->update([
            'name' => $this->employee_name,
            'email' => $this->employee_email,
            'password' => $this->employee_password ? Hash::make($this->employee_password) : $this->current_user->password,
        ]);
    
        // تعيين الدور للمستخدم
        $roles = ['super_admin'];
        if( ! $this->current_user->hasAnyRole($roles) ){
    
            // تحديث الأدوار باستخدام syncRoles
            $this->current_user->syncRoles([$this->employee_role]);
        }
    
        // رسالة نجاح
        $this->resetToDefault();
        $this->dispatch('refreshDatatable');
        return $this->dispatch('makeAction', type: 'success', title: __('Ok'), modal: '#modal-editemployee',msg: 'تم تحديث بيانات الموظف بنجاح!');
    }

    public function saveRole()
    {
        $this->validate([
            'role_name_ar' => 'required|string|max:255',
            'role_name_en' => 'required|string|max:255',
            'role_slug' => 'required|string|max:255|unique:roles,name',
        ]);

        $role = Role::create([
            'guard_name' => 'web',
            'name' => $this->role_slug, // استخدم slug كاسم
            'display_name' => $this->role_name_ar,
            'display_name_en' => $this->role_name_en,
            'color' => 'purple',
        ]);

        // تجميع الأذونات المختارة فقط
        $available_permissions = Permission::pluck('name')->toArray();
        $permissions = [];

        if ($this->roles_view && in_array('roles_view', $available_permissions)) $permissions[] = 'roles_view';
        if ($this->roles_add && in_array('roles_add', $available_permissions)) $permissions[] = 'roles_add';
        if ($this->roles_update && in_array('roles_update', $available_permissions)) $permissions[] = 'roles_update';
        if ($this->roles_delete && in_array('roles_delete', $available_permissions)) $permissions[] = 'roles_delete';
        if ($this->employees_view && in_array('employees_view', $available_permissions)) $permissions[] = 'employees_view';
        if ($this->employees_add && in_array('employees_add', $available_permissions)) $permissions[] = 'employees_add';
        if ($this->employees_update && in_array('employees_update', $available_permissions)) $permissions[] = 'employees_update';
        if ($this->employees_delete && in_array('employees_delete', $available_permissions)) $permissions[] = 'employees_delete';
        if ($this->users_view && in_array('users_view', $available_permissions)) $permissions[] = 'users_view';
        if ($this->users_add && in_array('users_add', $available_permissions)) $permissions[] = 'users_add';
        if ($this->users_update && in_array('users_update', $available_permissions)) $permissions[] = 'users_update';
        if ($this->users_delete && in_array('users_delete', $available_permissions)) $permissions[] = 'users_delete';
        if ($this->plans_view && in_array('plans_view', $available_permissions)) $permissions[] = 'plans_view';
        if ($this->plans_add && in_array('plans_add', $available_permissions)) $permissions[] = 'plans_add';
        if ($this->plans_update && in_array('plans_update', $available_permissions)) $permissions[] = 'plans_update';
        if ($this->plans_delete && in_array('plans_delete', $available_permissions)) $permissions[] = 'plans_delete';
        if ($this->settings_view && in_array('settings_view', $available_permissions)) $permissions[] = 'settings_view';
        if ($this->settings_update && in_array('settings_update', $available_permissions)) $permissions[] = 'settings_update';
    
        // إعطاء الأذونات المختارة فقط
        $role->syncPermissions($permissions);

                // رسالة نجاح
        $this->resetToDefault();
        $this->dispatch('refreshDatatable');
        return $this->dispatch('makeAction', type: 'success', modal: '#modal-newrole', title: __('Ok'), msg: 'تم إضافة الدور بنجاح!');
        
    }

    public function updateRole()
    {
        if( ! $this->current_role ){
            return  $this->dispatch('UserAction', type: 'error', title: __('Error'), msg: 'لم يتم العثور على الدور!');
        }

        $this->validate([
            'role_name_ar' => 'required|string|max:255',
            'role_name_en' => 'required|string|max:255',
            'role_slug' => 'required|string|max:255|unique:roles,name,' . $this->current_role->id,
        ]);

        $this->current_role->update([
            'name' => $this->role_slug,
            'display_name' => $this->role_name_ar,
            'display_name_en' => $this->role_name_en,
        ]);

        // تجميع الأذونات المختارة فقطد
        $available_permissions = Permission::pluck('name')->toArray();
        $permissions = [];

        if ($this->roles_view && in_array('roles_view', $available_permissions)) $permissions[] = 'roles_view';
        if ($this->roles_add && in_array('roles_add', $available_permissions)) $permissions[] = 'roles_add';
        if ($this->roles_update && in_array('roles_update', $available_permissions)) $permissions[] = 'roles_update';
        if ($this->roles_delete && in_array('roles_delete', $available_permissions)) $permissions[] = 'roles_delete';
        if ($this->employees_view && in_array('employees_view', $available_permissions)) $permissions[] = 'employees_view';
        if ($this->employees_add && in_array('employees_add', $available_permissions)) $permissions[] = 'employees_add';
        if ($this->employees_update && in_array('employees_update', $available_permissions)) $permissions[] = 'employees_update';
        if ($this->employees_delete && in_array('employees_delete', $available_permissions)) $permissions[] = 'employees_delete';
        if ($this->users_view && in_array('users_view', $available_permissions)) $permissions[] = 'users_view';
        if ($this->users_add && in_array('users_add', $available_permissions)) $permissions[] = 'users_add';
        if ($this->users_update && in_array('users_update', $available_permissions)) $permissions[] = 'users_update';
        if ($this->users_delete && in_array('users_delete', $available_permissions)) $permissions[] = 'users_delete';
        if ($this->plans_view && in_array('plans_view', $available_permissions)) $permissions[] = 'plans_view';
        if ($this->plans_add && in_array('plans_add', $available_permissions)) $permissions[] = 'plans_add';
        if ($this->plans_update && in_array('plans_update', $available_permissions)) $permissions[] = 'plans_update';
        if ($this->plans_delete && in_array('plans_delete', $available_permissions)) $permissions[] = 'plans_delete';
        if ($this->settings_view && in_array('settings_view', $available_permissions)) $permissions[] = 'settings_view';
        if ($this->settings_update && in_array('settings_update', $available_permissions)) $permissions[] = 'settings_update';
    
        // إعطاء الأذونات المختارة فقط
        $this->current_role->syncPermissions($permissions);

        // رسالة نجاح
        $this->resetToDefault();
        $this->dispatch('refreshDatatable');
        return $this->dispatch('makeAction', type: 'success', modal: '#modal-editrole', title: __('Ok'), msg: 'تم حفظ بيانات الدور بنجاح!');
        
    }

    public function confirm_delete( $id )
    {
        $user = User::find($id);

        $roles = ['super_admin'];
        if( $user->hasAnyRole($roles) ){
            return $this->dispatch('makeAction', type: 'error', title: __('Error'), msg: 'لا يمكن حذف مسئول النظام!');
        }
        $user->delete();
        $this->dispatch('refreshDatatable');
        return $this->dispatch('makeAction', type: 'success', title: __('Ok'), msg: 'تم حذف الموظف بنجاح!');

    }

    public function confirm_role_delete( $id )
    {
        $role = Role::find($id);

        $roles = ['super_admin', 'admin', 'user'];
        if( in_array($role->name, $roles) ){
            return $this->dispatch('makeAction', type: 'error', title: __('Error'), msg: 'لا يمكن حذف الأدوار الأساسية!');
        }
        $role->delete();
        $this->dispatch('refreshDatatable');
        return $this->dispatch('makeAction', type: 'success', title: __('Ok'), msg: 'تم حذف الدور بنجاح!');

    }

    public function confirm_edit( $id )
    {
        $this->active_user( $id );
        if( $this->current_user === null || $this->current_user->id !== $id ){
            return  $this->dispatch('UserAction', type: 'error', title: __('Error'), msg: 'لم يتم العثور على الموظف!');
        }
        
        return  $this->dispatch('showEditModale', modal: '#modal-editemployee');

    }

    public function confirm_role_edit( $id )
    {
        $this->active_role( $id );
        if( $this->current_role === null || $this->current_role->id !== $id ){
            return  $this->dispatch('UserAction', type: 'error', title: __('Error'), msg: 'لم يتم العثور على الدور!');
        }
        
        return  $this->dispatch('showEditModale', modal: '#modal-editrole');
    }

    public function render()
    {
        return view('livewire.backend.staff-roles.staff-roles', [
            'roles' => $this->roles
        ]);
    }
}
