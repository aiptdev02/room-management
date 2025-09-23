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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('location');
            $table->text('details')->nullable();
            $table->json('photos')->nullable(); // store multiple photos as JSON array
            $table->timestamps();
            $table->softDeletes();
        });

        // Update rooms table to link with property
        Schema::table('rooms', function (Blueprint $table) {
            $table->foreignId('property_id')->nullable()->after('id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
