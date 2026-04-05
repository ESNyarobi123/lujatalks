<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.public')]
#[Title('Categories')]
class CategoriesIndex extends Component
{
    public function render()
    {
        return view('livewire.categories-index', [
            'categories' => Category::withCount('posts')
                ->has('posts')
                ->orderByDesc('posts_count')
                ->get(),
        ]);
    }
}
