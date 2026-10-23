<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Api;

use App\Enums\FeedType;
use App\Events\CommentApproved;
use App\Jobs\NewCommentAdminEmail;
use App\Models\Comment;
use App\Models\CommentLike;
use App\Models\Feed;
use App\Models\Post;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class CommentControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    private const GET_COMMENTS_URI = '/api/comments';
    private const POST_COMMENT_URI = '/api/comments';
    private const LIKE_COMMENT_URI = '/api/comments/like';

    private User $user;
    private Post $post;

    public function setUp(): void
    {
        parent::setUp();
        Event::fake();
        Queue::fake();
        $this->user = $this->createUser();
        $this->post = Post::factory()->create();
        $this->actingAs($this->user, 'user');
    }

    public function testGettingCommentsResponseHasSuccessfulStatus(): void
    {
        Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);

        $url = self::GET_COMMENTS_URI . "?post_id={$this->post->id}";

        $this->getJson($url)->assertOk();
    }

    public function testYouCanGetComments(): void
    {
        $text = 'I like this post! Keep it up!';

        $comment = Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
            'comment' => $text,
        ]);

        $url = self::GET_COMMENTS_URI . "?post_id={$this->post->id}";

        $this->getJson($url)
            ->assertJsonFragment([
                'id' => $comment->id,
                'comment' => $text,
                'user_id' => $this->user->id,
                'post_id' => $this->post->id,
                'likes_count' => 0,
            ]);
    }

    public function testFetchedCommentsHaveUserObject(): void
    {
        Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);

        $url = self::GET_COMMENTS_URI . "?post_id={$this->post->id}";

        $fetched_user = $this->getJson($url)->json('0.user');

        $expect_user = [
            ...$this->user->only(explode(',', User::POST_COMMENT_FIELDS)),
            'sign_in_method' => $this->user->sign_in_method->value,
        ];

        $this->assertEquals($expect_user, $fetched_user);
    }

    public function testFetchedCommentsHaveAuthUserLike(): void
    {
        $some_other_user = $this->createUser();
        $comment = Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);

        CommentLike::factory()->create([
            'user_id' => $this->user->id,
            'comment_id' => $comment->id,
        ]);

        // This like should not be in likes because it's not by the auth user
        CommentLike::factory()->create([
            'user_id' => $some_other_user->id,
            'comment_id' => $comment->id,
        ]);

        $url = self::GET_COMMENTS_URI . "?post_id={$this->post->id}";

        $likes = $this->getJson($url)
            ->json('0.likes');

        $this->assertCount(1, $likes);
    }

    public function testYouCanGetCommentsWithNestedComments(): void
    {
        $comment = Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
            'comment' => 'I like this post! Keep it up!',
        ]);

        $nested_comment = Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
            'comment' => $reply = 'I agree!',
            'comment_id' => $comment->id,
        ]);

        $url = self::GET_COMMENTS_URI . "?post_id={$this->post->id}";

        $this->getJson($url)
            ->assertOk()
            ->assertJsonFragment([
                'id' => $nested_comment->id,
                'comment' => $reply,
                'user_id' => $this->user->id,
                'post_id' => $this->post->id,
                'comment_id' => $comment->id,
            ]);
    }

    public function testYouCanCreateComment(): void
    {
        $text = 'Awesome post! Thank you for sharing your knowledge!';

        $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => $text,
        ])
            ->assertOk();

        $this->assertDatabaseHas('comments', [
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
            'comment' => $text,
        ]);
    }

    public function testYouCanReplyToComment(): void
    {
        $user2 = $this->createUser();

        // User 1 comments on a post
        $comment = Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);

        // User 2 replies to User 1's comment
        $text = 'I agree with you! He is a great writer!';

        $this->actingAs($user2, 'user');

        $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => $text,
            'comment_id' => $comment->id,
        ])
            ->assertOk();

        $this->assertDatabaseHas('comments', [
            'user_id' => $user2->id,
            'post_id' => $this->post->id,
            'comment' => $text,
            'comment_id' => $comment->id,
        ]);
    }

    public function testItRepliesToParentCommentAfterReplyingToReply(): void
    {
        $user2 = $this->createUser();
        $user3 = $this->createUser();

        // User 1 comments on a post
        $comment = Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);

        // User 2 replies to User 1's comment
        $reply = Comment::factory()->create([
            'user_id' => $user2->id,
            'post_id' => $this->post->id,
            'comment_id' => $comment->id,
        ]);

        // User 3 replies to User 2's reply
        $text = 'I agree with you both!';

        $this->actingAs($user3, 'user');

        $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => $text,
            'comment_id' => $reply->id,
        ])
            ->assertOk();

        $this->assertDatabaseHas('comments', [
            'user_id' => $user3->id,
            'post_id' => $this->post->id,
            'comment' => $text,
            'comment_id' => $comment->id,
        ]);
    }

    public function testUserCannotCreateCommentLessThan4Characters(): void
    {
        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => 'Hi!',
        ]);

        $resp->assertJsonValidationErrors('comment');
    }

    public function testUserCannotCreateCommentMoreThan1000Characters(): void
    {
        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => Str::random(1001),
        ]);

        $resp->assertJsonValidationErrors('comment');
    }

    public function testUserCanCreateCommentWith4Characters(): void
    {
        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => 'dude',
        ]);

        $resp->assertOk();

        $this->assertDatabaseCount('comments', 1);
    }

    public function testUserCanCreateCommentWith1000Characters(): void
    {
        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => Str::random(1000),
        ]);

        $resp->assertOk();

        $this->assertDatabaseCount('comments', 1);
    }

    public function testYouCanOnlySubmitOneCommentInSomeMinutes(): void
    {
        $text = 'Awesome post! Thank you for sharing your knowledge!';

        // Create comment
        Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);

        // Try to create the second comment
        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => $text,
        ]);

        $resp->assertJsonValidationErrors('comment');

        $this->assertDatabaseCount('comments', 1);
    }

    public function testYouCanSubmitTheSecondCommentAfterSomeMinutes(): void
    {
        $text = 'Awesome post! Thank you for sharing your knowledge!';
        $timeout_minutes = (int) config('app.comments_timeout_minutes');

        // Create comment
        Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
            'created_at' => now()->subMinutes($timeout_minutes + 1),
        ]);

        // Create the second comment
        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => $text,
        ]);

        $resp->assertOk();

        $this->assertDatabaseCount('comments', 2);
    }

    public function testAdminCanPostManyComments(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin');

        $fields = [
            'post_id' => $this->post->id,
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
        $text = 'Awesome post! Thank you for sharing your knowledge!';

        $timeout_minutes = (int) config('app.comments_timeout_minutes');

        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => $text,
        ]);

        $date = CarbonImmutable::parse($resp->json('date'));

        $this->assertTrue($date->isFuture());
        $this->assertTrue($date->subMinutes($timeout_minutes)->subSeconds(2)->isPast());
    }

    public function testPostingCommentReturnsCurrentDateForAdmin(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin');

        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => 'Awesome post! Thank you!',
        ]);

        $date = CarbonImmutable::parse($resp->json('date'));

        $this->assertTrue($date->subSeconds(5)->isPast());
        $this->assertTrue($date->addSeconds(5)->isFuture());
    }

    #[DataProvider('providerForTestPostingCommentWithSwearWordWillBeMarkedAsNotApproved')]
    public function testPostingCommentWithSwearWordWillBeMarkedAsNotApproved(string $text): void
    {
        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => $text,
        ]);

        $resp->assertOk();

        $this->assertDatabaseHas('comments', [
            'post_id' => $this->post->id,
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

    #[DataProvider('providerForTestPostingCommentWithoutSwearWordWillBeMarkedAsApproved')]
    public function testPostingCommentWithoutSwearWordWillBeMarkedAsApproved(string $text): void
    {
        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => $text,
        ]);

        $resp->assertOk();

        $this->assertDatabaseHas('comments', [
            'post_id' => $this->post->id,
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
        $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => 'Thank you for your comment!',
        ]);

        Event::assertDispatchedTimes(CommentApproved::class, 1);
    }

    public function testPostingCommentIsNotDispatchingEventIfCommentIsNotApproved(): void
    {
        $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => 'Thank you for your stupid blog post!',
        ]);

        Event::assertNotDispatched(CommentApproved::class);
    }

    public function testCommentMustBeWrittenInEnglish(): void
    {
        $resp = $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => 'Спасибо за ваш пост!',
        ]);

        $resp->assertJsonValidationErrors('comment');
    }

    public function testYouCannotPostCommentAsNotVerifiedUser(): void
    {
        $user = User::factory()->unverified()->create();

        $this->actingAs($user, 'user');

        $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => 'Hello! Thank you for your post!',
        ]);

        $this->assertDatabaseEmpty('comments');
    }

    public function testPostingCommentQueuesTheJobForSendingAdminEmail(): void
    {
        $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => 'Hello! Thank you for your post!',
        ]);

        Queue::assertPushed(NewCommentAdminEmail::class);
    }

    public function testPostingCommentAsAdminDoesntQueueTheJobForSendingAdminEmail(): void
    {
        $admin = $this->createAdmin();

        $this->actingAs($admin, 'admin');

        $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => 'Hello! Thank you for your post!',
        ]);

        Queue::assertNotPushed(NewCommentAdminEmail::class);
    }

    public function testUserCannotPostCommentWhenBanned(): void
    {
        $this->user->ban()->create(['comment' => 'You are banned!']);

        $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => 'Hello! Thank you for your post!',
        ]);

        $this->assertDatabaseEmpty('comments');
    }

    public function testServerReturnsValidationErrorIfPostIdDoesntExist(): void
    {
        $this->actingAs($this->user, 'user')
            ->postJson(self::POST_COMMENT_URI, [
                'post_id' => 999,
                'comment' => 'Hello! Thank you for your post!',
            ])
            ->assertStatus(422)
            ->assertJsonValidationErrors(['post_id']);
    }

    public function testAuthUserCanLikeTheComment(): void
    {
        /** @var Comment $comment */
        $comment = Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);

        $this->actingAs($this->user, 'user')
            ->postJson(self::LIKE_COMMENT_URI, [
                'comment_id' => $comment->id,
            ])
            ->assertOk();

        $this->assertDatabaseHas('comment_likes', [
            'user_id' => $this->user->id,
            'comment_id' => $comment->id,
        ]);
    }

    public function testAuthUserCanUnlikeTheComment(): void
    {
        /** @var Comment $comment */
        $comment = Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);

        $comment->likes()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user, 'user')
            ->postJson(self::LIKE_COMMENT_URI, [
                'comment_id' => $comment->id,
            ]);

        $this->assertDatabaseEmpty('comment_likes');
    }

    public function testLikingCommentAddsFeedItem(): void
    {
        /** @var Comment $comment */
        $comment = Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);

        $this->actingAs($this->user, 'user')
            ->postJson(self::LIKE_COMMENT_URI, [
                'comment_id' => $comment->id,
            ]);

        $this->assertDatabaseHas('feed', [
            'user_id' => $this->user->id,
            'comment_id' => $comment->id,
            'post_id' => $this->post->id,
            'type' => FeedType::COMMENT_LIKE,
        ]);
    }

    public function testUnlikingCommentRemovesFeedItem(): void
    {
        /** @var Comment $comment */
        $comment = Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
        ]);

        Feed::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
            'comment_id' => $comment->id,
            'type' => FeedType::COMMENT_LIKE,
        ]);

        $comment->likes()->create(['user_id' => $this->user->id]);

        $this->actingAs($this->user, 'user')
            ->postJson(self::LIKE_COMMENT_URI, [
                'comment_id' => $comment->id,
            ]);

        $this->assertDatabaseEmpty('feed');
    }

    public function testCreatingCommentAddsFeedItem(): void
    {
        $this->postJson(self::POST_COMMENT_URI, [
            'post_id' => $this->post->id,
            'comment' => 'This is some comment here in this field',
        ]);

        $this->assertDatabaseHas('feed', [
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
            'comment_id' => 1,
            'type' => FeedType::COMMENT,
        ]);
    }

    public function testCommentHtmlIsSanitizedBeforeSaving(): void
    {
        $payload = '<a href="javascript:alert(window.Auth.secret)" onmouseover="alert(1)" style="display:block;padding:200px">hi</a>';

        $this->actingAs($this->user, 'user')
            ->postJson(self::POST_COMMENT_URI, [
                'post_id' => $this->post->id,
                'comment' => $payload,
            ])
            ->assertOk();

        $this->assertDatabaseHas('comments', [
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
            'comment' => '<a>hi</a>',
            'is_approved' => true,
        ]);
    }

    public function testFetchedCommentsAreSanitized(): void
    {
        $payload = '<a href="javascript:alert(window.Auth.secret)" onmouseover="alert(1)" style="display:block;padding:200px">hi</a>';

        Comment::factory()->create([
            'user_id' => $this->user->id,
            'post_id' => $this->post->id,
            'comment' => $payload,
        ]);

        $url = self::GET_COMMENTS_URI . "?post_id={$this->post->id}";

        $comment = $this->getJson($url)->json('0.comment');

        $this->assertIsString($comment);
        $this->assertStringNotContainsString('javascript:', $comment);
        $this->assertStringNotContainsString('onmouseover', $comment);
        $this->assertStringNotContainsString('style=', $comment);
    }
}
