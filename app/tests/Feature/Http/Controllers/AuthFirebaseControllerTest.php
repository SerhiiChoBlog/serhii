<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class AuthFirebaseControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
        Storage::fake('public');
    }

    public function testRequestCreatesUserIfEmailIsNotFound(): void
    {
        $params = [
            'name' => 'John Doe',
            'email' => 'sam@gmail.com',
            'sign_in_method' => 'google',
            'photo_url' => 'https://lh3.googl/photo.jpg',
        ];

        Http::fake([$params['photo_url'] => Http::response('xxxxxxxxx')]);

        $this->postJson('/firebase-sign-in', $params);

        Event::assertDispatched(Verified::class);

        Auth::shouldReceive('login', User::query()->first());

        $this->assertDatabaseHas('users', [
            'name' => $params['name'],
            'email' => $params['email'],
            'sign_in_method' => 'google',
        ]);
    }

    public function testRequestDoesntCreateUserIfEmailFound(): void
    {
        $user = $this->createUser();

        $params = [
            'name' => $user->name,
            'email' => $user->email,
            'sign_in_method' => 'github',
            'photo_url' => 'https://lh3.googl/photo.png',
        ];

        Http::fake([$params['photo_url'] => Http::response('xxxxxxxxx')]);

        Auth::shouldReceive('login')->withArgs([$user]);

        $this->postJson('/firebase-sign-in', $params);

        Event::assertNotDispatched(Verified::class);
    }
}
