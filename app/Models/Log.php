<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $fillable = [
        'message'
    ];

    protected $casts = [
        'created_at'
    ];

    public static function logBookUpdate(Book $book)
    {
        $log = new static;
        $log->message = " '{$book->title}' book updated on ". now()->toDateString();
        $log->save();
    }
}
