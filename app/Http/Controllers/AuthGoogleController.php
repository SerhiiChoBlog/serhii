<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\SignInMethod;
use App\Http\Requests\GoogleSignInRequest;
use App\Models\User;
use App\Services\GenerateSlugService;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use JsonException;

class AuthGoogleController extends Controller
{
    private const USER_INFO_URL = 'https://www.googleapis.com/oauth2/v1/userinfo?access_token={token}';

    /**
     * @throws JsonException
     */
    public function signIn(GoogleSignInRequest $request): User | string
    {
        try {
            $user_info = $this->getUserInfo($request->access_token);
        } catch (RequestException $e) {
            Log::error($e->getMessage());
            return trans('common.google_service_error');
        }

        $email = $user_info['email'];
        $name = $user_info['name'];

        if (!$email || !$name) {
            Log::error(json_encode($user_info, JSON_THROW_ON_ERROR));
            return trans('common.google_service_error');
        }

        /** @var User|null $user */
        $user = User::query()->where('email', $email)->first();

        if ($user) {
            $avatar = $this->updateUserImage($user, $user_info['picture']);

            $user->update(compact('name', 'avatar'));

            auth('user')->login($user);

            return $user;
        }

        $slug = $this->generateSlug($name);
        $avatar = $this->saveUserImage($user_info['picture'], $slug);

        /** @var User $user */
        $user = User::query()->create([
            'email' => $email,
            'name' => $name,
            'password' => Hash::make(Str::random(20)),
            'secret' => User::generateSecret($email),
            'email_verified_at' => now(),
            'slug' => $slug,
            'avatar' => $avatar,
            'sign_in_method' => SignInMethod::GOOGLE->value,
        ]);

        auth('user')->login($user);

        return $user;
    }

    protected function generateSlug(string $name): string
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

    /**
     * @param string $access_token
     *
     * @return array{
     *     id: string,
     *     email: string,
     *     name: string,
     *     picture: string|null,
     * }
     * @throws RequestException
     */
    private function getUserInfo(string $access_token): array
    {
        $url = str_replace('{token}', $access_token, self::USER_INFO_URL);
        return Http::get($url)->throw()->json();
    }
}
