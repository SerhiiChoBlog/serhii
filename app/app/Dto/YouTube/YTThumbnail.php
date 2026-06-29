<?php

declare(strict_types=1);

namespace App\Dto\YouTube;

class YTThumbnail
{
    public string $url;
    public int $width;
    public int $height;

    /**
     * @param YouTubeThumbnail $data
     */
    public function __construct(array $data)
    {
        $this->url = $data['url'];
        $this->width = $data['width'];
        $this->height = $data['height'];
    }
}
