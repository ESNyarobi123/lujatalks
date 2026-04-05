<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.public')]
#[Title('Notifications')]
class Notifications extends Component
{
    public string $filter = 'all';

    public function markAsRead(string $notificationId): void
    {
        auth()->user()->notifications()->where('id', $notificationId)->first()?->markAsRead();
    }

    public function markAllAsRead(): void
    {
        auth()->user()->unreadNotifications->markAsRead();
    }

    public function deleteNotification(string $notificationId): void
    {
        auth()->user()->notifications()->where('id', $notificationId)->delete();
    }

    public function render()
    {
        $query = match ($this->filter) {
            'unread' => auth()->user()->unreadNotifications(),
            'read' => auth()->user()->readNotifications(),
            default => auth()->user()->notifications(),
        };

        return view('livewire.notifications', [
            'notifications' => $query->latest()->get(),
            'unreadCount' => auth()->user()->unreadNotifications()->count(),
        ]);
    }
}
