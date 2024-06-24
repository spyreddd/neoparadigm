<?php

namespace App\Http\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class TableComponent extends Component
{   
    public $userId;
    protected $listeners = ['deleteUser', 'reRenderTable'];

    public function render()
    {
        return view('livewire.users.table-component', [
            'users' => User::get(),
        ]);
    }

    public function confirmDelete($id)
    {
        $this->userId = $id;

        $this->dispatchBrowserEvent('showConfirmModal');
    }

    public function deleteUser()
    {
        $user = User::find($this->userId);

        if ($user) {
            $user->delete();
        }
        flash('Success delete!', 'success');
    }

    public function edit(User $user){
        $this->dispatchBrowserEvent('update-user', $user);
    }

    public function reRenderTable(){
        $this->render();
    }
}
