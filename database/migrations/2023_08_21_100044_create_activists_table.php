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
        Schema::create('activists', function (Blueprint $table) {
            $table->id();
            $table->string('identity_number');
            $table->enum('identity_type', ['nif', 'nie', 'other']);
            $table->string('picture_filename')->nullable();
            $table->string('first_name');
            $table->string('surname');
            $table->string('second_surname')->nullable();
            $table->string('full_name');
            $table->date('birth_date');
            $table->date('join_date');
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('second_phone')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('province')->nullable();
            $table->string('zip_code')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activists');
    }
};
