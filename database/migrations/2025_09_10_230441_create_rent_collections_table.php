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
        Schema::create('rent_collections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('paying_guest_id'); // guest
            $table->unsignedBigInteger('room_id')->nullable();
            $table->unsignedBigInteger('property_id')->nullable();
            $table->decimal('rent_amount', 10, 2);
            $table->decimal('electricity_charges', 10, 2)->nullable();
            $table->decimal('other_charges', 10, 2)->nullable();
            $table->string('month'); // e.g. "2025-09"
            $table->boolean('is_paid')->default(false);
            $table->timestamps();

            $table->foreign('paying_guest_id')->references('id')->on('paying_guests')->onDelete('cascade');
            $table->foreign('room_id')->references('id')->on('rooms')->onDelete('set null');
            $table->foreign('property_id')->references('id')->on('properties')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rent_collections');
    }
};
