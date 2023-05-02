<?php


namespace App\Listeners;

use App\Events\BookUpdated;
use App\Models\Log;
use Illuminate\Contracts\Queue\ShouldQueue;

class LogBookUpdate implements ShouldQueue
{
    public function handle(BookUpdated $event)
    {
        Log::logBookUpdate($event->book);
    }
}

