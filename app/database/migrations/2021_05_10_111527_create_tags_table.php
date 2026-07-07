<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name')->unique();
            $table->string('color', 100);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tags');
    }
};
