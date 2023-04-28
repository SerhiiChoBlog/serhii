<?php

declare(strict_types=1);

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewPostView implements ShouldBroadcast, ShouldBroadcastNow
{
    use Dispatchable;
    use SerializesModels;

    public function __construct(public int $post_id, public string $country)
    {
    }

    public function broadcastOn(): Channel
    {
        return new Channel('notification');
    }

    /**
     * @return array<string, int|string>
     */
    public function broadcastWith(): array
    {
        return [
            'post_id' => $this->post_id,
            'country' => $this->country,
        ];
    }
}
