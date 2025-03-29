<?php

declare(strict_types=1);

namespace App\Dto\YouTube;

class YTVideoId
{
    public string $kind;
    public string $video_id;

    /**
     * @param YouTubeVideoID $data
     */
    public function __construct(array $data)
    {
        $this->kind = $data['kind'];
        $this->video_id = $data['videoId'];
    }
}
