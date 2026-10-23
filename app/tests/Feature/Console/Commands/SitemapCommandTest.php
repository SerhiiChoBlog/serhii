<?php

declare(strict_types=1);

namespace Tests\Feature\Console\Commands;

use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SitemapCommandTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testSitemapIsWrittenToPublicStorage(): void
    {
        Storage::fake('public');

        /** @var FilesystemAdapter $disk */
        $disk = Storage::disk('public');

        $this->artisan('make:sitemap')->assertSuccessful();

        $disk->assertExists('sitemap.xml');
    }

    public function testSitemapIsServedFromPublicStorage(): void
    {
        Storage::fake('public');

        Storage::disk('public')->put('sitemap.xml', '<?xml version="1.0"?><urlset></urlset>');

        $this->get('/sitemap.xml')
            ->assertOk()
            ->assertHeader('Content-Type', 'application/xml')
            ->assertSee('<urlset></urlset>', false);
    }

    public function testMissingSitemapReturnsNotFound(): void
    {
        Storage::fake('public');

        $this->get('/sitemap.xml')->assertNotFound();
    }
}
