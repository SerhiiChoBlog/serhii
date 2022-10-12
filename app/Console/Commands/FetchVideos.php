<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\CacheKey;
use App\Dto\YouTube\YTVideo;
use App\Exceptions\FetchVideosHttpException;
use App\Models\Video;
use Illuminate\Console\Command;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class FetchVideos extends Command
{
    protected $signature = 'videos:fetch';
    protected $description = 'Fetches YouTube videos and saves them into a database table';

    public function handle(): void
    {
        try {
            /** @var Collection<int, Video> $old_videos */
            $old_videos = Video::query()->get();
            $videos = $this->fetchVideos();

            $updated = $this->updateExistingVideos($videos, $old_videos);
            $created = $this->createMissingVideos($videos, $old_videos);

            Cache::forget(CacheKey::HOME_POPULAR_VIDEOS);

            $this->info("Videos updated: $updated. Videos created: $created");
        } catch (FetchVideosHttpException $e) {
            $this->error($e->getMessage());
            logger()->error($e);
        }
    }

    /**
     * @return Collection<int, YTVideo>
     * @throws FetchVideosHttpException
     */
    private function fetchVideos(): Collection
    {
        $url = config('services.youtube.url');

        $response = Http::get($url, [
            'part' => 'snippet',
            'channelId' => 'UCL-MGuK7gMg_Rw63uBHdWbA',
            'order' => 'date',
            'type' => 'video',
            'maxResults' => 50,
            'key' => config('services.youtube.key'),
        ]);

        if ($response->failed()) {
            throw new FetchVideosHttpException('Cannot fetch videos from YouTube');
        }

        return $response
            ->collect('items')
            ->mapInto(YTVideo::class);
    }

    /**
     * @param Collection<int, YTVideo> $videos
     * @param Collection<int, Video> $old_videos
     *
     * @return int Amount of updated videos
     */
    private function updateExistingVideos(Collection $videos, Collection $old_videos): int
    {
        return 0;
    }

    /**
     * @param Collection<int, YTVideo> $videos
     * @param Collection<int, Video> $old_videos
     *
     * @return int Amount of created videos
     */
    private function createMissingVideos(Collection $videos, Collection $old_videos): int
    {
        $videos->filter(fn(YTVideo $video) => $video->id);

        return 0;
    }
}
