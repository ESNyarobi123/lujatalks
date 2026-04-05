<?php

use App\Providers\AppServiceProvider;
use App\Providers\FortifyServiceProvider;

return array_values(array_filter([
    AppServiceProvider::class,
    FortifyServiceProvider::class,
    class_exists(\Laravel\Socialite\SocialiteServiceProvider::class)
        ? \Laravel\Socialite\SocialiteServiceProvider::class
        : null,
]));
