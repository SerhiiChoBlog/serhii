<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::table('series', function (Blueprint $table) {
            $table->string('image_xs')->default('img/series/placeholder-sm.jpg')->change();
            $table->string('image_sm')->default('img/series/placeholder-sm.jpg')->change();
            $table->string('image_lg')->default('img/series/placeholder.jpg')->change();
        });
    }

    public function down(): void
    {
        Schema::table('series', function (Blueprint $table) {
            $table->string('image_xs')->default('storage/series/placeholder.jpg')->change();
            $table->string('image_sm')->default('storage/series/placeholder.jpg')->change();
            $table->string('image_lg')->default('storage/series/placeholder.jpg')->change();
        });
    }
};
