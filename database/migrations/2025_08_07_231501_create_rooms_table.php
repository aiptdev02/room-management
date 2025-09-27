<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('property_id');
            $table->string('room_number')->unique();
            $table->string('room_type')->nullable(); // e.g., Single, Double, Triple
            $table->integer('capacity')->default(1);
            $table->decimal('rent', 10, 2)->nullable();
            $table->string('floor')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_occupied')->default(false);
            $table->timestamps();
            $table->softDeletes(); // For soft delete functionality
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
