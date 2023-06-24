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

    private User $admin;

    public function setUp(): void
    {
        parent::setUp();
        $this->admin = $this->createAdmin();
    }

    public function testWeCanGetCorrectResponseFromBooks(): void
    {
        $this->actingAs($this->admin, 'admin')
            ->get(route('admin.books.index'))
            ->assertOk();
    }

    public function testWeGetCorrectPaginatedBooks(): void
    {
        Book::factory()->count(2)->create();

        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.books.index'));

        $response->assertJsonCount(2, 'data');
    }
}
