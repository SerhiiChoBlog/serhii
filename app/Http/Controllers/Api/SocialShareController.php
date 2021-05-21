<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Visitor;
use Illuminate\Http\Request;

class SocialShareController extends Controller
{
    public function store(Post $post, Request $request): void
    {
        $visitor = Visitor::getOrCreateVisitor($request->ip());

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
