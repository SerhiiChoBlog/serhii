<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\Book;
use App\Models\BookAuthor;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class BookTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testBookBelongsToAuthor(): void
    {
        $author = BookAuthor::factory()->create();

        $book = Book::factory()->create(['book_author_id' => $author->id]);

        $this->assertInstanceOf(BookAuthor::class, $book->author);
    }

    public function testPrettyReadAtDynamicProperty(): void
    {
        $book = Book::factory()->create([
            'book_author_id' => BookAuthor::factory(),
            'read_at' => now()->subHour(),
        ]);

        $this->assertSame('1 hour ago', $book->pretty_read_at);
    }
}
