<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('post_content_images', function (Blueprint $table) {
            $table->dropColumn('alt');
        });
    }

    public function down(): void
    {
        Schema::table('post_content_images', function (Blueprint $table) {
            $table->string('alt')->after('post_id');
        });
    }
};
