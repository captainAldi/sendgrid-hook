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
        Schema::create('delivery_event', function (Blueprint $table) {
            $table->id();
            $table->string('sender_identity');
            $table->string("email_to");
            $table->enum('event', ['Dropped', 'Delivered', 'Deferred', 'Bounce', 'Blocked']);
            $table->timestamp('timestamp', $precision = 0);
            $table->string('reason')->nullable();
            $table->string('response')->nullable();
            $table->integer('attempt')->nullable();
            $table->string('type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_event');
    }
};
