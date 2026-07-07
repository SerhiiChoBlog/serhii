<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->string('name');
            $table->string('title');
            $table->string('url');
            $table->text('description');
            $table->text('content');
            $table->string('language');
            $table->unsignedMediumInteger('stars');
            $table->timestamp('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
