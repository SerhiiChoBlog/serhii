<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const BOOKS_URI = '/admin/ajax/books';
    private const BOOK_STORE_URI = '/admin/ajax/books';

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
        $author = BookAuthor::factory()->create();
        Book::factory()->count(2)->create(['book_author_id' => $author->id]);

        $response = $this->actingAs($this->admin, 'admin')
            ->get(self::BOOKS_URI);

        $response->assertJsonCount(2, 'data');
    }

    public function testWeCanCreateBook(): void
    {
        $author = BookAuthor::factory()->create();

        $attrs = [
            'title' => 'New Title',
            'book_author_id' => $author->id,
        ];

        $this->actingAs($this->admin, 'admin')
            ->post(self::BOOK_STORE_URI, $attrs)
            ->assertOk();

        $this->assertDatabaseHas('books', $attrs);
    }

    public function testBookAuthorIdIsRequiredWhenCreatingBook(): void
    {
        $attrs = [
            'title' => 'New Title',
        ];

        $this->actingAs($this->admin, 'admin')
            ->post(self::BOOK_STORE_URI, $attrs)
            ->assertSessionHasErrors('book_author_id');

        $this->assertDatabaseMissing('books', $attrs);
    }

    public function testTitleIsRequiredWhenCreatingBook(): void
    {
        $attrs = [
            'book_author_id' => BookAuthor::factory()->create()->id,
        ];

        $this->actingAs($this->admin, 'admin')
            ->post(self::BOOK_STORE_URI, $attrs)
            ->assertSessionHasErrors('title');

        $this->assertDatabaseMissing('books', $attrs);
    }

    public function testWeCanAttachImageWhenCreatingBook(): void
    {
        Storage::fake('public');

        $file = UploadedFile::fake()->image('image.jpg', 100, 200);

        $attrs = [
            'title' => 'New Title',
            'book_author_id' => BookAuthor::factory()->create()->id,
            'image' => $file,
        ];

        $this->actingAs($this->admin, 'admin')
            ->post(self::BOOK_STORE_URI, $attrs)
            ->assertOk();

        Storage::disk('public')->assertExists('books/new-title.jpg');
    }

    public function testYouCanRateBookWhileCreating(): void
    {
        $author = BookAuthor::factory()->create();

        $attrs = [
            'title' => 'New Title',
            'book_author_id' => $author->id,
            'rate' => 5,
        ];

        $this->actingAs($this->admin, 'admin')
            ->post(self::BOOK_STORE_URI, $attrs)
            ->assertOk();

        $this->assertDatabaseHas('books', $attrs);
    }
}
