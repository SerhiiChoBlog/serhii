<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class TestimonialController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json(config('testimonials'));
    }
}
