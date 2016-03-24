<?php

namespace TypiCMS\Modules\Newsletter\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Newsletter\Events\EventHandler;
use TypiCMS\Modules\Newsletter\Models\Newsletter;
use TypiCMS\Modules\Newsletter\Repositories\CacheDecorator;
use TypiCMS\Modules\Newsletter\Repositories\EloquentNewsletter;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\FileObserver;
use TypiCMS\Modules\Core\Services\Cache\LaravelCache;

class ModuleProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/config.php', 'typicms.newsletter'
        );

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['newsletter' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(__DIR__.'/../resources/views/', 'newsletter');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'newsletter');

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
        $app->register('TypiCMS\Modules\Newsletter\Providers\RouteServiceProvider');

        /*
         * Register Honeypot
         */
        $app->register('Msurguy\Honeypot\HoneypotServiceProvider');

        /*
         * Sidebar view composer
         */
        $app->view->composer('core::admin._sidebar', 'TypiCMS\Modules\Newsletter\Composers\SidebarViewComposer');

        /*
         * Add the page in the view.
         */
        $app->view->composer('newsletter::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('newsletter');
        });

        $app->bind('TypiCMS\Modules\Newsletter\Repositories\NewsletterInterface', function (Application $app) {
            $repository = new EloquentNewsletter(new Newsletter());
            if (!config('typicms.cache')) {
                return $repository;
            }
            $laravelCache = new LaravelCache($app['cache'], 'newsletter', 10);

            return new CacheDecorator($repository, $laravelCache);
        });
    }
}
