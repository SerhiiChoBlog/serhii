<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class SitemapController extends Controller
{
    public function __invoke(): Response
    {
        $disk = Storage::disk('public');

        abort_unless($disk->exists('sitemap.xml'), 404);

        return response(
            $disk->get('sitemap.xml'),
            200,
            ['Content-Type' => 'application/xml'],
        );
    }
}
