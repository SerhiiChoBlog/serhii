<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('intro')->nullable();
            $table->mediumText('content')->nullable();
            $table->boolean('is_published')->default(false);
            $table->string('image_sm')->default('storage/posts/placeholder.jpg');
            $table->string('image_lg')->default('storage/posts/placeholder.jpg');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
