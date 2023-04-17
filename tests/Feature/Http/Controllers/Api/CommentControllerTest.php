<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api;

use App\Events\CommentApproved;
use App\Jobs\NewCommentAdminEmail;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Post;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const GET_COMMENTS_URI = '/api/comments';
    private const POST_COMMENT_URI = '/api/comments';
    private const LIKE_COMMENT_URI = '/api/comments/like';

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
        Queue::fake();
    }

    public function testGettingCommentsResponseHasSuccessfulStatus(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $url = self::GET_COMMENTS_URI . "?post_id={$post->id}";

        $this->getJson($url)->assertOk();
    }

    public function testYouCanGetComments(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        $text = 'I like this post! Keep it up!';

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'comment' => $text,
        ]);

        $url = self::GET_COMMENTS_URI . "?post_id={$post->id}";

        $this->getJson($url)
            ->assertJsonFragment([
                'id' => $comment->id,
                'comment' => $text,
                'user_id' => $user->id,
                'post_id' => $post->id,
                'likes_count' => 0,
            ]);
    }

    public function testFetchedCommentsHaveUserObject(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $url = self::GET_COMMENTS_URI . "?post_id={$post->id}";

        $fetched_user = $this->getJson($url)->json('0.user');

        $expect_user = [
            ...$user->only(explode(',', User::POST_COMMENT_FIELDS)),
            'sign_in_method' => $user->sign_in_method->value,
        ];

        $this->assertEquals($expect_user, $fetched_user);
    }

    public function testFetchedCommentsHaveAuthUserLike(): void
    {
        $user = $this->createUser();
        $some_other_user = $this->createUser();
        $post = Post::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        CommentLike::factory()->create([
            'user_id' => $user->id,
            'comment_id' => $comment->id,
        ]);

        // This like should not be in likes because it's not by the auth user
        CommentLike::factory()->create([
            'user_id' => $some_other_user->id,
            'comment_id' => $comment->id,
        ]);

        $url = self::GET_COMMENTS_URI . "?post_id={$post->id}&secret={$user->secret}";

        $likes = $this->getJson($url)
            ->json('0.likes');

        $this->assertCount(1, $likes);
    }

    public function testYouCanGetCommentsWithNestedComments(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'comment' => 'I like this post! Keep it up!',
        ]);

        $nested_comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'comment' => $reply = 'I agree!',
            'comment_id' => $comment->id,
        ]);

        $url = self::GET_COMMENTS_URI . "?post_id={$post->id}";

        $this->getJson($url)
            ->assertOk()
            ->assertJsonFragment([
                'id' => $nested_comment->id,
                'comment' => $reply,
                'user_id' => $user->id,
                'post_id' => $post->id,
                'comment_id' => $comment->id,
            ]);
    }

    public function testYouCanCreateComment(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();
        $text = 'Awesome post! Thank you for sharing your knowledge!';

        $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => $text,
        ])
            ->assertOk();

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'post_id' => $post->id,
            'comment' => $text,
        ]);
    }

    public function testYouCanReplyToComment(): void
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();
        $post = Post::factory()->create();

        // User 1 comments on a post
        $comment = Comment::factory()->create([
            'user_id' => $user1->id,
            'post_id' => $post->id,
        ]);

        // User 2 replies to User 1's comment
        $text = 'I agree with you! He is a great writer!';

        $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user2->secret,
            'comment' => $text,
            'comment_id' => $comment->id,
        ])
            ->assertOk();

        $this->assertDatabaseHas('comments', [
            'user_id' => $user2->id,
            'post_id' => $post->id,
            'comment' => $text,
            'comment_id' => $comment->id,
        ]);
    }

    public function testItRepliesToParentCommentAfterReplyingToReply(): void
    {
        $user1 = $this->createUser();
        $user2 = $this->createUser();
        $user3 = $this->createUser();

        $post = Post::factory()->create();

        // User 1 comments on a post
        $comment = Comment::factory()->create([
            'user_id' => $user1->id,
            'post_id' => $post->id,
        ]);

        // User 2 replies to User 1's comment
        $reply = Comment::factory()->create([
            'user_id' => $user2->id,
            'post_id' => $post->id,
            'comment_id' => $comment->id,
        ]);

        // User 3 replies to User 2's reply
        $text = 'I agree with you both!';

        $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user3->secret,
            'comment' => $text,
            'comment_id' => $reply->id,
        ])
            ->assertOk();

        $this->assertDatabaseHas('comments', [
            'user_id' => $user3->id,
            'post_id' => $post->id,
            'comment' => $text,
            'comment_id' => $comment->id,
        ]);
    }

    public function testUserCannotCreateCommentLessThan4Characters(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => 'Hi!',
        ]);

        $resp->assertJsonValidationErrors('comment');
    }

    public function testUserCannotCreateCommentMoreThan1000Characters(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => Str::random(1001),
        ]);

        $resp->assertJsonValidationErrors('comment');
    }

    public function testUserCanCreateCommentWith4Characters(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => 'dude',
        ]);

        $resp->assertOk();

        $this->assertDatabaseCount('comments', 1);
    }

    public function testUserCanCreateCommentWith1000Characters(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => Str::random(1000),
        ]);

        $resp->assertOk();

        $this->assertDatabaseCount('comments', 1);
    }

    public function testYouCanOnlySubmitOneCommentInSomeMinutes(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();
        $text = 'Awesome post! Thank you for sharing your knowledge!';

        // Create comment
        Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        // Try to create the second comment
        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => $text,
        ]);

        $resp->assertJsonValidationErrors('comment');

        $this->assertDatabaseCount('comments', 1);
    }

    public function testYouCanSubmitTheSecondCommentAfterSomeMinutes(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();
        $text = 'Awesome post! Thank you for sharing your knowledge!';

        $timeout_minutes = (int) config('app.comments_timeout_minutes');

        // Create comment
        Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
            'created_at' => now()->subMinutes($timeout_minutes + 1),
        ]);

        // Create the second comment
        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => $text,
        ]);

        $resp->assertOk();

        $this->assertDatabaseCount('comments', 2);
    }

    public function testAdminCanPostManyComments(): void
    {
        $user = $this->createAdmin();
        $post = Post::factory()->create();

        $fields = [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => 'Thank you for your comment',
        ];

        $this->postJson(self::POST_COMMENT_URI, $fields);
        $this->postJson(self::POST_COMMENT_URI, $fields);

        $response = $this->postJson(self::POST_COMMENT_URI, $fields);

        $response->assertOk();

        $this->assertDatabaseCount('comments', 3);
    }

    public function testPostingCommentReturnsDateInFuture(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();
        $text = 'Awesome post! Thank you for sharing your knowledge!';

        $timeout_minutes = (int) config('app.comments_timeout_minutes');

        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => $text,
        ]);

        $date = CarbonImmutable::parse($resp->json('date'));

        $this->assertTrue($date->isFuture());
        $this->assertTrue($date->subMinutes($timeout_minutes)->subSeconds(2)->isPast());
    }

    public function testPostingCommentReturnsCurrentDateForAdmin(): void
    {
        $user = $this->createAdmin();
        $post = Post::factory()->create();

        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => 'Awesome post! Thank you!',
        ]);

        $date = CarbonImmutable::parse($resp->json('date'));

        $this->assertTrue($date->subSeconds(5)->isPast());
        $this->assertTrue($date->addSeconds(5)->isFuture());
    }

    /**
     * @dataProvider providerForTestPostingCommentWithSwearWordWillBeMarkedAsNotApproved
     */
    public function testPostingCommentWithSwearWordWillBeMarkedAsNotApproved(string $text): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => $text,
        ]);

        $resp->assertOk();

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'comment' => $text,
            'is_approved' => false,
        ]);
    }

    public static function providerForTestPostingCommentWithSwearWordWillBeMarkedAsNotApproved(): array
    {
        return [
            ['Thank you for sharing your knowledge, you fucking idiot!'],
            ['This is my site: https://my-site.com'],
            ['This is my site: http://my-site.com'],
            ['I hate you moran!'],
            ['I hate you MORAN!'],
            ['This is stupid to think like that'],
            ['I hate watching p0rn!'],
        ];
    }

    /**
     * @dataProvider providerForTestPostingCommentWithoutSwearWordWillBeMarkedAsApproved
     */
    public function testPostingCommentWithoutSwearWordWillBeMarkedAsApproved(string $text): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => $text,
        ]);

        $resp->assertOk();

        $this->assertDatabaseHas('comments', [
            'post_id' => $post->id,
            'comment' => $text,
            'is_approved' => true,
        ]);
    }

    public static function providerForTestPostingCommentWithoutSwearWordWillBeMarkedAsApproved(): array
    {
        return [
            ['This is the best article that I\'ve read so far!'],
            ['Hello man! Thank you for your answer!'],
            ['Do you know what is 5 minus 5 will be? I know it, it will be 0.'],
            ['Look at this code sample: $x = 0; echo $x . "-result";'],
            ['Thank you 👍'],
        ];
    }

    public function testPostingCommentDispatchesCommentPostedEvent(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => 'Thank you for your comment!',
        ]);

        Event::assertDispatchedTimes(CommentApproved::class, 1);
    }

    public function testPostingCommentIsNotDispatchingEventIfCommentIsNotApproved(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => 'Thank you for your stupid blog post!',
        ]);

        Event::assertNotDispatched(CommentApproved::class);
    }

    public function testCommentMustBeWrittenInEnglish(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => 'Спасибо за ваш пост!',
        ]);

        $resp->assertJsonValidationErrors('comment');
    }

    public function testYouCannotPostCommentAsNotVerifiedUser(): void
    {
        $user = User::factory()->unverified()->create();
        $post = Post::factory()->create();

        $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => 'Hello! Thank you for your post!',
        ]);

        $this->assertDatabaseEmpty('comments');
    }

    public function testPostingCommentQueuesTheJobForSendingAdminEmail(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => 'Hello! Thank you for your post!',
        ]);

        Queue::assertPushed(NewCommentAdminEmail::class);
    }

    public function testPostingCommentAsAdminDoesntQueueTheJobForSendingAdminEmail(): void
    {
        $user = $this->createAdmin();
        $post = Post::factory()->create();

        $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => 'Hello! Thank you for your post!',
        ]);

        Queue::assertNotPushed(NewCommentAdminEmail::class);
    }

    public function testUserCannotPostCommentWhenBanned(): void
    {
        $user = $this->createUser();
        $post = Post::factory()->create();

        $user->ban()->create(['comment' => 'You are banned!']);

        $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $post->id,
            'secret' => $user->secret,
            'comment' => 'Hello! Thank you for your post!',
        ]);

        $this->assertDatabaseEmpty('comments');
    }

    public function testServerReturnsValidationErrorIfPostIdDoesntExist(): void
    {
        $user = $this->createUser();

        $this->actingAs($user, 'user')
            ->postJson(self::POST_COMMENT_URI, [
                'post_id' => 999,
                'secret' => $user->secret,
                'comment' => 'Hello! Thank you for your post!',
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['post_id']);
    }

    public function testAuthUserCanLikeTheComment(): void
    {
        $user = $this->createUser();

        /** @var Post $post */
        $post = Post::factory()->create();

        /** @var Comment $comment */
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $this->actingAs($user, 'user')
            ->postJson(self::LIKE_COMMENT_URI, [
                'comment_id' => $comment->id,
                'secret' => $user->secret,
            ])
            ->assertOk();

        $this->assertDatabaseHas('comment_likes', [
            'user_id' => $user->id,
            'comment_id' => $comment->id,
        ]);
    }

    public function testAuthUserCanUnlikeTheComment(): void
    {
        $user = $this->createUser();

        /** @var Post $post */
        $post = Post::factory()->create();

        /** @var Comment $comment */
        $comment = Comment::factory()->create([
            'user_id' => $user->id,
            'post_id' => $post->id,
        ]);

        $comment->likes()->create(['user_id' => $user->id]);

        $this->actingAs($user, 'user')
            ->postJson(self::LIKE_COMMENT_URI, [
                'comment_id' => $comment->id,
                'secret' => $user->secret,
            ])
            ->assertOk();

        $this->assertDatabaseEmpty('comment_likes');
    }
}
