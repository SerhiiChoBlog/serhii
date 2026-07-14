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
use Illuminate\Support\Facades\Log;

class FetchVideos extends Command
{
    protected $signature = 'videos:fetch';
    protected $description = 'Fetches YouTube videos and saves them into a database table';

    public function handle(): void
    {
        try {
            $videos = Video::query()->get();

            $yt_videos = $this->fetchVideos();

            $updated = $this->updateExistingVideos($yt_videos, $videos);
            $created = $this->createMissingVideos($yt_videos, $videos);

            $removed = $this->removeLeftovers($yt_videos, $videos);

            Cache::forget(CacheKey::LAST_VIDEOS);

            $this->info("Videos updated: {$updated}");
            $this->info("Videos created: {$created}");
            $this->info("Videos removed: {$removed}");
        } catch (FetchVideosHttpException $e) {
            $this->error($e->getMessage());
            Log::error($e->getMessage());
        }
    }

    /**
     * @return Collection<int, YTVideo>
     * @throws FetchVideosHttpException
     */
    private function fetchVideos(): Collection
    {
        $url = config('services.youtube.url');

        $response = Http::retry(3, 1000)->get($url, [
            'part' => 'snippet',
            'channelId' => 'UCL-MGuK7gMg_Rw63uBHdWbA',
            'order' => 'date',
            'type' => 'video',
            'maxResults' => 50,
            'key' => config('services.youtube.key'),
        ]);

        if ($response->failed()) {
            $body = $response->body();
            /** @phpstan-ignore-next-line */
            $err = $body['error']['message'] ?? $body;
            throw new FetchVideosHttpException("Cannot fetch videos from YouTube: {$err}");
        }

        $items = $response->collect('items');

        if ($items->isEmpty()) {
            throw new FetchVideosHttpException("YouTube returned an empty list of videos.");
        }

        return $items->mapInto(YTVideo::class);
    }

    /**
     * @param Collection<int, YTVideo> $yt_videos
     * @param Collection<int, Video> $videos
     *
     * @return int Amount of updated videos
     */
    private function updateExistingVideos(Collection $yt_videos, Collection $videos): int
    {
        $updated = 0;

        foreach ($videos as $video) {
            /** @var YTVideo|null $yt_video */
            $yt_video = $yt_videos->where('id.video_id', $video->id)->first();

            if (!$yt_video || $this->videosHasNotChanged($video, $yt_video)) {
                continue;
            }

            $this->updateVideoInDatabase($video, $yt_video);

            $updated++;
        }

        return $updated;
    }

    /**
     * @param Collection<int, YTVideo> $yt_videos
     * @param Collection<int, Video> $videos
     *
     * @return int Amount of created videos
     */
    private function createMissingVideos(Collection $yt_videos, Collection $videos): int
    {
        $new = $yt_videos->filter(fn (YTVideo $v) => !$videos->contains('id', $v->id->video_id));

        $new->each(function (YTVideo $v) {
            $this->updateVideoInDatabase(new Video(), $v);
        });

        return $new->count();
    }

    private function updateVideoInDatabase(Video $video, YTVideo $yt_video): void
    {
        $video->id = $yt_video->id->video_id;
        $video->title = $yt_video->snippet->title;
        $video->description = $yt_video->snippet->description;
        $video->image = $this->getFullImageURL($yt_video);
        $video->url = "https://www.youtube.com/watch?v={$yt_video->id->video_id}";
        $video->published_at = $yt_video->snippet->published_at;

        $video->save();
    }

    private function videosHasNotChanged(Video $video, YTVideo $yt_video): bool
    {
        $same_title = $video->title === $yt_video->snippet->title;
        $same_description = $video->description === $yt_video->snippet->description;
        $same_image = $video->image === $this->getFullImageURL($yt_video);

        return $same_title && $same_description && $same_image;
    }

    private function getFullImageURL(YTVideo $yt_video): string
    {
        return "https://img.youtube.com/vi/{$yt_video->id->video_id}/mqdefault.jpg";
    }

    /**
     * @param Collection<int, YTVideo> $yt_videos
     * @param Collection<int, Video> $videos
     */
    private function removeLeftovers(Collection $yt_videos, Collection $videos): int
    {
        $left_overs = $videos->filter(function (Video $v) use ($yt_videos) {
            return !$yt_videos->contains(fn (YTVideo $yt) => $yt->id->video_id === $v->id);
        });

        $left_overs->each(fn (Video $v) => $v->delete());

        return $left_overs->count();
    }
}
