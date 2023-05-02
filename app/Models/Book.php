<?php

namespace App\Models;

use App\Events\BookUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'author_id'
    ];

    public function author()
    {
        return $this->belongsTo(Author::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::updated(function ($book) {
            event(new BookUpdated($book));
        });
    }
}
