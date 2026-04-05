<?php

namespace App\Livewire\Admin\Videos;

use App\Models\Post;
use App\Models\Video;
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
    public string $title = '';
    public string $youtube_url = '';
    public ?string $duration = '';
    public ?int $post_id = null;

    public function create()
    {
        $this->resetValidation();
        $this->reset(['editingId', 'title', 'youtube_url', 'duration', 'post_id']);
        $this->showModal = true;
    }

    public function edit(Video $video)
    {
        $this->resetValidation();
        $this->editingId = $video->id;
        $this->title = $video->title;
        $this->youtube_url = $video->youtube_url;
        $this->duration = $video->duration;
        $this->post_id = $video->post_id;
        $this->showModal = true;
    }

    public function extractVideoId(string $url): ?string
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/\s]{11})%i', $url, $match);
        return $match[1] ?? null;
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|max:255',
            'youtube_url' => 'required|url',
            'duration' => 'nullable|max:50',
            'post_id' => 'nullable|exists:posts,id',
        ]);

        $videoId = $this->extractVideoId($this->youtube_url);
        if (!$videoId) {
            $this->addError('youtube_url', 'Invalid YouTube URL format.');
            return;
        }

        Video::updateOrCreate(
            ['id' => $this->editingId],
            [
                'title' => $this->title,
                'youtube_url' => $this->youtube_url,
                'duration' => $this->duration,
                'post_id' => $this->post_id ?: null,
            ]
        );

        $this->showModal = false;
        $this->reset(['editingId', 'title', 'youtube_url', 'duration', 'post_id']);
        session()->flash('status', 'Video saved successfully!');
    }

    public function delete(Video $video)
    {
        $video->delete();
        session()->flash('status', 'Video deleted successfully!');
    }

    public function render()
    {
        return view('livewire.admin.videos.index', [
            'videos' => Video::with('post')
                ->where('title', 'like', '%' . $this->search . '%')
                ->latest()
                ->paginate(12),
            'posts' => Post::orderBy('title')->get(),
        ]);
    }
}
