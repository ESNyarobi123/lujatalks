<?php

namespace App\Livewire\Admin\Reports;

use App\Models\Report;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public string $status = 'pending';

    public function updatingStatus()
    {
        $this->resetPage();
    }

    public function markResolved(Report $report)
    {
        $report->update(['status' => 'resolved']);
        session()->flash('status', 'Report marked as resolved.');
    }

    public function dismiss(Report $report)
    {
        $report->update(['status' => 'dismissed']);
        session()->flash('status', 'Report dismissed.');
    }
    
    public function deleteReportable(Report $report)
    {
        if ($report->reportable) {
            $report->reportable->delete();
        }
        $report->update(['status' => 'resolved']);
        session()->flash('status', 'Content deleted and report resolved.');
    }

    public function render()
    {
        return view('livewire.admin.reports.index', [
            'reports' => Report::with(['user', 'reportable'])
                ->when($this->status !== 'all', function ($q) {
                    $q->where('status', $this->status);
                })
                ->latest()
                ->paginate(15)
        ]);
    }
}
