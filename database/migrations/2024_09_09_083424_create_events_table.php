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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            
            $table->date('start_date');
            $table->date('end_date');

            $table->string('nepali_start_date');
            $table->string('nepali_end_date');
            
            $table->double('ticket_price')->nullable();

            $table->double('match_price_9')->nullable();
            $table->double('match_price_8')->nullable();
            $table->double('match_price_7')->nullable();
            $table->double('match_price_6')->nullable();
            $table->double('match_price_5')->nullable();

            $table->double('match_price_0')->nullable();

            $table->double('serial_match_price_9')->nullable();
            $table->double('serial_match_price_8')->nullable();
            $table->double('serial_match_price_7')->nullable();
            $table->double('serial_match_price_6')->nullable();
            $table->double('serial_match_price_5')->nullable();
            $table->double('serial_match_price_4')->nullable();

            $table->date('live_at_date');
            $table->string('nepali_live_at_date');

            $table->boolean('is_completed')->default(false);

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
