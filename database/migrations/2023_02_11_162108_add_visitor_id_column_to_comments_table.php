<?php

declare(strict_types=1);

use App\Models\Visitor;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->foreignIdFor(Visitor::class)->after('user_id')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('comments', function (Blueprint $table) {
            $table->dropForeign(['visitor_id']);
            $table->dropColumn('visitor_id');
        });
    }
};
