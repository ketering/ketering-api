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

        });
    }
}
