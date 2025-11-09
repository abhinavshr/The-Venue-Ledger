<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('futsal_venues', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('address');
        $table->string('contact_email');
        $table->string('contact_phone');
        $table->string('logo_url')->nullable();
        $table->boolean('verification')->default(false);
        $table->foreignId('user_id')->constrained()->cascadeOnDelete(); 
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('futsal_venues');
    }
};