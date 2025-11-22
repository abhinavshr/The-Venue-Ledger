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
        Schema::create('schedule_exceptions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('court_id')
                ->constrained('courts')
                ->cascadeOnDelete();
            $table->string('type');  // 'closed' or 'specialRate'
            $table->date('date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->decimal('price_per_hour', 10, 2)->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->index(['court_id', 'date']);
        });
    }            

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedule_exceptions');
    }
};
