<?php

declare(strict_types=1);

namespace Tests\Feature\Commands;

use App\Console\Commands\DetectRobotsVisitors;
use App\Models\Visitor;
use Illuminate\Console\Command;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class DetectRobotsVisitorsTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function testRunningCommandMarksVisitorsAsRobots(): void
    {
        $people = Visitor::factory()->count(3)->create();

        $visitor1 = Visitor::factory()->create(['ip' => '64.233.160.0']);
        $visitor2 = Visitor::factory()->create(['ip' => '64.233.160.1']);

        $this->artisan(DetectRobotsVisitors::class)
            ->expectsOutput('Robots: 2')
            ->assertExitCode(Command::SUCCESS);

        $this->assertTrue($visitor1->fresh()?->is_robot);
        $this->assertTrue($visitor2->fresh()?->is_robot);

        $people->each(function ($person) {
            $this->assertFalse($person->fresh()?->is_robot);
        });
    }
}
