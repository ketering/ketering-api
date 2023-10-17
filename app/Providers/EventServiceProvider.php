<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\DarkModeWasToggled;
use JeroenNoten\LaravelAdminLte\Events\ReadingDarkModePreference;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        // Register listener for ReadingDarkModePreference event. We use this event to setup dark mode initial status for AdminLTE package.
        Event::listen(
            ReadingDarkModePreference::class,
            [$this, 'handleReadingDarkModeEvt']
        );

        // Register listener for DarkModeWasToggled AdminLTE event.
        Event::listen(
            DarkModeWasToggled::class,
            [$this, 'handleDarkModeWasToggledEvt']
        );
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }

    /**
     * Handle the ReadingDarkModePreference AdminLTE event.
     *
     * @param ReadingDarkModePreference $event
     * @return void
     */
    public function handleReadingDarkModeEvt(ReadingDarkModePreference $event): void
    {
        $darkModeCfg = \Auth::user()->dark_mode;

        // Setup initial dark mode preference.
        if ($darkModeCfg) {
            $event->darkMode->enable();
        } else {
            $event->darkMode->disable();
        }
    }

    /**
     * Handle the DarkModeWasToggled AdminLTE event.
     *
     * @param DarkModeWasToggled $event
     * @return void
     */
    public function handleDarkModeWasToggledEvt(DarkModeWasToggled $event): void
    {
        $darkModeCfg = $event->darkMode->isEnabled();

        $user = \Auth::user();
        $user->dark_mode = $darkModeCfg;
        $user->save();
    }
}
