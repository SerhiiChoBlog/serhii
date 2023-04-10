<?php

declare(strict_types=1);

namespace App\Recommendations\Filters;

use App\Utils\GlobalVisitor;
use Illuminate\Support\Collection;

final readonly class ViewedContentFilter implements Filter
{
    /**
     * @inheritDoc
     */
    public function process(Collection $posts): Collection
    {
        $visitor = GlobalVisitor::getInstance()->get();

        if (!$visitor) {
            return $posts;
        }

        $viewed_posts = $visitor->postViews()->pluck('post_id');
        $result = collect();

        foreach ($posts as $post) {
            if ($viewed_posts->contains($post->id)) {
                continue;
            }

            $result->push($post);
        }

        return $result;
    }
}
