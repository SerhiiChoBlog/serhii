<?php

declare(strict_types=1);

namespace App\Dto\YouTube;

use Illuminate\Support\Carbon;

class YTSnippet
{
    public Carbon $published_at;
    public string $channel_id;
    public string $title;
    public string $description;
    public YTThumbnails $thumbnails;
    public string $channel_title;
    public string $live_broadcast_content;
    public Carbon $publish_time;

    /**
     * @param YouTubeSnippet $data
     */
    public function __construct(array $data)
    {
        $this->published_at = Carbon::make($data['publishedAt']) ?? Carbon::now();
        $this->channel_id = $data['channelId'];
        $this->title = $data['title'];
        $this->description = $data['description'];
        $this->thumbnails = new YTThumbnails($data['thumbnails']);
        $this->channel_title = $data['channelTitle'];
        $this->live_broadcast_content = $data['liveBroadcastContent'];
        $this->publish_time = Carbon::make($data['publishTime']) ?? Carbon::now();
    }
}
