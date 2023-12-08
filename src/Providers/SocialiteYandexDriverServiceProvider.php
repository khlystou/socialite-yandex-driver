<?php

declare(strict_types=1);

namespace Khlystou\SocialiteYandexDriver\Providers;

use Illuminate\Support\ServiceProvider;
use Khlystou\SocialiteYandexDriver\YandexProvider;
use Laravel\Socialite\Contracts\Factory;

final class SocialiteYandexDriverServiceProvider extends ServiceProvider
{
    public function boot(): void
    {        
        $socialite = $this->app->make(Factory::class);

        $socialite->extend('yandex', function($app) use($socialite) {
            return $socialite->buildProvider(
                YandexProvider::class, 
                $app['config']['services.yandex']
            );
        });
    }
}
