<?php

declare(strict_types=1);

namespace App\Dto;

readonly class CachablePost
{
    public int $id;
    public string $title;
    public string $slug;
    public string $image_xs;

    /**
     * @var array<int, string>
     */
    public array $tags;

    /**
     * @var array<int, string>
     */
    public array $keywords;

    /**
     * @param array{
     *     id: int,
     *     title: string,
     *     slug: string,
     *     image_xs: string,
     *     tags: array<int, string>,
     *     keywords: array<int, string>,
     * } $data
     */
    public function __construct(array $data)
    {
        $this->id = $data['id'];
        $this->title = $data['title'];
        $this->slug = $data['slug'];
        $this->image_xs = $data['image_xs'];
        $this->tags = $data['tags'];
        $this->keywords = $data['keywords'];
    }
}
