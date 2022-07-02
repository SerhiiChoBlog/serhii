<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Referrer;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class ReferrerIncrementTest extends TestCase
{
    use LazilyRefreshDatabase;

    private Referrer $referrer;

    public function setUp(): void
    {
        parent::setUp();
        $this->referrer = Referrer::factory()->create();
    }

    public function test_referrer_has_zero_hits_by_default(): void
    {
        $this->assertSame(0, $this->referrer->hits);
    }

    public function test_database_has_only_one_referrer(): void
    {
        $this->assertSame(1, Referrer::query()->count());
    }

    public function test_referrer_increments_hits_after_correct_request(): void
    {
        $this->get("/?welcome={$this->referrer->hash}")->assertOk();
        $this->assertEquals(1, $this->referrer->fresh()->hits);
    }

    public function test_if_hash_is_not_in_database_doesnt_do_anything(): void
    {
        $this->get("/?welcome=jiosafjosdifj")->assertOk();

        $this->assertSame(1, Referrer::query()->count());
        $this->assertEquals(0, $this->referrer->fresh()->hits);
    }
}
