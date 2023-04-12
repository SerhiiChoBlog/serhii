<?php

declare(strict_types=1);

namespace App\Recommendations\Filters;

use App\Recommendations\DataStream;

interface Filter
{
    public const POST_FIELDS = ['id', 'title', 'slug', 'image_sm'];
    public const SERIES_FIELDS = 'id,title';

    public function process(DataStream $stream): DataStream;
}
