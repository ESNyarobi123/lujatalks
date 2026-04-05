<?php

namespace App\Livewire\Admin\Settings;

use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Homepage extends Component
{
    public function render()
    {
        return view('livewire.admin.settings.homepage');
    }
}
