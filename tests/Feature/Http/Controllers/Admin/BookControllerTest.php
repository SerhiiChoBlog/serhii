<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const BOOKS_URI = '/admin/ajax/books';
    private const BOOK_UPDATE_URI = '/admin/ajax/books/%s/update';
    private const BOOK_EDIT_URI = '/admin/ajax/books/%s/edit';

    private User $admin;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
    }

    public function testWeCanGetCorrectResponseFromBooks(): void
    {
        $this->actingAs($this->admin, 'admin')
            ->get(self::BOOKS_URI)
            ->assertOk();
    }

    public function testWeGetCorrectPaginatedBooks(): void
    {
        Book::factory()->count(2)->create();

        $response = $this->actingAs($this->admin, 'admin')
            ->get(self::BOOKS_URI);

        $response->assertJsonCount(2, 'data');
    }

    public function testWeCanUpdateBookTitle(): void
    {
        $book = Book::factory()->create();

        $uri = sprintf(self::BOOK_UPDATE_URI, $book->slug);

        $this->actingAs($this->admin, 'admin')
            ->put($uri, ['title' => 'New Title'])
            ->assertOk();

        $this->assertDatabaseHas('books', [
            'title' => 'New Title',
        ]);
    }

    public function testCannotUpdateBookWithShortTitle(): void
    {
        $book = Book::factory()->create();

        $uri = sprintf(self::BOOK_UPDATE_URI, $book->slug);

        $this->actingAs($this->admin, 'admin')
            ->put($uri, ['title' => 'New'])
            ->assertSessionHasErrors('title');
    }

    public function testCannotUpdateBookWithLongTitle(): void
    {
        $book = Book::factory()->create();

        $uri = sprintf(self::BOOK_UPDATE_URI, $book->slug);

        $this->actingAs($this->admin, 'admin')
            ->put($uri, ['title' => str_repeat('a', 256)])
            ->assertSessionHasErrors('title');
    }

    public function testWeCanGetSingleBookForEditing(): void
    {
        $book = Book::factory()->create();

        $uri = sprintf(self::BOOK_EDIT_URI, $book->slug);

        $response = $this->actingAs($this->admin, 'admin')->get($uri);

        $response->assertOk();

        $response->assertJsonFragment([
            'title' => $book->title,
            'slug' => $book->slug,
        ]);
    }
}
