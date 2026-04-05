<?php

namespace App\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.admin')]
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public bool $showModal = false;
    
    public ?int $editingId = null;
    public string $name = '';
    public string $slug = '';
    public string $description = '';

    public function updatedName($value)
    {
        if (! $this->editingId) {
            $this->slug = Str::slug($value);
        }
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['editingId', 'name', 'slug', 'description']);
        $this->showModal = true;
    }

    public function edit(Category $category)
    {
        $this->resetValidation();
        $this->editingId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description ?? '';
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:categories,slug,' . ($this->editingId ?? 'null'),
            'description' => 'nullable|max:500',
        ]);

        Category::updateOrCreate(
            ['id' => $this->editingId],
            [
                'name' => $this->name,
                'slug' => Str::slug($this->slug),
                'description' => $this->description,
            ]
        );

        $this->showModal = false;
        $this->reset(['editingId', 'name', 'slug', 'description']);
        session()->flash('status', 'Category saved successfully!');
    }

    public function delete(Category $category)
    {
        if ($category->posts()->count() > 0) {
            session()->flash('error', 'Cannot delete. Category is attached to posts.');
            return;
        }

        $category->delete();
        session()->flash('status', 'Category deleted successfully!');
    }

    public function render()
    {
        return view('livewire.admin.categories.index', [
            'categories' => Category::withCount('posts')
                ->where('name', 'like', '%' . $this->search . '%')
                ->orderBy('name')
                ->paginate(15),
        ]);
    }
}
