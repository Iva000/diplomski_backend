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
        Schema::create('instructors', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('surname');
            $table->string('skiSchool');
            $table->integer('experience');
            $table->integer('price');
            $table->string('activity');
            $table->string('description');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phoneNumber');
            $table->integer('status');
            $table->string('photo');
            $table->foreignId('mountain_id')->constrained('mountains');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('instructors');
    }
};
