<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('post_content_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();
            $table->string('uri');
            $table->string('path');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_content_images');
    }
};
