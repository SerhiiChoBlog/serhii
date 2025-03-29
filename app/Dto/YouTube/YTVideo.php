<?php

declare(strict_types=1);

namespace App\Dto\YouTube;

class YTVideo
{
    public string $kind;
    public string $etag;
    public YTVideoId $id;
    public YTSnippet $snippet;

    /**
     * @param array{
     *     kind: string,
     *     etag: string,
     *     id: YouTubeVideoID,
     *     snippet: YouTubeSnippet,
     * } $data
     */
    public function __construct(array $data)
    {
        $this->kind = $data['kind'];
        $this->etag = $data['etag'];
        $this->id = new YTVideoId($data['id']);
        $this->snippet = new YTSnippet($data['snippet']);
    }
}
