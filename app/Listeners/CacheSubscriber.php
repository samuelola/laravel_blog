<?php

namespace App\Listeners;

use Illuminate\Cache\Events\CacheHit;
use Illuminate\Cache\Events\CacheMissed;
use Illuminate\Support\Facades\Log;

class CacheSubscriber
{
    /**
     * Handle the event.
     */
    public function handleCacheHit(CacheHit $event): void
    {
        //Log::info("{$event->key} cache hit");
    }

    public function handleCacheMissed(CacheMissed $event): void
    {
        //Log::info("{$event->key} cache miss");
    }

    public function subscriber($events)
    {
        $events->listen(
           CacheHit::class,
           'App\Listeners\CacheSubscriber@handleCacheHit'
        );

        $events->listen(
            CacheMissed::class,
            'App\Listeners\CacheSubscriber@handleCacheMissed'
        );
    }
}
