<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\SomeEvent' => [
            'App\Listeners\EventListener',
        ],
        'App\Events\PostEvent' => [
            'App\Listeners\ViewPostHandler',
        ],
        'App\Events\NotifyPost' => [
            'App\Listeners\NotifyPostListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        Event::listen('posts.view', 'App\Listeners\ViewPostHandler');
        Event::listen('posts.notify', 'App\Listeners\NotifyPostListener');
    }
}
