<?php

namespace App\Livewire\Backend\StaffRoles;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;
use Spatie\Permission\Models\Role;
use Stripe\StripeClient;

class RolesTable extends DataTableComponent
{
    //protected $model = User::class;
    public function builder(): Builder
    {
        return Role::query();
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        

        return [
            Column::make(__('Serial Number'), "id")
                ->sortable()
                ->searchable()
                ->format(function($value) {
                    return 'EL-' . str_pad($value, 5, '0', STR_PAD_LEFT);
                }),
                Column::make(__('Name'), "name")
                ->sortable()
                ->searchable()
                ->format(function($value) {
                    return Str::limit($value, 12); // حصر الاسم إلى 10 أحرف
                }),
                Column::make(__('Role'), "display_name")
                ->sortable()
                ->searchable()
                ->format(function($value) {
                    return Str::limit($value, 12); // حصر الاسم إلى 10 أحرف
                }),
            Column::make(__('Number of employees'))
                ->label(function ($row) {
                    $count = User::role($row->name)->count();
                    return $count;
                }),
            Column::make(__('Date added'), "created_at")
                ->sortable()
                ->format(function($value) {
                    return Carbon::parse($value)->translatedFormat('j F Y');
                }),

            Column::make(__('Last Updated'), "updated_at")
                ->sortable()
                ->deselected()
                ->format(function($value) {
                    return Carbon::parse($value)->translatedFormat('j F Y');
                }),
            Column::make(__('Actions'))
                ->label(function ($row) {
                    return view('livewire.backend.staff-roles.actions.role-actions', ['row' => $row]); // قم بإنشاء view خاص بالإجراءات
                })
        ];

    }


    public function editRole($id)
    {
        return $this->dispatch('editRole', id: $id);

    }

    public function deleteRole($id)
    {
        return $this->dispatch('deleteRole', id: $id, type: 'question', msg: 'هل ترغب في حذف الدور؟');
    }

}
