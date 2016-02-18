<?php

namespace App\Providers;

use App\Helpers\Menu\BaseMenu;
use Illuminate\Support\ServiceProvider;
use App\Helpers\Menu\MenuBuilder;
use Illuminate\Routing\Router;
use UnexpectedValueException;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $menu = MenuBuilder::getInstance();

        require app_path('Http/menus.php');

        $this->map($menu, app(Router::class));
    }

    public function map(MenuBuilder $builder, Router $router) {

        foreach ($builder->get() as $menu) {

            if ($menu->hasSubmenus()) {
                $this->map($menu->getSubmenuBuilder(), $router);
                continue;
            } else if (!$menu instanceof BaseMenu) {
                throw new UnexpectedValueException("Expect menu to be an instanceof BaseMenu.");
            }

            $router->group(['namespace' => $menu->getNamespace()], function ($router) use ($menu) {
                $menu->registerRoutes($router);
            });
        }

    }

}
