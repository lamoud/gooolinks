<?php

namespace App\Livewire\Backend\Users;

use App\Exports\UsersExport;
use App\Models\User;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class Users extends Component
{
    public function exportCsv()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }
    public function show()
    {
        dd('User data');
    }
    
    public function confirm_delete( $id )
    {
        $user = User::find($id);

        $roles = ['super_admin', 'admin'];
        if( $user->hasAnyRole($roles) ){
            return $this->dispatch('makeAction', type: 'error', title: __('Error'), msg: 'لا يمكن حذف مسئول النظام!');
        }
        $user->delete();
        $this->dispatch('refreshDatatable');
        return $this->dispatch('makeAction', type: 'success', title: __('Ok'), msg: 'تم حذف المستخدم بنجاح!');

    }

    public function render()
    {
        return view('livewire.backend.users.users');
    }
}
