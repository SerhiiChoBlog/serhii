<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Admin;

use App\Models\BookAuthor;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class BookAuthorControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const SEARCH_URI = '/admin/ajax/book-authors/search/';
    private const STORE_URI = '/admin/ajax/book-authors';

    private User $admin;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
    }

    public function testCanSearchBookAuthor(): void
    {
        $anna_author = BookAuthor::factory()->create(['name' => 'Anna Love']);
        BookAuthor::factory()->create(['name' => 'Serhii Cho']);

        $resp = $this->actingAs($this->admin, 'admin')
            ->getJson(self::SEARCH_URI . 'ann')
            ->assertOk();

        $resp->assertJson([[
            'id' => $anna_author->id,
            'name' => $anna_author->name,
        ]]);
    }

    public function testSearchingBookAuthorReturnsMultipleAuthors(): void
    {
        $serhii = BookAuthor::factory()->create(['name' => 'Serhii Cho']);
        $anna = BookAuthor::factory()->create(['name' => 'Anna Cho']);

        $resp = $this->actingAs($this->admin, 'admin')
            ->getJson(self::SEARCH_URI . 'cho')
            ->assertOk();

        $resp->assertJson([
            [
                'id' => $serhii->id,
                'name' => $serhii->name,
            ],
            [
                'id' => $anna->id,
                'name' => $anna->name,
            ],
        ]);
    }

    public function testCreatesAuthorWhenItDoesntAlreadyExist(): void
    {
        $this->actingAs($this->admin, 'admin')
            ->postJson(self::STORE_URI, ['name' => 'Anna Serhii'])
            ->assertCreated();

        $this->assertDatabaseHas('book_authors', ['name' => 'Anna Serhii']);
    }

    public function testDoesntCreateAuthorWhenAlreadyExist(): void
    {
        BookAuthor::factory()->create(['name' => 'Anna Serhii']);

        $this->actingAs($this->admin, 'admin')
            ->postJson(self::STORE_URI, ['name' => 'Anna Serhii'])
            ->assertOk();

        $this->assertDatabaseCount('book_authors', 1);
        $this->assertDatabaseHas('book_authors', ['name' => 'Anna Serhii']);
    }
}
