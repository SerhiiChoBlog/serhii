<?php

declare(strict_types=1);

namespace App\Dto\YouTube;

class YTThumbnails
{
    public YTThumbnail $default;
    public YTThumbnail $medium;
    public YTThumbnail $high;

    public function __construct(array $data)
    {
        $this->default = new YTThumbnail($data['default']);
        $this->medium = new YTThumbnail($data['medium']);
        $this->high = new YTThumbnail($data['high']);
    }
}
