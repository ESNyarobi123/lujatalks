<?php

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Notification settings')] class extends Component
{
    public bool $notifyLikes = true;

    public bool $notifyCommentsOnPosts = true;

    public bool $notifyReplies = true;

    public function mount(): void
    {
        $prefs = Auth::user()->notification_prefs ?? [];
        $this->notifyLikes = ($prefs['likes'] ?? true) !== false;
        $this->notifyCommentsOnPosts = ($prefs['comments_on_posts'] ?? true) !== false;
        $this->notifyReplies = ($prefs['replies'] ?? true) !== false;
    }

    public function save(): void
    {
        Auth::user()->update([
            'notification_prefs' => [
                'likes' => $this->notifyLikes,
                'comments_on_posts' => $this->notifyCommentsOnPosts,
                'replies' => $this->notifyReplies,
            ],
        ]);

        session()->flash('status', 'notifications-saved');
    }
}; ?>

<section class="w-full">
    @include('partials.settings-heading')

    <flux:heading class="sr-only">{{ __('Notification settings') }}</flux:heading>

    <x-pages::settings.layout :heading="__('In-app notifications')" :subheading="__('Choose what we notify you about on Luja Talks')">
        <form wire:submit="save" class="my-6 w-full space-y-6">
            <flux:checkbox wire:model="notifyLikes" :label="__('When someone likes my articles or comments')" />

            <flux:checkbox wire:model="notifyCommentsOnPosts" :label="__('When someone comments on my articles')" />

            <flux:checkbox wire:model="notifyReplies" :label="__('When someone replies to my comments')" />

            <div class="flex items-center gap-4">
                <flux:button variant="primary" type="submit" data-test="save-notifications-button">
                    {{ __('Save') }}
                </flux:button>

                @if (session('status') === 'notifications-saved')
                    <flux:text class="text-sm font-medium text-green-600 dark:text-green-400">
                        {{ __('Saved.') }}
                    </flux:text>
                @endif
            </div>
        </form>
    </x-pages::settings.layout>
</section>
