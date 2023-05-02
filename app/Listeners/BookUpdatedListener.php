<?php

namespace App\Listeners;

use App\Events\BookUpdated;
use App\Models\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class BookUpdatedListener implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     *
     * @param  BookUpdated  $event
     * @return void
     */
    public function handle(BookUpdated $event)
    {
        $log = new Log();
        $log->action = 'book_updated';
        $log->data = $event->book->toJson();
        $log->save();
    }
}
