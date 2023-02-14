<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('post_publications', function (Blueprint $table) {
            $table->unsignedInteger('people_skipped')->after('people_notified')->default(0);
        });
    }

    public function down(): void
    {
        Schema::table('post_publications', function (Blueprint $table) {
            $table->dropColumn('people_skipped');
        });
    }
};
