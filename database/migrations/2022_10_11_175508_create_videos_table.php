<?php

declare(strict_types=1);

use App\Models\Post;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->string('id')->unique();
            $table->foreignIdFor(Post::class)->nullable();
            $table->string('title');
            $table->string('description');
            $table->string('url');
            $table->string('image');
            $table->timestamp('published_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};
