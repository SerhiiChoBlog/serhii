<?php

declare(strict_types=1);

use App\Models\Comment;
use App\Models\Post;
use App\Models\Visitor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Post::class);
            $table->foreignIdFor(Visitor::class);
            $table->foreignIdFor(Comment::class)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('name', 150);
            $table->text('comment');
            $table->string('avatar');
            $table->boolean('is_subscribed')->default(false);
            $table->timestamp('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
