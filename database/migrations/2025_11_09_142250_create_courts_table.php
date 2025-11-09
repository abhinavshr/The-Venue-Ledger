<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('futsal_venue_id');
            $table->foreign('futsal_venue_id')
                  ->references('id')
                  ->on('futsal_venues')
                  ->onDelete('cascade');
            $table->string('name');
            $table->integer('capacity');
            $table->string('surface_type');
            $table->decimal('price_per_hour', 10, 2);
            $table->string('status')->default('available');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courts');
    }
};
