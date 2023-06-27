<?php

declare(strict_types=1);

namespace Tests\Feature\Models;

use App\Models\Book;
use App\Models\BookAuthor;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class BookAuthorTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testBookAuthorHasBooks(): void
    {
        $author = BookAuthor::factory()->create();

        Book::factory()->count(2)->create(['book_author_id' => $author->id]);

        $this->assertCount(2, $author->books);
    }
}
