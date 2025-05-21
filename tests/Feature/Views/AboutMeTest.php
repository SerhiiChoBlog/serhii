<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AboutMeTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testGuestCanVisitPage(): void
    {
        $this->get(route('about-me'))->assertOk()->assertViewIs('about-me');
    }

    public function testAdminCanVisitPage(): void
    {
        /** @var User $user */
        $user = User::factory()->make();

        $this->actingAs($user, 'admin')
            ->get(route('about-me'))
            ->assertOk()
            ->assertViewIs('about-me');
    }

    public function testAboutPageRedirectsToAboutMe(): void
    {
        $this->get('/about')->assertRedirect(route('about-me'));
    }
}
