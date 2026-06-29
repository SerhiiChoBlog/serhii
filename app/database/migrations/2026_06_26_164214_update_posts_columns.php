<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('image_xs')->default('img/posts/placeholder-xs.jpg')->change();
            $table->string('image_sm')->default('img/posts/placeholder-sm.jpg')->change();
            $table->string('image_lg')->default('img/posts/placeholder.jpg')->change();
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->string('image_xs')->default('storage/posts/placeholder.jpg')->change();
            $table->string('image_sm')->default('storage/posts/placeholder.jpg')->change();
            $table->string('image_lg')->default('storage/posts/placeholder.jpg')->change();
        });
    }
};
