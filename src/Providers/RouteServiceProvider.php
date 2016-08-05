<?php

namespace TypiCMS\Modules\Newsletter\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use TypiCMS\Modules\Core\Custom\Facades\TypiCMS;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Newsletter\Custom\Http\Controllers';

    /**
     * Define the routes for the application.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function (Router $router) {

            /*
             * Front office routes
             */
            if ($page = TypiCMS::getPageLinkedToModule('newsletter')) {
                $options = $page->private ? ['middleware' => 'auth'] : [];
                foreach (config('translatable.locales') as $lang) {
                    if ($uri = $page->uri($lang)) {
                        $router->get($uri, $options + ['as' => $lang.'.newsletter', 'uses' => 'PublicController@form']);
                        $router->get($uri.'/sent', $options + ['as' => $lang.'.newsletter.sent', 'uses' => 'PublicController@sent']);
                        $router->post($uri, $options + ['as' => $lang.'.newsletter.store', 'uses' => 'PublicController@store']);
                    }
                }
            }

            /*
             * Admin routes
             */
            $router->get('admin/newsletter', 'AdminController@index')->name('admin::index-newsletter');
            $router->get('admin/newsletter/create', 'AdminController@create')->name('admin::create-newsletter');
            $router->get('admin/newsletter/export', 'AdminController@export')->name('admin::export-newsletter');
            $router->get('admin/newsletter/{newsletter}/edit', 'AdminController@edit')->name('admin::edit-newsletter');
            $router->post('admin/newsletter', 'AdminController@store')->name('admin::store-newsletter');
            $router->put('admin/newsletter/{newsletter}', 'AdminController@update')->name('admin::update-newsletter');

            /*
             * API routes
             */
            $router->get('api/newsletter', 'ApiController@index')->name('api::index-newsletter');
            $router->put('api/newsletter/{newsletter}', 'ApiController@update')->name('api::update-newsletter');
            $router->delete('api/newsletter/{newsletter}', 'ApiController@destroy')->name('api::destroy-newsletter');
        });
    }
}
