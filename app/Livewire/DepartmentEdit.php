<?php
namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Department;
use App\Models\Position;

class DepartmentEdit extends Component
{
    public function render()
    {
        return view('livewire.department-edit');
    }
    public function editable($id)
    {
        $department = Department::find($id);
        return view('livewire.department-edit', [
            'department_livewire' => $department
        ]);
    }
}
