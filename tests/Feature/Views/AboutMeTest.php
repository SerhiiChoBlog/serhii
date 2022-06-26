<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class AboutMeTest extends TestCase
{
    use LazilyRefreshDatabase;

    /** @test */
    public function guest_can_visit_about_me_page(): void
    {
        $this->get(route('about-me'))->assertOk()->assertViewIs('about-me');
    }

    /** @test */
    public function admin_can_visit_about_me_page(): void
    {
        $user = User::factory()->make();

        $this->actingAs($user)
            ->get(route('about-me'))
            ->assertOk()
            ->assertViewIs('about-me');
    }

    /** @test */
    public function about_page_redirects_to_about_me(): void
    {
        $this->get('/about')->assertRedirect(route('about-me'));
    }
}
