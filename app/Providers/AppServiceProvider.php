<?php

namespace App\Providers;

use App\Models\Role;
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
                    'url' => '/'
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
            if (auth()->user()->role == Role::superadmin()) {
                $event->menu->addIn('users',
                    [
                        'icon' => 'fas fa-plus',
                        'text' => 'New User',
                        'url' => '/users/create'
                    ]
                );
            }

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
            if (auth()->user()->role == Role::superadmin()) {
                $event->menu->addIn('meals',
                    [
                        'icon' => 'fas fa-plus',
                        'text' => 'New Meal',
                        'url' => '/meals/create'
                    ]
                );
            }

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
            if (auth()->user()->role == Role::superadmin()) {
                $event->menu->addIn('categories',
                    [
                        'icon' => 'fas fa-plus',
                        'text' => 'New Category',
                        'url' => '/categories/create'
                    ]
                );
            }

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
            if (auth()->user()->role == Role::superadmin()) {
                $event->menu->addIn('types',
                    [
                        'icon' => 'fas fa-plus',
                        'text' => 'New Type',
                        'url' => '/types/create'
                    ]
                );
            }

            $event->menu->add(['header' => 'ORDER MANAGEMENT', 'classes' => 'font-weight-bold']);

            $event->menu->add(
                [
                    'icon' => 'fas fa-truck',
                    'url' => '#',
                    'text' => 'Orders',
                    'id' => 'orders',
                    'key' => 'orders',
                    'active' => ['orders*']
                ],
            );
            $event->menu->addIn('orders',
                [
                    'icon' => 'fas fa-table',
                    'text' => 'View All',
                    'url' => '/orders'
                ]
            );

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
            if (auth()->user()->role == Role::superadmin()) {
                $event->menu->addIn('statuses',
                    [
                        'icon' => 'fas fa-plus',
                        'text' => 'New Status',
                        'url' => '/statuses/create'
                    ]
                );
            }

            if (auth()->user()->role == Role::superadmin()) {
                $event->menu->add(['header' => 'INVOICE MANAGEMENT', 'classes' => 'font-weight-bold']);

                $event->menu->add(
                    [
                        'icon' => 'fas fa-receipt',
                        'url' => '#',
                        'text' => 'Fakture',
                        'id' => 'invoices',
                        'key' => 'invoices',
                        'active' => ['invoices*']
                    ],
                );
                $event->menu->addIn('invoices',
                    [
                        'icon' => 'fas fa-table',
                        'text' => 'Eksportuj',
                        'url' => '/invoices'
                    ]
                );
            }

        });
    }
}
