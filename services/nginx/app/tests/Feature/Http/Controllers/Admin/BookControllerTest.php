<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\Book;
use App\Models\BookAuthor;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class BookControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const BOOKS_URI = '/admin/ajax/books';
    private const BOOK_STORE_URI = '/admin/ajax/books';
    private const BOOK_UPDATE_FIELD = '/admin/ajax/books/%s/update-field';

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
        Book::factory(2)->withAuthor()->create();

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
            'read_at' => '2021-01-01',
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
            'read_at' => '2021-01-01',
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
            'read_at' => '2021-01-01',
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
            'read_at' => '2021-01-01',
        ];

        $this->actingAs($this->admin, 'admin')
            ->post(self::BOOK_STORE_URI, $attrs)
            ->assertOk();

        Storage::disk('public')->assertExists('books/new-title.jpg');
    }

    public function testBookCanBeCreatedWithRateValue(): void
    {
        $author = BookAuthor::factory()->create();

        $attrs = [
            'title' => 'New Title',
            'book_author_id' => $author->id,
            'rate' => 5,
            'read_at' => '2021-01-01',
        ];

        $this->actingAs($this->admin, 'admin')
            ->post(self::BOOK_STORE_URI, $attrs)
            ->assertOk();

        $this->assertDatabaseHas('books', $attrs);
    }

    public function testBookCanBeCreatedWithReadAtDate(): void
    {
        $author = BookAuthor::factory()->create();

        $attrs = [
            'title' => 'New Title',
            'book_author_id' => $author->id,
            'read_at' => '2021-01-01',
        ];

        $this->actingAs($this->admin, 'admin')
            ->post(self::BOOK_STORE_URI, $attrs)
            ->assertOk();

        $this->assertDatabaseHas('books', $attrs);
    }

    public function testBookCannotBeAddedWithoutReadAtValue(): void
    {
        $author = BookAuthor::factory()->create();

        $attrs = [
            'title' => 'New Title',
            'book_author_id' => $author->id,
        ];

        $this->actingAs($this->admin, 'admin')
            ->post(self::BOOK_STORE_URI, $attrs)
            ->assertSessionHasErrors('read_at');

        $this->assertDatabaseMissing('books', $attrs);
    }

    #[DataProvider('providerForWeCanUpdateBookFields')]
    public function testWeCanUpdateBookFields(string $field_name, string $field_value): void
    {
        /** @var Book $book */
        $book = Book::factory()->withAuthor()->create();

        $attrs = compact('field_name', 'field_value');

        $this->actingAs($this->admin, 'admin')
            ->putJson(sprintf(self::BOOK_UPDATE_FIELD, $book->slug), $attrs)
            ->assertOk();

        $this->assertDatabaseHas('books', [
            'id' => $book->id,
            $field_name => $attrs['field_value'],
        ]);
    }

    public static function providerForWeCanUpdateBookFields(): array
    {
        return [
            ['title', 'New Title is here'],
            ['rate', '2'],
            ['read_at', '2021-01-01'],
        ];
    }
}
