<div>
    <style>
        .form-check-input {
            width: 25px;
            height: 25px;
            background: #eaefff;
        }
        .form-check {
            display: flex;
            align-items: center;
            gap: 4px
        }
    </style>
    <div class="container">
        <div class="row align-items-center mb-5">
            <div class="col-md-4"><h2 class="h4">{{ __('Staff and Roles') }}</h2></div>
            <div class="col-md-8 d-flex justify-content-end" style="gap: 8px">
                <button class="btn btn-light text-primary fw-bold px-5 py-3" wire:click="resetToDefault" data-bs-toggle="modal" data-bs-target="#modal-newemployee" style="background: #e1e8fb">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    {{ __('Add employee') }}
                </button>
                <button class="btn btn-primary fw-bold px-5 py-3" wire:click="resetToDefault" data-bs-toggle="modal" data-bs-target="#modal-newrole">
                    <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>
                    {{ __('Add role') }}
                </button>
            </div>
        </div>

        <div class="row align-items-center mb-5">
            <div class="col-md-8"><h2 class="h4">{{ __('Staff') }}</h2></div>
            <div class="col-md-4 text-md-end">
            </div>
        </div>
        <livewire:backend.staff-roles.staff-table />

        <div class="row align-items-center my-5">
            <div class="col-md-8"><h2 class="h4">{{ __('Roles') }}</h2></div>
            <div class="col-md-4 text-md-end">
            </div>
        </div>

        <livewire:backend.staff-roles.roles-table />
    </div>

    <div class="modal fade" id="modal-newemployee" tabindex="-1" aria-labelledby="modal-newemployeeLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-newemployeeLabel">{{ __('Add Employee') }}</h5>
                    <button type="button" wire:click="resetToDefault" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Name Field -->
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="employee_name" class="form-label fw-bold">{{ __('Name') }}</label>
                            <input class="form-control @error('employee_name') is-invalid @enderror" type="text" wire:model="employee_name" placeholder="{{ __('Enter employee name') }}" required autofocus>
                            @error('employee_name')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
    
                    <!-- Email Field -->
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="employee_email" class="form-label fw-bold">{{ __('Email') }}</label>
                            <input class="form-control @error('employee_email') is-invalid @enderror" type="email" wire:model="employee_email" placeholder="{{ __('Enter employee email') }}" required>
                            @error('employee_email')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
    
                    <!-- Password Field -->
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="employee_password" class="form-label fw-bold">{{ __('Password') }}</label>
                            <input class="form-control @error('employee_password') is-invalid @enderror" type="password" wire:model="employee_password" placeholder="{{ __('Enter password') }}" required>
                            @error('employee_password')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
    
                    <!-- Role Selection -->
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="employee_role" class="form-label fw-bold">{{ __('Role') }}</label>
                            <select class="form-control @error('employee_role') is-invalid @enderror" wire:model="employee_role" required>
                                <option value="">{{ __('Select employee role') }}</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('employee_role')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close" wire:click="resetToDefault">{{ __('Cancel') }}</button>
                    <button type="button" class="btn btn-primary" wire:click="saveEmployee">{{ __('Add Employee') }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-editemployee" tabindex="-1" aria-labelledby="modal-editemployeeLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-editmeployeeLabel">{{ __('Edit') .': '. $employee_name }}</h5>
                    <button type="button" wire:click="resetToDefault" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                @if ($current_user)
                    <div class="modal-body">
                        <!-- Name Field -->
                        <div class="mb-3 row">
                            <div class="col">
                                <label for="employee_name" class="form-label fw-bold">{{ __('Name') }}</label>
                                <input class="form-control @error('employee_name') is-invalid @enderror" type="text" wire:model="employee_name" placeholder="{{ __('Enter employee name') }}" required autofocus>
                                @error('employee_name')
                                    <small class="invalid-feedback d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
        
                        <!-- Email Field -->
                        <div class="mb-3 row">
                            <div class="col">
                                <label for="employee_email" class="form-label fw-bold">{{ __('Email') }}</label>
                                <input class="form-control @error('employee_email') is-invalid @enderror" type="email" wire:model="employee_email" placeholder="{{ __('Enter employee email') }}" required>
                                @error('employee_email')
                                    <small class="invalid-feedback d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
        
                        <!-- Password Field -->
                        <div class="mb-3 row">
                            <div class="col">
                                <label for="employee_password" class="form-label fw-bold">{{ __('Password') }}</label>
                                <input class="form-control @error('employee_password') is-invalid @enderror" type="password" wire:model="employee_password" placeholder="{{ __('Enter password') }}" required>
                                @error('employee_password')
                                    <small class="invalid-feedback d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
        
                        <!-- Role Selection -->
                        <div class="mb-3 row">
                            <div class="col">
                                <label for="employee_role" class="form-label fw-bold">{{ __('Role') }}</label>
                                <select class="form-control @error('employee_role') is-invalid @enderror" wire:model="employee_role" required>
                                    <option value="">{{ __('Select employee role') }}</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                @error('employee_role')
                                    <small class="invalid-feedback d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                    </div>
        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-label="Close" wire:click="resetToDefault">{{ __('Cancel') }}</button>
                        <button type="button" class="btn btn-primary" wire:click="updateEmployee">{{ __('Save changes') }}</button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modal-newrole" tabindex="-1" aria-labelledby="modal-newroleLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-newroleLabel">{{ __('Add New Role') }}</h5>
                    <button type="button" class="btn-close" wire:click="resetToDefault" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
    
                    <!-- الاسم بالعربي والإنجليزي -->
                    <div class="mb-3 row">
                        <div class="col">
                            <label for="role_name_ar" class="form-label fw-bold">{{ __('Role Name (Arabic)') }}</label>
                            <input class="form-control @error('role_name_ar') is-invalid @enderror" type="text" wire:model="role_name_ar" placeholder="{{ __('Enter role name in Arabic') }}" required autofocus>
                            @error('role_name_ar')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col">
                            <label for="role_name_en" class="form-label fw-bold">{{ __('Role Name (English)') }}</label>
                            <input class="form-control @error('role_name_en') is-invalid @enderror" type="text" wire:model="role_name_en" placeholder="{{ __('Enter role name in English') }}" required>
                            @error('role_name_en')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
    
                    <!-- الرمز الفريد -->
                    <div class="mb-3">
                        <label for="role_slug" class="form-label fw-bold">{{ __('Unique Code') }}</label>
                        <input class="form-control @error('role_slug') is-invalid @enderror" type="text" wire:model="role_slug" placeholder="{{ __('Enter Unique Code') }}" required>
                        @error('role_slug')
                            <small class="invalid-feedback d-block">{{ $message }}</small>
                        @enderror
                    </div>   
                <!-- جدول الأذونات -->
                <div class="mb-3">

                    <label class="form-label fw-bold">{{ __('Roles') }}</label>
                    <div class="mb-4 d-flex justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="roles_add" id="roles_add">
                            <label class="form-check-label" for="roles_add">{{ __('Create') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="roles_view" id="roles_view">
                            <label class="form-check-label" for="roles_view">{{ __('View') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="roles_update" id="roles_update">
                            <label class="form-check-label" for="roles_update">{{ __('Edit') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="roles_delete" id="roles_delete">
                            <label class="form-check-label" for="roles_delete">{{ __('Delete') }}</label>
                        </div>
                    </div>

                    <label class="form-label fw-bold">{{ __('Employees') }}</label>
                    <div class="mb-4 d-flex justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="employees_add" id="employees_add">
                            <label class="form-check-label" for="employees_add">{{ __('Create') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="employees_view" id="employees_view">
                            <label class="form-check-label" for="employees_view">{{ __('View') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="employees_update" id="employees_update">
                            <label class="form-check-label" for="employees_update">{{ __('Edit') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="employees_delete" id="employees_delete">
                            <label class="form-check-label" for="employees_delete">{{ __('Delete') }}</label>
                        </div>
                    </div>

                    <label class="form-label fw-bold">{{ __('Users') }}</label>
                    <div class="mb-4 d-flex justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="users_add" id="users_add">
                            <label class="form-check-label" for="users_add">{{ __('Create') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="users_view" id="users_view">
                            <label class="form-check-label" for="users_view">{{ __('View') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="users_update" id="users_update">
                            <label class="form-check-label" for="users_update">{{ __('Edit') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="users_delete" id="users_delete">
                            <label class="form-check-label" for="users_delete">{{ __('Delete') }}</label>
                        </div>
                    </div>

                    <label class="form-label fw-bold">{{ __('Plans') }}</label>
                    <div class="mb-4 d-flex justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="plans_add" id="plans_add">
                            <label class="form-check-label" for="plans_add">{{ __('Create') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="plans_view" id="plans_view">
                            <label class="form-check-label" for="plans_view">{{ __('View') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="plans_update" id="plans_update">
                            <label class="form-check-label" for="plans_update">{{ __('Edit') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="plans_delete" id="plans_delete">
                            <label class="form-check-label" for="plans_delete">{{ __('Delete') }}</label>
                        </div>
                    </div>

                    <label class="form-label fw-bold">{{ __('Settings') }}</label>
                    <div class="mb-4 d-flex justify-content-between">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" disabled id="settings_add">
                            <label class="form-check-label" for="settings_add">{{ __('Create') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="settings_view" id="settings_view">
                            <label class="form-check-label" for="settings_view">{{ __('View') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model="settings_update" id="settings_update">
                            <label class="form-check-label" for="settings_update">{{ __('Edit') }}</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" disabled id="settings_delete">
                            <label class="form-check-label" for="settings_delete">{{ __('Delete') }}</label>
                        </div>
                    </div>
                </div>

    
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="resetToDefault" data-bs-dismiss="modal">{{ __('Close') }}</button>
                    <button type="button" class="btn btn-primary" wire:click="saveRole">{{ __('Add Role') }}</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modal-editrole" tabindex="-1" aria-labelledby="modal-editoleLabel" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-editroleLabel">{{ __('Edit') .': '. $role_name_ar }}</h5>
                    <button type="button" class="btn-close" wire:click="resetToDefault" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                @if ($current_role)
                    <div class="modal-body">
        
                        <!-- الاسم بالعربي والإنجليزي -->
                        <div class="mb-3 row">
                            <div class="col">
                                <label for="role_name_ar" class="form-label fw-bold">{{ __('Role Name (Arabic)') }}</label>
                                <input class="form-control @error('role_name_ar') is-invalid @enderror" type="text" wire:model="role_name_ar" placeholder="{{ __('Enter role name in Arabic') }}" required autofocus>
                                @error('role_name_ar')
                                    <small class="invalid-feedback d-block">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="role_name_en" class="form-label fw-bold">{{ __('Role Name (English)') }}</label>
                                <input class="form-control @error('role_name_en') is-invalid @enderror" type="text" wire:model="role_name_en" placeholder="{{ __('Enter role name in English') }}" required>
                                @error('role_name_en')
                                    <small class="invalid-feedback d-block">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
        
                        <!-- الرمز الفريد -->
                        <div class="mb-3">
                            <label for="role_slug" class="form-label fw-bold">{{ __('Unique Code') }}</label>
                            <input class="form-control @error('role_slug') is-invalid @enderror" type="text" wire:model="role_slug" placeholder="{{ __('Enter Unique Code') }}" required>
                            @error('role_slug')
                                <small class="invalid-feedback d-block">{{ $message }}</small>
                            @enderror
                        </div>   
                    <!-- جدول الأذونات -->
                    <div class="mb-3">

                        <label class="form-label fw-bold">{{ __('Roles') }}</label>
                        <div class="mb-4 d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="roles_add" id="roles_add">
                                <label class="form-check-label" for="roles_add">{{ __('Create') }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="roles_view" id="roles_view">
                                <label class="form-check-label" for="roles_view">{{ __('View') }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="roles_update" id="roles_update">
                                <label class="form-check-label" for="roles_update">{{ __('Edit') }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="roles_delete" id="roles_delete">
                                <label class="form-check-label" for="roles_delete">{{ __('Delete') }}</label>
                            </div>
                        </div>

                        <label class="form-label fw-bold">{{ __('Employees') }}</label>
                        <div class="mb-4 d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="employees_add" id="employees_add">
                                <label class="form-check-label" for="employees_add">{{ __('Create') }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="employees_view" id="employees_view">
                                <label class="form-check-label" for="employees_view">{{ __('View') }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="employees_update" id="employees_update">
                                <label class="form-check-label" for="employees_update">{{ __('Edit') }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="employees_delete" id="employees_delete">
                                <label class="form-check-label" for="employees_delete">{{ __('Delete') }}</label>
                            </div>
                        </div>

                        <label class="form-label fw-bold">{{ __('Users') }}</label>
                        <div class="mb-4 d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="users_add" id="users_add">
                                <label class="form-check-label" for="users_add">{{ __('Create') }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="users_view" id="users_view">
                                <label class="form-check-label" for="users_view">{{ __('View') }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="users_update" id="users_update">
                                <label class="form-check-label" for="users_update">{{ __('Edit') }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="users_delete" id="users_delete">
                                <label class="form-check-label" for="users_delete">{{ __('Delete') }}</label>
                            </div>
                        </div>

                        <label class="form-label fw-bold">{{ __('Plans') }}</label>
                        <div class="mb-4 d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="plans_add" id="plans_add">
                                <label class="form-check-label" for="plans_add">{{ __('Create') }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="plans_view" id="plans_view">
                                <label class="form-check-label" for="plans_view">{{ __('View') }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="plans_update" id="plans_update">
                                <label class="form-check-label" for="plans_update">{{ __('Edit') }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="plans_delete" id="plans_delete">
                                <label class="form-check-label" for="plans_delete">{{ __('Delete') }}</label>
                            </div>
                        </div>

                        <label class="form-label fw-bold">{{ __('Settings') }}</label>
                        <div class="mb-4 d-flex justify-content-between">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" disabled id="settings_add">
                                <label class="form-check-label" for="settings_add">{{ __('Create') }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="settings_view" id="settings_view">
                                <label class="form-check-label" for="settings_view">{{ __('View') }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" wire:model="settings_update" id="settings_update">
                                <label class="form-check-label" for="settings_update">{{ __('Edit') }}</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" disabled id="settings_delete">
                                <label class="form-check-label" for="settings_delete">{{ __('Delete') }}</label>
                            </div>
                        </div>
                    </div>
                    </div>
        
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" wire:click="resetToDefault" data-bs-dismiss="modal">{{ __('Close') }}</button>
                        <button type="button" class="btn btn-primary" wire:click="updateRole">{{ __('Save changes') }}</button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        window.addEventListener('makeAction', event => {

            window["iziToast"][event.detail.type]({
                    title: `${event.detail.title}`,
                    message: `${event.detail.msg}`,
                    position: 'topLeft',
                    rtl: true,
            });
            $('#modal-newemployee').modal('hide');
            $(event.detail.modal).modal('hide');
            
        })

        window.addEventListener('showEditModale', event => {

            $(event.detail.modal).modal('show');
            
        })

        window.addEventListener('editUser', event => {

            @this.confirm_edit(event.detail.id)
        })
        window.addEventListener('editRole', event => {

            @this.confirm_role_edit(event.detail.id)
        })

        window.addEventListener('deleteUser', event => {

            window["iziToast"][event.detail.type]({
                message: `${event.detail.msg}`,
                rtl: true,
                timeout: 20000,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999999999,
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {

                        @this.confirm_delete(event.detail.id)
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }],
                ]
            });

        })

        window.addEventListener('deleteRole', event => {

            window["iziToast"][event.detail.type]({
                message: `${event.detail.msg}`,
                rtl: true,
                timeout: 20000,
                overlay: true,
                displayMode: 'once',
                id: 'question',
                zindex: 999999999,
                position: 'center',
                buttons: [
                    ['<button><b>YES</b></button>', function (instance, toast) {

                        @this.confirm_role_delete(event.detail.id)
                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');
                        
                    }, true],
                    ['<button>NO</button>', function (instance, toast) {

                        instance.hide({ transitionOut: 'fadeOut' }, toast, 'button');

                    }],
                ]
            });

        })
    </script>
    
</div>