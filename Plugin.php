<?php namespace Codecycler\Passport;

use App;
use Event;
use Config;
use Laravel\Passport\Passport;
use System\Classes\PluginBase;
use RainLab\User\Models\UserGroup;
use RainLab\User\Classes\AuthManager;
use Codecycler\Passport\Classes\Authenticate;
use Backend\Classes\AuthManager as BackendAuth;
use Laravel\Passport\Http\Middleware\CheckScopes;
use Codecycler\Passport\Classes\Extend\RainLab\User\User;

/**
 * Passport Plugin Information File
 */
class Plugin extends PluginBase
{
    public $middlewareAliases = [
        'auth' => Authenticate::class,
        'scopes' => CheckScopes::class,
    ];

    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'Passport',
            'description' => 'No description provided yet...',
            'author'      => 'Codecycler',
            'icon'        => 'icon-leaf'
        ];
    }

    public function register()
    {
    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {
        if(App::runningInBackend()) {
            // Register backend auth if not already
            $authManager = BackendAuth::instance();
        } else {
            // Register frontend auth
            $authManager = AuthManager::instance();
        }

        $this->app->bind('Illuminate\Contracts\Auth\Factory', function () use ($authManager) {
            return $authManager;
        });

        $this->registerConfig();
        $this->registerProviders();
        $this->registerAliases();
        $this->registerMiddleware();

        //
        Passport::ignoreMigrations();

        //
        $scopes = [];

        $groups = UserGroup::all();

        foreach ($groups as $group) {
            $scopes['group-' . $group->code] = 'Group' . $group->name;
        }

        //
        Passport::tokensCan($scopes);

        //
        Event::subscribe(User::class);
    }

    protected function registerProviders()
    {
        App::register('\Laravel\Passport\PassportServiceProvider');
        App::register('\Illuminate\Auth\AuthServiceProvider');
    }

    public function registerAliases()
    {
        //App::registerClassAlias('Passport', '\Laravel\Passport\Passport');
    }

    protected function registerConfig()
    {
        Config::set('auth', Config::get('codecycler.passport::auth'));
        Config::set('laravel-passport', Config::get('codecycler.passport::passport'));
    }

    protected function registerMiddleware()
    {
        $router = $this->app['router'];

        $method = method_exists($router, 'aliasMiddleware') ? 'aliasMiddleware' : 'middleware';

        foreach ($this->middlewareAliases as $alias => $middleware) {
            $router->$method($alias, $middleware);
        }
    }
}
