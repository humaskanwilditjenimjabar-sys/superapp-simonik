<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Component;

class ViewUser extends Component
{
    public User $user;
    public int $userId;

    public function mount(int $userId): void
    {
        $this->userId = $userId;
        $this->user = User::with(['kanim', 'kanwil'])->findOrFail($userId);
    }

    public function render()
    {
        return view('admin.users.view');
    }
}