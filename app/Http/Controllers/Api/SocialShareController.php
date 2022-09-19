<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Throwable;

class SocialShareController extends Controller
{
    public function store(Post $post, Request $request): void
    {
        $ip = $request->ip();

        if (!$ip || auth()->check()) {
            return;
        }

        try {
            $visitor = Visitor::getOrCreateVisitor($ip);
        } catch (Throwable $e) {
            logger()->error($e);
            return;
        }


        if (!$visitor) {
            return;
        }

        $has_old_record = $post->socialShares()
            ->where('visitor_id', $visitor->id)
            ->where('social', $request->get('social'))
            ->exists();

        if ($has_old_record) {
            return;
        }

        $post->socialShares()->create([
            'visitor_id' => $visitor->id,
            'social' => $request->get('social'),
        ]);
    }
}
