<?php

use App\Models\User;
use Livewire\Livewire;

test('notification settings page is displayed', function () {
    $this->actingAs(User::factory()->create());

    $this->get(route('settings.notifications'))->assertOk();
});

test('user can disable like notifications', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    Livewire::test('pages::settings.notifications')
        ->set('notifyLikes', false)
        ->call('save')
        ->assertHasNoErrors();

    expect($user->fresh()->wantsInAppNotification('likes'))->toBeFalse();
});
