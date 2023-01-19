<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AboutMeTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function test_guest_can_visit_page(): void
    {
        $this->get(route('about-me'))->assertOk()->assertViewIs('about-me');
    }

    public function test_admin_can_visit_page(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user)
            ->get(route('about-me'))
            ->assertOk()
            ->assertViewIs('about-me');
    }

    public function test_about_page_redirects_to_about_me(): void
    {
        $this->get('/about')->assertRedirect(route('about-me'));
    }
}
