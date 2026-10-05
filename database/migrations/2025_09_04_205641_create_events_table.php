<?php

use App\Enums\Status;
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
        $statuses = array_map(
            static fn (Status $status): string => (string) $status->value,
            Status::cases(),
        );

        Schema::create('events', function (Blueprint $table) use ($statuses) {
            $table->id();
            $table->string('title');
            $table->string('slug');
            $table->text('description');
            $table->date('event_date');
            $table->date('event_date_end')->nullable();
            $table->string('location');
            $table->string('image')->nullable();
            $table->string('thumbnail')->nullable();
            $table->enum('status', $statuses)->default((string) Status::EDIT_DRAFT->value);
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
