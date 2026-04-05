<?php

namespace App\Livewire\Admin\Tags;

use App\Models\Tag;
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

    public function updatedName($value)
    {
        if (! $this->editingId) {
            $this->slug = Str::slug($value);
        }
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['editingId', 'name', 'slug']);
        $this->showModal = true;
    }

    public function edit(Tag $tag)
    {
        $this->resetValidation();
        $this->editingId = $tag->id;
        $this->name = $tag->name;
        $this->slug = $tag->slug;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'name' => 'required|max:255',
            'slug' => 'required|max:255|unique:tags,slug,' . ($this->editingId ?? 'null'),
        ]);

        Tag::updateOrCreate(
            ['id' => $this->editingId],
            [
                'name' => $this->name,
                'slug' => Str::slug($this->slug),
            ]
        );

        $this->showModal = false;
        $this->reset(['editingId', 'name', 'slug']);
        session()->flash('status', 'Tag saved successfully!');
    }

    public function delete(Tag $tag)
    {
        $tag->delete(); // Usually safely cascades on pivot
        session()->flash('status', 'Tag deleted successfully!');
    }

    public function render()
    {
        return view('livewire.admin.tags.index', [
            'tags' => Tag::withCount('posts')
                ->where('name', 'like', '%' . $this->search . '%')
                ->orderBy('name')
                ->paginate(20),
        ]);
    }
}
