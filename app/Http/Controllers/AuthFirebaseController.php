<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\FirebaseSignInRequest;
use App\Models\Subscription;
use App\Models\User;
use App\Services\GenerateSlugService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AuthFirebaseController extends Controller
{
    public function signIn(FirebaseSignInRequest $request): User | string
    {
        /** @var User|null $user */
        $user = User::query()
            ->where('email', $request->email)
            ->first();

        if ($user) {
            $avatar = $this->updateUserImage($user, $request->photo_url);

            $user->update([
                'name' => $request->name,
                'avatar' => $avatar,
            ]);
        } else {
            $user = $this->createUser($request);
        }

        if ($this->userHasSubscription($request->email)) {
            $this->updateSubscription($request->email, $user->id);
        }

        auth('user')->login($user);

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

    /**
     * @return string|null
     */
    private function saveUserImage(?string $image_url, string $slug): ?string
    {
        if (!$image_url) {
            return null;
        }

        $image_url = str_replace('s96-c', 's400-c', $image_url);

        $name = sprintf("%s-%s.jpg", $slug, time());
        $image_binary = file_get_contents($image_url);

        if (!$image_binary || !is_string($image_binary)) {
            return null;
        }

        Storage::disk('public')->put("avatars/{$name}", $image_binary);

        return $name;
    }

    private function updateUserImage(User $user, ?string $new_image): string
    {
        if (!$new_image) {
            return $user->avatar;
        }

        $full_path = storage_path("app/public/avatars/{$user->avatar}");

        if (file_exists($full_path)) {
            unlink($full_path);
        }

        return $this->saveUserImage($new_image, $user->slug) ?? $user->avatar;
    }

    private function userHasSubscription(string $email): bool
    {
        return Subscription::query()
            ->select('id', 'email')
            ->where('email', $email)
            ->exists();
    }

    private function updateSubscription(string $email, int $user_id): void
    {
        Subscription::query()
            ->select('id', 'email')
            ->where('email', $email)
            ->update(compact('user_id'));
    }
}
