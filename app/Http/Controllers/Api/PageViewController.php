<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\PageViewController\UpdateRequest;
use App\Models\Visitor;
use Stevebauman\Location\Location;

class PageViewController extends Controller
{
    public function update(UpdateRequest $request, Location $location): void
    {
        $ip = $request->ip();
        $visitor = Visitor::query()->with('pageViews')->where('ip', $ip)->first();

        if (!$visitor) {
            $position = $location->get($ip);

            $visitor = Visitor::query()->create([
                'ip' => $ip,
                'country' => $position->countryName ?? null,
                'city' => $position->cityName ?? null,
                'code' => $position->countryCode ?? null,
            ]);
        }

        $old_record = $visitor->pageViews->where('slug', $request->slug)->first();

        if ($old_record) {
            $old_record->increment('views');
            return;
        }

        $visitor->pageViews()->create([
            'slug' => $request->slug,
            'page_type' => $request->page_type,
        ]);
    }
}
