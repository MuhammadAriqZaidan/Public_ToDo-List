<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        // Example:
        // Registered::class => [
        //     SendEmailVerificationNotification::class,
        // ],
    ];

    public function boot(): void
    {
        //
    }
}
