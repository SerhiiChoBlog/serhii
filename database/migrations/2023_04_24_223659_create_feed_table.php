<?php

declare(strict_types=1);

use App\Models\Badge;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('feed', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();

            $table->unsignedSmallInteger('post_id')->nullable();
            $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();

            $table->foreignIdFor(Comment::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Badge::class)->nullable()->constrained()->cascadeOnDelete();
            $table->string('type', 20);
            $table->timestamp('date')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('feed');
    }
};
