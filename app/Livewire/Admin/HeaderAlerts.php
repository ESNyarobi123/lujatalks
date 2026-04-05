<?php

namespace App\Livewire\Admin;

use App\Models\Report;
use Livewire\Component;

class HeaderAlerts extends Component
{
    public function render()
    {
        $pendingReports = Report::query()->where('status', 'pending')->count();

        $recentReports = Report::query()
            ->with(['user', 'reportable'])
            ->where('status', 'pending')
            ->latest()
            ->take(5)
            ->get();

        return view('livewire.admin.header-alerts', [
            'pendingReports' => $pendingReports,
            'recentReports' => $recentReports,
        ]);
    }
}
