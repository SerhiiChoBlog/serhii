<?php

declare(strict_types=1);

namespace App\Dto\YouTube;

class YouTubeVideo
{
    /**
     * @var array{kind: string, videoId: string}
     */
    public array $id;
    public string $kind;
    public string $etag;
    public YouTubeSnippet $snippet;

    public function __construct(array $data)
    {
        $this->kind = $data['kind'];
        $this->etag = $data['etag'];
        $this->id = $data['id'];
        $this->snippet = new YouTubeSnippet($data['snippet']);
    }
}
