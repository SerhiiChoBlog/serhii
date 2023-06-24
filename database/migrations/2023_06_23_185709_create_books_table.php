<?php

declare(strict_types=1);

use App\Models\Book;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('image')->default(Book::DEFAULT_IMAGE);
            $table->string('slug');
            $table->unsignedTinyInteger('rate')->default(5);
            $table->boolean('is_reading')->default(false);
            $table->timestamp('read_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
