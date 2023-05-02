<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Author;
use App\Models\Book;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $authors = Author::factory() // authors create
            ->count(5)
            ->create();

        foreach ($authors as $author) // books create for author.
        {
            Book::factory()
                ->count(rand(2, 5))
                ->create([
                    'author_id' => $author->id,
                ]);
        }
    }
}
