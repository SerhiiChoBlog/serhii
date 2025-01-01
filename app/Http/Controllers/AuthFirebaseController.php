<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\UserRole;
use App\Http\Requests\FirebaseSignInRequest;
use App\Models\User;
use App\Services\GenerateSlugService;
use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthFirebaseController extends Controller
{
    public function signIn(FirebaseSignInRequest $request): User|string
    {
        /** @var User|null $user */
        $user = User::query()
            ->where('email', $request->email)
            ->first();

        if (!$user) {
            $user = $this->createUser($request);
            event(new Verified($user));
        }

        $is_admin = $user->hasRole(UserRole::ADMIN);

        auth($is_admin ? 'admin' : 'user')->login($user, true);

        return $user;
    }

    private function createUser(FirebaseSignInRequest $request): User
    {
        $slug = $this->generateSlug($request->name);
        $avatar = $this->saveUserImage($request->photo_url, $slug);

        /** @var User */
        return User::query()->create([
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make(Str::random(20)),
            'secret' => User::generateSecret($request->email),
            'email_verified_at' => now(),
            'slug' => $slug,
            'avatar' => $avatar,
            'sign_in_method' => $request->sign_in_method,
        ]);
    }

    private function generateSlug(string $name): string
    {
        $slug_service = new GenerateSlugService($name);
        return $slug_service->handle();
    }

    private function saveUserImage(string|null $image_url, string $slug): string|null
    {
        if (!$image_url) {
            return null;
        }

        $image_url = str_replace('s96-c', 's400-c', $image_url);

        $name = sprintf("%s-%s.jpg", $slug, time());

        $image_binary = Http::get($image_url)->body();

        if (!$image_binary || !is_string($image_binary)) {
            return null;
        }

        Storage::disk('public')->put("avatars/{$name}", $image_binary);

        return $name;
    }
}
