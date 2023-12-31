<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use App\Models\Transaction;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\UserLogin;
use App\Models\Department;
use App\Models\Position;


class PositionManagement extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';

    #[Rule('required', message: '役職名を入力してください')]
    #[Rule('max:128', message: '役職名が長すぎます')]
    #[Rule('unique:positions,position_name', message: 'その役職名は既に登録されています')]
    public $save_position_name;

    public $update_position_name;

    public $cancel = false;

    #[Rule('required', message: '権威レベルを入力してください')]
    #[Rule('numeric', message: '数字で入力してください')]
    #[Rule('between:0,100', message: '0から100の範囲で入力してください')]
    public $rank;

    public $editPositionId;
    public $editing = false;

    public function initialize()
    {
        $this->update_position_name = null;
        $this->save_position_name = null;
        $this->rank = null;
    }

    public function render()
    {
        $company_id = User::where('user_id', Auth::user()->id)->first()->company_id;
        return view('livewire.position-management', [
            'positions' => Position::where('company_id', $company_id)->orderBy('rank', 'desc')->paginate(14)
        ]);
    }

    public function save()
    {
        $this->validate();
        $user = User::where('user_id', Auth::user()->id)->first();

        $position = Position::create([
            'position_name' => $this->save_position_name,
            'company_id' => $user->company_id,
            'rank' => $this->rank
        ]);
        $position->save();
        
        session()->flash('successPosition', '部署を作成しました。');
        return redirect('/position-management');
    }

    public function edit($id)
    {
        $this->editing = true;
        $this->editPositionId = $id;
    }

    public function update()
    {
        if ($this->editing == false || ($this->update_position_name == null && $this->rank == null)) {
            $this->initialize();
            return;
        }

        $this->validate([
            'update_position_name' => 'max:128|unique:positions,position_name,' . $this->editPositionId,
            'rank' => 'between:0,100'
        ], [
            'update_position_name.max' => '役職名が長すぎます',
            'update_position_name.unique' => 'その役職名は既に登録されています',
            'rank.between' => '0から100の範囲で入力してください'
        ]);

        $position = Position::where('id', $this->editPositionId)->first();
        if (!empty(trim($this->update_position_name))) {
            $position->position_name = $this->update_position_name;
        }

    
        if (!empty(trim($this->rank))) {
            if (is_numeric($this->rank)) {
                $position->rank = $this->rank;
            } else {
                session()->flash('typeNumber', '数字で入力してください');
                return;
            }
        }
        $position->save();
        session()->flash('successPosition', '役職を更新しました。');
        $this->editing = false;
        $this->initialize();
        return;
    }
}