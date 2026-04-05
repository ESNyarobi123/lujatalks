<?php

namespace App\Livewire;

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.public')]
#[Title('About Luja Talks')]
class AboutPage extends Component
{
    public function render()
    {
        return view('livewire.about-page');
    }
}
