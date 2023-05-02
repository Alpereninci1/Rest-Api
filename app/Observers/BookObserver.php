<?php

namespace App\Observers;

use App\Models\Book;
use App\Models\Log;

class BookObserver
{
    public function updated(Book $book)
    {
        $log = new Log();
        $log->message = " '{$book->title}' book updated.";
        $log->save();
    }
}
