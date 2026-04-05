<?php

namespace App\Livewire\Admin\Subscribers;

use App\Models\Subscriber;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $status = 'all';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function toggleStatus(Subscriber $subscriber)
    {
        $subscriber->update([
            'is_active' => !$subscriber->is_active
        ]);
        session()->flash('status', 'Subscriber status updated.');
    }

    public function delete(Subscriber $subscriber)
    {
        $subscriber->delete();
        session()->flash('status', 'Subscriber removed successfully.');
    }

    public function exportCsv()
    {
        // Simple manual CSV export for admin
        $subscribers = Subscriber::where('is_active', true)->get();
        $csvData = "Email,Joined Date\n";
        foreach ($subscribers as $sub) {
            $csvData .= "{$sub->email},{$sub->created_at->format('Y-m-d')}\n";
        }
        
        return response()->streamDownload(function () use ($csvData) {
            echo $csvData;
        }, 'active-subscribers.csv');
    }

    public function render()
    {
        $subscribers = Subscriber::query()
            ->when($this->search, function ($q) {
                $q->where('email', 'like', '%' . $this->search . '%');
            })
            ->when($this->status !== 'all', function ($q) {
                $q->where('is_active', $this->status === 'active');
            })
            ->latest()
            ->paginate(20);

        return view('livewire.admin.subscribers.index', [
            'subscribers' => $subscribers
        ]);
    }
}
