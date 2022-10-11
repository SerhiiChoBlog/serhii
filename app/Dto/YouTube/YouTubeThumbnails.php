<?php

declare(strict_types=1);

namespace App\Dto\YouTube;

class YouTubeThumbnails
{
    public YouTubeThumbnail $default;
    public YouTubeThumbnail $medium;
    public YouTubeThumbnail $high;

    public function __construct(array $data)
    {
        $this->default = new YouTubeThumbnail($data['default']);
        $this->medium = new YouTubeThumbnail($data['medium']);
        $this->high = new YouTubeThumbnail($data['high']);
    }
}
