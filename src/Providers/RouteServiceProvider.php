<?php

namespace TypiCMS\Modules\Newsletter\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use TypiCMS\Modules\Core\Facades\TypiCMS;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'TypiCMS\Modules\Newsletter\Http\Controllers';

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
            $router->get('admin/newsletter', ['as' => 'admin.newsletter.index', 'uses' => 'AdminController@index']);
            $router->get('admin/newsletter/create', ['as' => 'admin.newsletter.create', 'uses' => 'AdminController@create']);
            $router->get('admin/newsletter/export', ['as' => 'admin.newsletter.export', 'uses' => 'AdminController@export']);
            $router->get('admin/newsletter/{newsletter}/edit', ['as' => 'admin.newsletter.edit', 'uses' => 'AdminController@edit']);
            $router->post('admin/newsletter', ['as' => 'admin.newsletter.store', 'uses' => 'AdminController@store']);
            $router->put('admin/newsletter/{newsletter}', ['as' => 'admin.newsletter.update', 'uses' => 'AdminController@update']);

            /*
             * API routes
             */
            $router->get('api/newsletter', ['as' => 'api.newsletter.index', 'uses' => 'ApiController@index']);
            $router->put('api/newsletter/{newsletter}', ['as' => 'api.newsletter.update', 'uses' => 'ApiController@update']);
            $router->delete('api/newsletter/{newsletter}', ['as' => 'api.newsletter.destroy', 'uses' => 'ApiController@destroy']);
        });
    }
}
