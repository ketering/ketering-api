<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

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
        //
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add(
                [
                    'icon' => 'fas fa-chart-area',
                    'text' => 'Dashboard',
                    'url' => '/home'
                ]
            );
            $event->menu->add(['header' => 'USER MANAGEMENT', 'classes' => 'font-weight-bold']);

            $event->menu->add(
                [
                    'icon' => 'fas fa-users',
                    'url' => '#',
                    'text' => 'Users',
                    'id' => 'users',
                    'key' => 'users',
                    'active' => ['users*']
                ],
            );
            $event->menu->addIn('users',
                [
                    'icon' => 'fas fa-table',
                    'text' => 'View All',
                    'url' => '/users'
                ]
            );
            $event->menu->addIn('users',
                [
                    'icon' => 'fas fa-plus',
                    'text' => 'New User',
                    'url' => '/users/create'
                ]
            );

            $event->menu->add(['header' => 'MEAL MANAGEMENT', 'classes' => 'font-weight-bold']);

            $event->menu->add(
                [
                    'icon' => 'fas fa-hamburger',
                    'url' => '#',
                    'text' => 'Meals',
                    'id' => 'meals',
                    'key' => 'meals',
                    'active' => ['meals*']
                ],
            );
            $event->menu->addIn('meals',
                [
                    'icon' => 'fas fa-table',
                    'text' => 'View All',
                    'url' => '/meals'
                ]
            );
            $event->menu->addIn('meals',
                [
                    'icon' => 'fas fa-plus',
                    'text' => 'New Meal',
                    'url' => '/meals/create'
                ]
            );

            $event->menu->add(
                [
                    'icon' => 'fas fa-folder',
                    'url' => '#',
                    'text' => 'Categories',
                    'id' => 'categories',
                    'key' => 'categories',
                    'active' => ['categories*']
                ],
            );
            $event->menu->addIn('categories',
                [
                    'icon' => 'fas fa-table',
                    'text' => 'View All',
                    'url' => '/categories'
                ]
            );
            $event->menu->addIn('categories',
                [
                    'icon' => 'fas fa-plus',
                    'text' => 'New Category',
                    'url' => '/categories/create'
                ]
            );

            $event->menu->add(
                [
                    'icon' => 'fas fa-folder',
                    'url' => '#',
                    'text' => 'Types',
                    'id' => 'types',
                    'key' => 'types',
                    'active' => ['types*']
                ],
            );
            $event->menu->addIn('types',
                [
                    'icon' => 'fas fa-table',
                    'text' => 'View All',
                    'url' => '/types'
                ]
            );
            $event->menu->addIn('types',
                [
                    'icon' => 'fas fa-plus',
                    'text' => 'New Type',
                    'url' => '/types/create'
                ]
            );

            $event->menu->add(['header' => 'ORDER MANAGEMENT', 'classes' => 'font-weight-bold']);

            $event->menu->add(
                [
                    'icon' => 'fas fa-signal',
                    'url' => '#',
                    'text' => 'Statuses',
                    'id' => 'statuses',
                    'key' => 'statuses',
                    'active' => ['statuses*']
                ],
            );
            $event->menu->addIn('statuses',
                [
                    'icon' => 'fas fa-table',
                    'text' => 'View All',
                    'url' => '/statuses'
                ]
            );
            $event->menu->addIn('statuses',
                [
                    'icon' => 'fas fa-plus',
                    'text' => 'New Status',
                    'url' => '/statuses/create'
                ]
            );

        });
    }
}
