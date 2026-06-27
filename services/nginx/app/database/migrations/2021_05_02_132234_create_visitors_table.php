<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->id();
            $table->ipAddress('ip');
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('code', 50)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('visitors');
    }
};
