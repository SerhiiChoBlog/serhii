<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

readonly class GenerateSlugService
{
    public function __construct(private string $name)
    {
    }

    public function handle(): string
    {
        $slug = Str::slug($this->name);

        if ($this->slugIsAvailable($slug)) {
            return $slug;
        }

        $user_slugs = User::query()
            ->where('slug', 'like', "{$slug}-%")
            ->pluck('slug')
            ->toArray();

        $suffix = 1;

        foreach ($user_slugs as $user_slug) {
            $slug_suffix = (int) Str::afterLast($user_slug, '-');

            if ($slug_suffix >= $suffix) {
                $suffix = $slug_suffix + 1;
            }
        }

        return "{$slug}-{$suffix}";
    }

    private function slugIsAvailable(string $slug): bool
    {
        return !User::query()->where('slug', $slug)->exists();
    }
}
