<?php

namespace App\Livewire\Posts;

use App\Models\Post;
use App\Models\PostRead;
use Illuminate\Support\Str;
use Livewire\Component;

class Show extends Component
{
    public Post $post;

    public function mount(string $slug): void
    {
        $this->post = Post::where('slug', $slug)
            ->where('status', 'published')
            ->with(['user', 'category', 'tags', 'videos'])
            ->firstOrFail();

        $this->post->increment('views_count');

        if (auth()->check()) {
            PostRead::query()->updateOrCreate(
                [
                    'user_id' => auth()->id(),
                    'post_id' => $this->post->id,
                ],
                ['last_opened_at' => now()],
            );
        }
    }

    public function render()
    {
        $relatedPosts = Post::with(['user', 'category'])
            ->where('status', 'published')
            ->where('id', '!=', $this->post->id)
            ->where(function ($q) {
                $q->where('category_id', $this->post->category_id)
                    ->orWhereHas('tags', function ($tq) {
                        $tq->whereIn('tags.id', $this->post->tags->pluck('id'));
                    });
            })
            ->inRandomOrder()
            ->take(3)
            ->get();

        $description = Str::limit(trim(preg_replace('/\s+/', ' ', strip_tags($this->post->content))), 160);

        $feature = $this->post->feature_image;
        $ogImage = null;
        if (is_string($feature) && $feature !== '') {
            $ogImage = str_starts_with($feature, 'http://') || str_starts_with($feature, 'https://')
                ? $feature
                : url($feature);
        }

        return view('livewire.posts.show', [
            'relatedPosts' => $relatedPosts,
        ])
            ->title($this->post->title.' · Luja Talks')
            ->layout('layouts.public', [
                'metaDescription' => $description,
                'ogTitle' => $this->post->title,
                'ogDescription' => $description,
                'ogUrl' => route('posts.show', $this->post->slug),
                'ogImage' => $ogImage,
                'canonicalUrl' => route('posts.show', $this->post->slug),
            ]);
    }
}
