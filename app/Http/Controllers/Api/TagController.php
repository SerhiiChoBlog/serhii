<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tag;

class TagController extends Controller
{
    public function search(string $word): array
    {
        return Tag::query()
            ->where('name', 'LIKE', "%$word%")
            ->get()
            ->toArray();
    }
}
