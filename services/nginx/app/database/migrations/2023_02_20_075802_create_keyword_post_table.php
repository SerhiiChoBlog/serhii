<?php

declare(strict_types=1);

use App\Models\Keyword;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('keyword_post', function (Blueprint $table) {
            $table->foreignIdFor(Keyword::class)->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('post_id');
            $table->foreign('post_id')->references('id')->on('posts')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('keyword_post');
    }
};
