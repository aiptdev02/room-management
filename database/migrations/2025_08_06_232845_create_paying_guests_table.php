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
        Schema::create('paying_guests', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('phone');
            $table->string('email')->nullable();
            $table->string('photo')->nullable();
            $table->string('aadhar_number')->unique();
            $table->string('aadhar_front_photo')->nullable();
            $table->string('aadhar_back_photo')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('father_name')->nullable();
            $table->string('father_phone')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('mother_phone')->nullable();
            $table->string('emergency_number')->nullable();
            $table->text('permanent_address')->nullable();
            $table->string('occupation')->nullable();
            $table->date('joining_date')->nullable();
            $table->integer('expected_stay_duration')->nullable(); // in months
            $table->decimal('rent_amount', 8, 2)->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['active', 'left'])->default('active');
            $table->timestamps();
            $table->softDeletes(); // For soft delete functionality
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paying_guests');
    }
};
