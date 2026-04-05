<?php

namespace App\Livewire\Admin\Quotes;

use App\Models\Motivation;
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
    public string $quote = '';
    public string $author = '';
    public string $message = '';
    public string $display_date = '';

    public function create()
    {
        $this->resetValidation();
        $this->reset(['editingId', 'quote', 'author', 'message', 'display_date']);
        $this->display_date = now()->format('Y-m-d');
        $this->showModal = true;
    }

    public function edit(Motivation $motivation)
    {
        $this->resetValidation();
        $this->editingId = $motivation->id;
        $this->quote = $motivation->quote;
        $this->author = $motivation->author ?? '';
        $this->message = $motivation->message ?? '';
        $this->display_date = $motivation->display_date ? $motivation->display_date->format('Y-m-d') : now()->format('Y-m-d');
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate([
            'quote' => 'required|max:1000',
            'author' => 'nullable|max:255',
            'message' => 'nullable|max:1000',
            'display_date' => 'required|date',
        ]);

        Motivation::updateOrCreate(
            ['id' => $this->editingId],
            [
                'quote' => $this->quote,
                'author' => $this->author,
                'message' => $this->message,
                'display_date' => $this->display_date,
            ]
        );

        $this->showModal = false;
        $this->reset(['editingId', 'quote', 'author', 'message', 'display_date']);
        session()->flash('status', 'Quote saved successfully!');
    }

    public function delete(Motivation $motivation)
    {
        $motivation->delete();
        session()->flash('status', 'Quote removed.');
    }

    public function render()
    {
        return view('livewire.admin.quotes.index', [
            'quotes' => Motivation::query()
                ->where('quote', 'like', '%' . $this->search . '%')
                ->orWhere('author', 'like', '%' . $this->search . '%')
                ->orderBy('display_date', 'desc')
                ->paginate(15)
        ]);
    }
}
