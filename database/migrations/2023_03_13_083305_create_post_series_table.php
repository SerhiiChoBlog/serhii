<?php

declare(strict_types=1);

use App\Models\Series;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('post_series', function (Blueprint $table) {
            $table->unsignedSmallInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();
            $table->foreignIdFor(Series::class)->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('part')->default(1);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('post_series');
    }
};
