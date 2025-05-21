<?php

declare(strict_types=1);

namespace Tests\Feature\Views;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        Storage::fake('public');
        Http::fake();
        Notification::fake();
    }

    public function testGuestCanVisitPage(): void
    {
        $this->get(route('register'))
            ->assertOk()
            ->assertViewIs('auth.register');
    }

    public function testAdminCannotVisitPageIfAuthenticated(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin')
            ->get(route('register'))
            ->assertRedirect('/');
    }

    public function testUserCannotVisitPageIfAuthenticated(): void
    {
        /** @var User $user */
        $user = User::factory()->make();

        $this->actingAs($user, 'user')
            ->get(route('register'))
            ->assertRedirect('/');
    }

    public function testUserCanRegisterAndSeeProfilePage(): void
    {
        $form_data = [
            'name' => 'Anna Korotchaeva',
            'email' => 'anna.korotchaeva@protonmail.com',
            'password' => 'anna-korotchaeva-123',
        ];

        $this->post(route('register'), $form_data)
            ->assertRedirect(RouteServiceProvider::USER_HOME);

        $this->assertDatabaseHas('users', [
            'name' => $form_data['name'],
            'email' => $form_data['email'],
        ]);
    }

    public function testPasswordIsHashedCorrectly(): void
    {
        $form_data = [
            'name' => 'Anna Beauty',
            'email' => 'anna.beauty@mail.com',
            'password' => 'anna-beauty-password',
        ];

        $this->post(route('register'), $form_data);

        $pass = User::query()->first()?->password ?? '';

        $password_matches = Hash::check($form_data['password'], $pass);

        $this->assertTrue($password_matches);
    }

    public function testUserCannotRegisterWithIncorrectEmail(): void
    {
        $form_data = [
            'name' => 'Anna Korotchaeva',
            'email' => 'anna.korotchaeva.com',
            'password' => 'korotchaeva-password',
        ];

        $this->post(route('register'), $form_data)
            ->assertSessionHasErrors('email');
    }

    public function testUserCannotRegisterWithExistingEmail(): void
    {
        /** @var User $serhii */
        $serhii = $this->createUser();

        $form_data = [
            'name' => 'Anna Korotchaeva',
            'email' => $serhii->email,
            'password' => 'anna-korotchaeva-pwd',
        ];

        $this->post(route('register'), $form_data)
            ->assertSessionHasErrors('email');
    }

    public function testUserCannotRegisterWithShortPassword(): void
    {
        $form_data = [
            'name' => 'Anna Cho',
            'email' => 'anna.cho@gmail.com',
            'password' => '1234567',
        ];

        $this->post(route('register'), $form_data)
            ->assertSessionHasErrors('password');
    }

    public function testUserCannotRegisterWithShortName(): void
    {
        $form_data = [
            'name' => 'A',
            'email' => 'anna.cho@gmail.com',
            'password' => '1234567891011',
        ];

        $this->post(route('register'), $form_data)
            ->assertSessionHasErrors('name');
    }

    public function testUserCannotRegisterWithLongName(): void
    {
        $form_data = [
            'name' => 'Anna Korotchaeva is a beautiful and smart girl',
            'email' => 'anna.cho@gmail.com',
            'password' => '1234567891011',
        ];

        $this->post(route('register'), $form_data)
            ->assertSessionHasErrors('name');
    }

    public function testUserCannotRegisterWithEmptyName(): void
    {
        $form_data = [
            'name' => '',
            'email' => 'anna.cho@gmail.com',
            'password' => '1234567891011',
        ];

        $this->post(route('register'), $form_data)
            ->assertSessionHasErrors('name');
    }

    public function testUserCannotRegisterWithEmptyEmail(): void
    {
        $form_data = [
            'name' => 'Serhii Cho',
            'email' => '',
            'password' => 'some-password-is-here',
        ];

        $this->post(route('register'), $form_data)
            ->assertSessionHasErrors('email');
    }

    public function testUserHasSlugAfterRegistration(): void
    {
        $form_data = [
            'name' => 'Serhii Cho',
            'email' => 'serhiicho@mail.com',
            'password' => 'some-password-here',
        ];

        $this->post(route('register'), $form_data);

        /** @var User $user */
        $user = User::query()->first();

        $this->assertNotNull($user->slug);
    }
}
