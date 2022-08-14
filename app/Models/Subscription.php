<?php

declare(strict_types=1);

namespace App\Models;

use App\Notifications\ConfirmSubscription;
use App\Notifications\PostPublished;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Notification;

/**
 * @property-read int $id
 * @property string $email
 * @property Carbon|null $confirmed_at
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Subscription extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $guarded = ['id'];

    public function notifySubConfirmation(): void
    {
        Notification::route('mail', $this->email)->notify(new ConfirmSubscription());
    }

    public function notifyPostPublished(Post $post): void
    {
        Notification::route('mail', $this->email)->notify(new PostPublished($post));
    }
}
