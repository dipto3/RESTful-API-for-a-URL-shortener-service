<?php

namespace App\Observers;

use App\Models\Url;
use Illuminate\Support\Facades\Cache;

class UrlObserver
{
    /**
     * Handle the Url "created" event.
     */
    public function created(Url $url): void
    {
        Cache::forget('urls');
    }

    /**
     * Handle the Url "updated" event.
     */
}
