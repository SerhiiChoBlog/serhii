<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('series', function (Blueprint $table) {
            $table->id();
            $table->string('slug');
            $table->string('title');
            $table->string('intro');
            $table->text('description');
            $table->string('color_from', 10)->default('#0f0f0f');
            $table->string('color_to', 10)->default('#383838');
            $table->string('image_xs')->default('storage/series/placeholder.jpg');
            $table->string('image_sm')->default('storage/series/placeholder.jpg');
            $table->string('image_lg')->default('storage/series/placeholder.jpg');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('series');
    }
};
