<?php

declare(strict_types=1);

namespace App\Dto;

readonly class SearchResult
{
    public string $title;
    public string $url;
    public string $image_url;

    /**
     * @var list(string)
     */
    public array $keywords;

    /**
     * @param array{
     *     title: string,
     *     url: string,
     *     image_url: string,
     *     keywords: list(string),
     * } $data
     */
    public function __construct(array $data)
    {
        $this->title = $data['title'];
        $this->url = $data['url'];
        $this->image_url = $data['image_url'];
        $this->keywords = $data['keywords'];
    }
}
