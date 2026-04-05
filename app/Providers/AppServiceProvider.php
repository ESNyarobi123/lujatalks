<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Post;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();

        $forgetNavCategories = function (): void {
            Cache::forget('nav_categories_v1');
            Cache::forget('nav_categories_v2');
        };

        Post::saved($forgetNavCategories);
        Post::deleted($forgetNavCategories);
        Category::saved($forgetNavCategories);
        Category::deleted($forgetNavCategories);

        View::composer('layouts.public', function ($view): void {
            /** @var list<array{name: string, slug: string}> $links */
            $links = Cache::remember('nav_categories_v2', now()->addMinutes(10), function (): array {
                return Category::query()
                    ->has('posts')
                    ->orderBy('name')
                    ->take(16)
                    ->get(['name', 'slug'])
                    ->map(fn (Category $c): array => [
                        'name' => $c->name,
                        'slug' => $c->slug,
                    ])
                    ->values()
                    ->all();
            });

            $view->with('navCategories', $links);
        });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(fn (): ?Password => app()->isProduction()
            ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
            : null,
        );
    }
}
