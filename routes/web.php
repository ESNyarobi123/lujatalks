<?php

use App\Livewire\AboutPage;
use App\Livewire\AuthorProfilePage;
use App\Livewire\CategoriesIndex;
use App\Livewire\CategoryPosts;
use App\Livewire\CommunityPage;
use App\Livewire\ExplorePage;
use App\Livewire\GlobalSearch;
use App\Livewire\GrowthDashboard;
use App\Livewire\MissionsHub;
use App\Livewire\HomePage;
use App\Livewire\MyGoals;
use App\Livewire\Notifications;
use App\Livewire\Posts\Show;
use App\Livewire\SavedPosts;
use App\Livewire\VideosPage;
use Illuminate\Support\Facades\Route;

Route::get('/', HomePage::class)->name('home');
Route::get('/authors/{profile_slug}', AuthorProfilePage::class)->name('authors.show');
Route::get('/posts/{slug}', Show::class)->name('posts.show');
Route::get('/explore', ExplorePage::class)->name('explore');
Route::get('/videos', VideosPage::class)->name('videos');
Route::get('/categories', CategoriesIndex::class)->name('categories.index');
Route::get('/categories/{slug}', CategoryPosts::class)->name('categories.show');
Route::get('/community', CommunityPage::class)->name('community');
Route::get('/about', AboutPage::class)->name('about');
Route::get('/search', GlobalSearch::class)->name('search');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', GrowthDashboard::class)->name('dashboard');
    Route::get('missions', MissionsHub::class)->name('missions');
    Route::get('saved', SavedPosts::class)->name('saved');
    Route::get('goals', MyGoals::class)->name('goals');
    Route::get('notifications', Notifications::class)->name('notifications');

    // Admin Routes (restricted to admin role)
    Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/', \App\Livewire\Admin\Dashboard::class)->name('dashboard');
        
        Route::get('/posts', \App\Livewire\Admin\Posts\Index::class)->name('posts.index');
        Route::get('/posts/create', \App\Livewire\Admin\Posts\Form::class)->name('posts.create');
        Route::get('/posts/{post}/edit', \App\Livewire\Admin\Posts\Form::class)->name('posts.edit');

        Route::get('/videos', \App\Livewire\Admin\Videos\Index::class)->name('videos.index');
        Route::get('/categories', \App\Livewire\Admin\Categories\Index::class)->name('categories.index');
        Route::get('/tags', \App\Livewire\Admin\Tags\Index::class)->name('tags.index');
        Route::get('/users', \App\Livewire\Admin\Users\Index::class)->name('users.index');

        Route::get('/quotes', \App\Livewire\Admin\Quotes\Index::class)->name('quotes.index');
        Route::get('/comments', \App\Livewire\Admin\Comments\Index::class)->name('comments.index');
        Route::get('/reports', \App\Livewire\Admin\Reports\Index::class)->name('reports.index');
        Route::get('/subscribers', \App\Livewire\Admin\Subscribers\Index::class)->name('subscribers.index');

        Route::get('/settings/general', \App\Livewire\Admin\Settings\General::class)->name('settings.general');
        Route::get('/settings/roles', \App\Livewire\Admin\Settings\Roles::class)->name('settings.roles');
        Route::get('/settings/media', \App\Livewire\Admin\Settings\Media::class)->name('settings.media');
        Route::get('/settings/homepage', \App\Livewire\Admin\Settings\Homepage::class)->name('settings.homepage');
    });
});

require __DIR__.'/settings.php';
