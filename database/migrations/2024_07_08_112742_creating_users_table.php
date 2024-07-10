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
            Schema::create('users', function (Blueprint $table) {
                $table->id();
                $table->string('username');
                $table->string('email');
                $table->string('password');
                $table->integer('phone');
                $table->bigInteger('nationalCode');
                $table->boolean('is_blocked')->default(false);
                $table->timestamps();
            });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
