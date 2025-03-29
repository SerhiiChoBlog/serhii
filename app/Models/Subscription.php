<?php

declare(strict_types=1);

namespace App\Models;

use App\Notifications\ConfirmSubscription;
use App\Notifications\PostPublished;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Notification;

/**
 * @property-read int $id
 * @property int|null $user_id
 * @property string $email
 * @property string $slug
 * @property Carbon|null $confirmed_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection<int, Tag>|null $tags
 */
class Subscription extends Model
{
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $guarded = ['id'];

    /**
     * @note If subscriber doesn't have any tags, it means
     * that the person subscribed to all the publications.
     *
     * @return BelongsToMany<Tag, $this>
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function notifySubConfirmation(): void
    {
        $self = $this->load('tags');
        Notification::route('mail', $this->email)->notify(new ConfirmSubscription($self));
    }

    public function notifyPostPublished(Post $post): void
    {
        Notification::route('mail', $this->email)->notify(new PostPublished($post, $this));
    }
}
