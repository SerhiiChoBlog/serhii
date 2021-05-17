<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePageViewsTable extends Migration
{
    public function up(): void
    {
        Schema::create('page_views', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('visitor_id');
            $table->unsignedInteger('views')->default(1);
            $table->string('slug');
            $table->string('page_type');
            $table->timestamps();

            $table->foreign('visitor_id')->references('id')->on('visitors')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('page_views');
    }
}
