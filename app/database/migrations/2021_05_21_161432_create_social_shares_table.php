<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('social_shares', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();
            $table->unsignedBigInteger('visitor_id');
            $table->foreign('visitor_id')->references('id')->on('visitors')->cascadeOnDelete();
            $table->string('social', 100);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('social_shares');
    }
};
