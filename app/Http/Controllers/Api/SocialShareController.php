<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SocialShare\StoreRequest;
use App\Models\Post;
use App\Models\User;
use App\Utils\GlobalVisitor;
use Illuminate\Support\Facades\Log;
use Throwable;

class SocialShareController extends Controller
{
    public function store(Post $post, StoreRequest $request): void
    {
        $ip = $request->ip();

        if (!$ip) {
            return;
        }

        try {
            $visitor = GlobalVisitor::getInstance()->get();
        } catch (Throwable $e) {
            Log::error($e->getMessage());
            return;
        }

        $is_admin = $request->secret && User::isAdmin('secret', $request->secret);

        if (!$visitor || $is_admin) {
            return;
        }

        $has_old_record = $post->socialShares()
            ->where('visitor_id', $visitor->id)
            ->where('social', $request->social)
            ->exists();

        if ($has_old_record) {
            return;
        }

        $post->socialShares()->create([
            'visitor_id' => $visitor->id,
            'user_id' => User::getBySecret($request->secret)?->id,
            'social' => $request->social,
        ]);
    }
}
