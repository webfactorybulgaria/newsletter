<?php

namespace TypiCMS\Modules\Newsletter\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Newsletter\Custom\Events\EventHandler;
use TypiCMS\Modules\Newsletter\Custom\Models\Newsletter;
use TypiCMS\Modules\Newsletter\Custom\Repositories\CacheDecorator;
use TypiCMS\Modules\Newsletter\Custom\Repositories\EloquentNewsletter;
use TypiCMS\Modules\Core\Custom\Facades\TypiCMS;
use TypiCMS\Modules\Core\Custom\Observers\FileObserver;
use TypiCMS\Modules\Core\Custom\Services\Cache\LaravelCache;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/laravel-newsletter.php', 'typicms.newsletter'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['newsletter' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'newsletter');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'newsletter');

        $this->publishes([
            __DIR__.'/../config/laravel-newsletter.php' => config_path('laravel-newsletter.php'),
        ]);

        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/newsletter'),
        ], 'views');
        $this->publishes([
            __DIR__.'/../database' => base_path('database'),
        ], 'migrations');

        // Honeypot facade
        AliasLoader::getInstance()->alias(
            'Honeypot',
            'Msurguy\Honeypot\HoneypotFacade'
        );

        $this->app->register('Maatwebsite\Excel\ExcelServiceProvider');
        $this->app->register('Spatie\Newsletter\NewsletterServiceProvider');

        // Spatie Newsletter facade
        AliasLoader::getInstance()->alias(
            'VNewsletter',
            'Spatie\Newsletter\NewsletterFacade'
        );

        // Spatie Newsletter facade
        AliasLoader::getInstance()->alias(
            'Excel',
            'Maatwebsite\Excel\Facades\Excel'
        );

        // Observers
        Newsletter::observe(new FileObserver());
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Subscribe to events class
         */
        $app->events->subscribe(new EventHandler());

        /*
         * Register route service provider
         */
        $app->register('TypiCMS\Modules\Newsletter\Custom\Providers\RouteServiceProvider');

        /*
         * Register Honeypot
         */
        $app->register('Msurguy\Honeypot\HoneypotServiceProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Newsletter\Custom\Composers\SidebarViewComposer');

        /*
         * Add the page in the view.
         */
        $app->view->composer('newsletter::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('newsletter');
        });

        $app->bind('TypiCMS\Modules\Newsletter\Custom\Repositories\NewsletterInterface', function (Application $app) {
            $repository = new EloquentNewsletter(new Newsletter());
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'newsletter', 10);

            return new CacheDecorator($repository, $laravelCache);
        });
    }
}
