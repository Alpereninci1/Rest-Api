<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory;
    protected $fillable = [
      'name',
      'email'
    ];

    public function books()
    {
        return $this->hasMany(Book::class);
    }

    protected $cacheTags = ['authors'];
    public function getCacheKey()
    {
        return 'authors.' . $this->id;
    }
}
