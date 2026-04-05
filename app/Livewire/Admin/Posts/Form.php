<?php

namespace App\Livewire\Admin\Posts;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Form extends Component
{
    public ?Post $post = null;

    public string $title = '';
    public string $slug = '';
    public string $content = '';
    public ?int $category_id = null;
    public string $status = 'draft';
    public ?string $feature_image = null;
    public bool $is_trending = false;

    public function mount(?Post $post = null)
    {
        if ($post && $post->exists) {
            $this->post = $post;
            $this->title = $post->title;
            $this->slug = $post->slug;
            $this->content = $post->content;
            $this->category_id = $post->category_id;
            $this->status = $post->status;
            $this->feature_image = $post->feature_image;
            $this->is_trending = $post->is_trending;
        }
    }

    public function updatedTitle($value)
    {
        if (! $this->post || ! $this->post->exists) {
            $this->slug = Str::slug($value);
        }
    }

    public function save()
    {
        $this->validate([
            'title' => 'required|max:255',
            'slug' => 'required|max:255|unique:posts,slug,' . ($this->post?->id ?? 'NULL'),
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'status' => 'required|in:draft,published',
            'feature_image' => 'nullable|url',
            'is_trending' => 'boolean',
        ]);

        $data = [
            'title' => $this->title,
            'slug' => Str::slug($this->slug),
            'content' => $this->content,
            'category_id' => $this->category_id,
            'status' => $this->status,
            'feature_image' => $this->feature_image,
            'is_trending' => $this->is_trending,
            'user_id' => auth()->id(),
        ];

        if ($this->status === 'published' && (! $this->post || ! $this->post->published_at)) {
            $data['published_at'] = now();
        }

        if ($this->post && $this->post->exists) {
            $this->post->update($data);
        } else {
            $this->post = Post::create($data);
        }

        session()->flash('status', 'Post successfully saved.');

        return $this->redirectRoute('admin.posts.index', navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.posts.form', [
            'categories' => Category::orderBy('name')->get(),
        ]);
    }
}
