<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('centers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('mission')->nullable();
            $table->text('vision')->nullable();
            $table->string('contact')->nullable();
            $table->string('address')->nullable();
            $table->text('tel')->nullable();
            $table->text('facebook')->nullable();
            $table->text('twiter')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('centers');
    }
};
