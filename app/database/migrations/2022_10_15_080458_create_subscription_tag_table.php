<?php

declare(strict_types=1);

use App\Models\Subscription;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('subscription_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Subscription::class)->constrained()->cascadeOnDelete();
            $table->unsignedSmallInteger('tag_id');
            $table->foreign('tag_id')->references('id')->on('tags')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_tag');
    }
};
