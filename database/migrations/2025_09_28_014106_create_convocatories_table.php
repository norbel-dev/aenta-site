<?php

use App\Enums\Media;
use App\Enums\Status;
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
        Schema::create('convocatories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('media', Media::cases())->default(Media::PDF);
            $table->date('date');
            $table->date('date_end')->nullable();
            $table->enum('status', Status::cases())->default(status::EDIT_DRAFT);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('convocatories');
    }
};
