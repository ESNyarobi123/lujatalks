<?php

namespace App\Livewire\Admin\Users;

use App\Models\User;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $role = 'all';

    public function mount(): void
    {
        if (request()->filled('search')) {
            $this->search = (string) request()->query('search');
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingRole()
    {
        $this->resetPage();
    }

    public function changeRole(User $user, string $newRole)
    {
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot change your own role.');
            return;
        }

        $user->update(['role' => $newRole]);
        session()->flash('status', 'User role updated to ' . $newRole);
    }

    public function delete(User $user)
    {
        if ($user->id === auth()->id()) {
            session()->flash('error', 'You cannot delete yourself.');
            return;
        }

        if ($user->isAdmin()) {
            session()->flash('error', 'Cannot delete admin users directly. Change role first.');
            return;
        }

        // Using soft deletes or cascade on db level would be best. For now delete directly.
        $user->delete();
        session()->flash('status', 'User deleted successfully.');
    }

    public function render()
    {
        $users = User::query()
            ->withCount(['posts', 'comments', 'savedPosts'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->role !== 'all', function ($query) {
                $query->where('role', $this->role);
            })
            ->latest()
            ->paginate(15);

        return view('livewire.admin.users.index', [
            'users' => $users,
        ]);
    }
}
