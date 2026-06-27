<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('post_publications', function (Blueprint $table) {
            $table->id();

            $table->unsignedSmallInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();

            $table->unsignedInteger('people_notified')->default(0);
            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_publications');
    }
};
